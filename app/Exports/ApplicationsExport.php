<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Application;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class ApplicationsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithEvents
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(string $txtDate,string $txtNoReg,string $txtName,string $txtCompanyName,string $txtPhoneNo,string $txtAppType,string $txtState,string $txtAppStatus) //string $filter
    {
        // $this->filter = $filter;
        $this->txtDate = $txtDate;
        $this->txtNoReg = $txtNoReg;
        $this->txtName = $txtName;
        $this->txtCompanyName = $txtCompanyName;
        $this->txtPhoneNo = $txtPhoneNo;
        $this->txtAppType = $txtAppType;
        $this->txtState = $txtState;
        $this->txtAppStatus = $txtAppStatus;

    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // $filter = $this->filter;
        $txtDate = $this->txtDate;
        $txtNoReg = $this->txtNoReg;
        $txtName= $this->txtName;
        $txtCompanyName = $this->txtCompanyName;
        $txtPhoneNo = $this->txtPhoneNo;
        $txtAppType = $this->txtAppType;
        $txtState = $this->txtState;
        $txtAppStatus = $this->txtAppStatus;

        // $users = User::query();
        // $users->where('is_admin', false);

        $applications = Application::query();

        //Filter
        if (!empty($txtDate)) {
            $applications->whereRaw('UPPER(applications.updated_at) like ?', ['%'.strtoupper($txtDate).'%']);
        }
        if (!empty($txtRegNo)) {
            $applications->whereRaw('UPPER(applications.registration_no) like ?', ['%'.strtoupper($txtNoReg).'%']);
        }
        //nama check
        if (!empty($txtName)) {
            $applications->whereRaw('UPPER(applications.user_id) like ?', ['%'.strtoupper($txtName).'%']);
        }
        if (!empty($txtCompanyName)) {
            $applications->whereRaw('UPPER(applications.company_name) like ?', ['%'.strtoupper($txtCompanyName).'%']);
        }
        if (!empty($txtPhoneNo)) {
            $applications->whereRaw('UPPER(applications.mobile_phone_no) like ?', ['%'.strtoupper($txtPhoneNo).'%']);
        }
        //check id
        if (!empty($txtAppType)) {
            $applications->whereRaw('UPPER(applications.application_type_id) like ?', ['%'.strtoupper($txtAppType).'%']);
        }
        if (!empty($txtState)) {
            $applications->whereRaw('UPPER(applications.state_id) like ?', ['%'.strtoupper($txtState).'%']);
        }
        if (!empty($txtAppStatus)) {
            $applications->whereRaw('UPPER(applications.application_status_id) like ?', ['%'.strtoupper($txtAppStatus).'%']);
        }


        // if (!empty($txtRoleId)) {
        //     $applications->whereHas('roles', function ($query) use ($txtRoleId) {
        //                 $query->where('id', '=', $txtRoleId); 
        //             });
        // }
        // if (!empty($txtEntityId)) {
        //     $applications->leftJoin('entities as query1','applications.entity_id','=','query1.id')
        //         ->whereRaw('query1.id::text like ?', [$txtEntityId]);
        // }
        
        $applicationsData = $applications->select(
            'applications.updated_at',
            'applications.registration_no',
            'applications.user_id',
            'applications.company_name',
            'applications.mobile_phone_no',
            'applications.application_type_id',
            'applications.state_id',
            'applications.application_status_id',
        )->orderBy('user_id')->get();

        // $users = User::whereHas('roles',
        //     function ($query) use ($filter) {
        //         $query->where('name', 'like', '%' . $filter . '%');
        //     })
        //     ->orWhere('name', 'like', '%' . $filter . '%')
        //     ->orWhere('username', 'like', '%' . $filter . '%')
        //     ->orWhere('email', 'like', '%' . $filter . '%')
        //     ->where('is_admin', false)
        //     ->orderBy('name')->get();

        $collection = new Collection();
        
        if (!empty($applicationsData)) {
            foreach ($applicationsData as $application) {
                $collection->push([
                    'date' => $application->date,
                    'registrationNo' => $application->registrationNo,
                    'name' => $application->name,
                    'companyName' => $application->companyName,
                    'applicationType' => $application->applicationType,
                    'state' => $application->state,
                    'status' => $application->status,

                    // 'roles' => $user->roles->sortBy('name')->pluck('name')->implode(', '),
                    // 'status' => $user->is_active ? __('app.active') : __('app.inactive')
                ]);
            }
        }

        // if (!empty($usersData)) {
        //     foreach ($usersData as $user) {
        //         $collection->push([
        //             'name' => $user->name,
        //             'username' => $user->username,
        //             'email' => $user->email,
        //             'roles' => $user->roles->sortBy('name')->pluck('name')->implode(', '),
        //             'status' => $user->is_active ? __('app.active') : __('app.inactive')
        //         ]);
        //     }
        // }

        return $collection;
    }
 
    public function headings() : array
    {
        return [
            __('app.updated_date'),
            __('app.company_reg_no'),
            __('app.name'),
            __('app.company_name'),
            __('app.application_type'),
            __('app.state'),
            __('app.status'),
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
                $cellRange = 'A1:E1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
            },
        ];
    }
}
