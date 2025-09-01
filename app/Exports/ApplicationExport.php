<?php

namespace App\Exports;

use App\Models\Application;
use App\Models\ApplicationType;
use App\Models\CodeMaster;
use App\Models\Helper;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ApplicationExport implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithEvents
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(string $txtRegNo,string $txtAppType,string $txtAppEntity,string $txtCompName,string $txtStatus,string $txtApplicantName,string $txtPremisState)
    {
        // $this->filter = $filter;
        $this->txtRegNo = $txtRegNo;
        $this->txtAppType = $txtAppType;
        $this->txtAppEntity = $txtAppEntity;
        $this->txtCompName = $txtCompName;
        $this->txtStatus = $txtStatus;
        $this->txtApplicantName = $txtApplicantName;
        $this->txtPremisState = $txtPremisState;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // $filter = $this->filter;
        $filterRegNo = $this->txtRegNo;
        $filterAppType = $this->txtAppType;
        $filterAppEntity = $this->txtAppEntity;
        $filterCompName = $this->txtCompName;
        $filterAppStatus = $this->txtStatus;
        $filterApplicant = $this->txtApplicantName;
        $filterAppState = $this->txtPremisState;

        $helper = new Helper();
        $status_saved = $helper->getCodeMasterIdByTypeName('application_status','Saved');
        $status_new = $helper->getCodeMasterIdByTypeName('application_status','New');

        $appType = ApplicationType::whereIn('type', ['1'])->select('id')->get();
		$appTypeArray = $appType->map(function ($item, $key) {
			return $item->id;
		});

        $applications = Application::query();
        $applications->whereNotNull('applications.user_id')
        ->whereNotIn('applications.application_status_id',[$status_new,$status_saved])
        ->whereIn('application_type_id',$appTypeArray)
        ->leftJoin('users as query1','applications.user_id','=','query1.id')
        ->leftJoin('application_transactions as query2','applications.id','=','query2.application_id')
        ->leftJoin('application_premises as query3','query2.application_premise_id','=','query3.id');

        //Filter
        if (!empty($filterRegNo)) {
            $applications->whereRaw('UPPER(applications.registration_no) like ?', ['%'.strtoupper($filterRegNo).'%']);
        }
        if (!empty($filterCompName)) {
			$applications->whereRaw('UPPER(applications.company_name) like ?', ['%'.strtoupper($filterCompName).'%']);
        }
        if (!empty($filterAppType)) {
			$applications->where('applications.application_type_id', $filterAppType);
        }
        if (!empty($filterAppStatus)) {
			$applications->where('applications.application_status_id', $filterAppStatus);
        }
        if (!empty($filterAppEntity)) {
			$applications->where('applications.entity_id', $filterAppEntity);
        }
        if (!empty($filterApplicant)) {
            $applications
            ->whereRaw('UPPER(query1.name) like ?', ['%'.strtoupper($filterApplicant).'%']);
        }
        if (!empty($filterAppState)) {
			$applications->where('query3.state_id', $filterAppState);
        }
        
        $applicationsData = $applications->select(
            'applications.company_name as companyName',
            'applications.company_address1',
            'applications.company_address2',
            'applications.company_address3',
            'applications.company_postcode',
            'applications.company_city',
            'applications.company_district_id',
            'applications.company_state_id',
            'applications.company_country_id',

            'query3.address1 as premisAddress1',
            'query3.address2 as premisAddress2',
            'query3.address3 as premisAddress3',
            'query3.postcode as premisPostcode',
            'query3.city as premisCity',
            'query3.district_id as premisDistrictId',
            'query3.state_id as premisStateId',
            'query3.country_id as premisCountryId',
            'applications.mobile_phone_no',
            'applications.fax_no',
            // 'applications.created_at',
            // approved',
            'query1.name',
            'query1.username',
            'query1.email',
            'applications.application_type_id',
            'applications.registration_no',
            'applications.application_status_id',
        )->orderBy('applications.updated_at','DESC')->get();

        $collection = new Collection();

        if (!empty($applicationsData)) {
            foreach ($applicationsData as $application) {
                $collection->push([
                    'companyName' => $application->companyName,
                    'companyAddress' => ($application->company_address2 != null ? rtrim($application->company_address1,",. ").', ' : '').
                    ($application->company_address2 != null ? rtrim($application->company_address2,",. ").', ' : '').
                    ($application->company_address3 != null ? rtrim($application->company_address3,",. ").', ' : '').
                    $application->company_postcode.' '.rtrim($application->company_city,",. ").', '.
                    ($application->company_district_id != null ? CodeMaster::find($application->company_district_id)->name.', ' : '').
                    ($application->company_state_id != null ? CodeMaster::find($application->company_state_id)->name.', ' : '').
                    ($application->company_country_id != null ? CodeMaster::find($application->company_country_id)->name : ''),

                    'premisAddress' => rtrim($application->premisAddress1,",. ").', '.
                    ($application->premisAddress2 != null ? rtrim($application->premisAddress2,",. ").', ' : '').
                    ($application->premisAddress3 != null ? rtrim($application->premisAddress3,",. ").', ' : '').
                    $application->premisPostcode.' '.rtrim($application->premisCity,",. ").', '.
                    ($application->premisDistrictId != null ? CodeMaster::find($application->premisDistrictId)->name.', ' : '').
                    ($application->premisStateId != null ? CodeMaster::find($application->premisStateId)->name.', ' : '').
                    ($application->premisCountryId != null ? CodeMaster::find($application->premisCountryId)->name : ''),

                    'premiseState' => $application->premisStateId != null ? CodeMaster::find($application->premisStateId)->name : '',
                    'phone' => $application->mobile_phone_no,
                    'fax' => $application->fax_no,
                    // 'appliedDate' => $application->created_at,
                    // 'approvedDate' => '',
                    'applicantName' => $application->name,
                    'applicantIC' => $application->username,
                    'applicantEmail' => $application->email,
                    'appType' => $application->application_type_id != null ? ApplicationType::find($application->application_type_id)->name_ms :'',
                    'registrationNo' => $application->registration_no,
                    'status' => $application->application_status_id != null ? CodeMaster::find($application->application_status_id)->name_ms :'',
                    // 'roles' => $application->roles->sortBy('name')->pluck('name')->implode(', '),
                    // 'status' => $application->is_active ? __('app.active') : __('app.inactive')
                ]);
            }
        }

        return $collection;
    }
 
    public function headings() : array
    {
        return [
            __('app.company_name'),
            'Alamat Syarikat',
            __('app.premise_address'),
            __('app.state'),
            __('app.phone_no'),
            __('app.fax_no'),
            // 'Tarikh Mohon',
            // 'Tarikh Lulus',
            'Nama',
            'No. Kad Pengenalan',
            'Email',
            // 'Spesis',
            // 'Keluaran Tahunan',
            // 'Sistem',
            // 'MyGAP',
            'Jenis Permohonan',
            'No. Pendaftaran',
            'Status',
        ];
    }

    public function title() : string
    {
        return __('module.applications');
    }

    public function registerEvents() : array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:P1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
            },
        ];
    }
}
