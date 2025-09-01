<?php

namespace App\Exports\LandingDeclaration;

use App\Models\Helper;
use App\Models\LandingDeclaration\LandingDeclaration;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class LandingExport implements FromCollection, ShouldAutoSize, WithTitle, WithEvents, WithMapping//WithHeadings,
{
    protected $userId;
    protected $year;
    protected $month;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(string $userId,string $year,string $month)
    {
        $this->userId = $userId;
        $this->year = $year;
        $this->month = $month;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // $helper = new Helper();
        // $statusDisimpanId = $helper->getCodeMasterIdByTypeName('landing_status','DISIMPAN');

        $userId = $this->userId;
        $year = $this->year;
        $month = $this->month;

        $landingDeclarations = LandingDeclaration::
        leftJoin('landing_infos','landing_declarations.id','landing_infos.landing_declaration_id')
        ->leftJoin('landing_info_activities','landing_infos.id','landing_info_activities.landing_info_id')
        ->leftJoin('landing_activity_types','landing_info_activities.landing_activity_type_id','landing_activity_types.id')
        ->leftJoin('landing_water_types','landing_info_activities.landing_water_type_id','landing_water_types.id')
        ->leftJoin('code_masters as state','landing_info_activities.state_id','state.id')
        ->leftJoin('code_masters as district','landing_info_activities.district_id','district.id')
        ->leftJoin('landing_activity_species','landing_activity_species.landing_info_activity_id','landing_info_activities.id')
        ->leftJoin('species','landing_activity_species.species_id','species.id')
        ->where('landing_declarations.user_id',$userId)
        ->where('year',$year)
        ->where('month',$month)
        // ->whereNot('landing_declarations.landing_status_id',$statusDisimpanId)
        ->orderBy('landing_date')
        ->orderBy('time')
        ->select(
            'landing_declarations.week',
            'landing_infos.landing_date',
            'landing_info_activities.time',
            'landing_activity_types.name as activity',
            'landing_info_activities.equipment',
            'state.name as state',
            'district.name as district',
            'landing_info_activities.location_name',
            'landing_water_types.name as water',
            'species.common_name',
            'landing_activity_species.weight',
            'landing_activity_species.price_per_weight',
            DB::raw('landing_activity_species.weight * landing_activity_species.price_per_weight AS product')
            )->get();

        $landingData = new Collection();

        if (!empty($landingDeclarations)) {
            foreach ($landingDeclarations as $ld) {
                $landingData->push([
                    'type' => 'data', // Flag for data row
                    'week' => $ld->week,
                    'date' => $ld->landing_date,
                    'time' => $ld->time ?? '-',
                    'activity' => $ld->activity ?? '-Tiada Aktiviti-',
                    'equipment' => $ld->equipment ?? '-',
                    'state' => $ld->state ?? '-',
                    'district' => $ld->district ?? '-',
                    'location_name' => $ld->location_name ?? '-',
                    'water' => $ld->water ?? '-',
                    'common_name' => $ld->common_name ?? '-',
                    'weight' => $ld->weight ?? '-',
                    'price_per_weight' => $ld->price_per_weight ?? '-',
                    'product' => $ld->product ?? '-',
                ]);
            }
        }

        $user = User::find($userId);

        // 1. Prepare your custom header rows as collections or arrays
        $customRows = collect([
            // Row 1: Report Title (spanning multiple columns)
            // Use an array with empty strings for columns you don't want text in
            [
                'type' => 'header',
                'v1' => 'Nama:',
                'v2' => $user->name,
                'v3' => '', 'v4' => '', 'v5' => '', 'v6' => '', 'v7' => '',
                'v8' => '', 'v9' => '', 'v10' => '', 'v11' => '', 'v12' => '', 'v13' => ''
            ], // Assuming 13 columns in your actual data

            [
                'type' => 'header',
                'v1' => 'No Kad Pengenalan:',
                'v2' => '\''.$user->username,
                'v3' => '', 'v4' => '', 'v5' => '', 'v6' => '', 'v7' => '',
                'v8' => '', 'v9' => '', 'v10' => '', 'v11' => '', 'v12' => '', 'v13' => ''
            ],

            [
                'type' => 'header',
                'v1' => 'Tarikh Dijana:',
                'v2' => Carbon::now()->format('Y-m-d H:i:s'),
                'v3' => '', 'v4' => '', 'v5' => '', 'v6' => '', 'v7' => '',
                'v8' => '', 'v9' => '', 'v10' => '', 'v11' => '', 'v12' => '', 'v13' => ''
            ],

            // Row 4: Empty row for spacing
            [
                'type' => 'header',
                'v1' => '',
                'v2' => '',
                'v3' => '', 'v4' => '', 'v5' => '', 'v6' => '', 'v7' => '',
                'v8' => '', 'v9' => '', 'v10' => '', 'v11' => '', 'v12' => '', 'v13' => ''
            ],
            // Row 5: data header
            [
                'type' => 'header',
                'v1' => 'Minggu',
                'v2' => 'Tarikh',
                'v3' => 'Masa',
                'v4' => 'Aktiviti',
                'v5' => 'Peralatan',
                'v6' => 'Negeri',
                'v7' => 'Daerah',
                'v8' => 'Lokasi',
                'v9' => 'Jenis Perairan',
                'v10' => 'Spesies',
                'v11' => 'Berat(Kg)',
                'v12' => 'Harga(RM/Kg)',
                'v13' => 'Jumlah(RM)'
            ],
        ]);

        // Merge custom rows with actual data rows
        return $customRows->merge($landingData);
        // return $collection;
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        // Maatwebsite/Excel will call `map` for *every* row in the collection,
        // including your custom header rows.
        // You need to detect if it's a custom row or actual data.

        // check the 'type' key to differentiate
        if (isset($row['type']) && $row['type'] === 'data') {
            // This is a data row
            return [
                $row['week'],
                $row['date'],
                $row['time'],
                $row['activity'],
                $row['equipment'],
                $row['state'],
                $row['district'],
                $row['location_name'],
                $row['water'],
                $row['common_name'],
                $row['weight'],
                $row['price_per_weight'],
                $row['product'],
            ];
        } elseif (isset($row['type']) && $row['type'] === 'header') {
            // This is a custom header row
            // Remove the 'type' key before returning to Excel
            unset($row['type']);
            return array_values($row); // Return values to ensure correct column order
        }

        // Fallback for any unexpected rows (shouldn't happen with this setup)
        return [];
    }

    // public function headings() : array
    // {
    //     return [
    //         'Minggu',
    //         'Tarikh',
    //         'Masa',
    //         'Aktiviti',
    //         'Peralatan',
    //         'Negeri',
    //         'Daerah',
    //         'Lokasi',
    //         'Jenis Perairan',
    //         'Spesis',
    //         'Berat(Kg)',
    //         'Harga(RM/Kg)',
    //         'Jumlah(RM)',
    //     ];
    // }

    public function title() : string
    {
        return 'Pengisytiharan Pendaratan';
    }

    public function registerEvents() : array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A5:M5';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
            },
        ];
    }
}
