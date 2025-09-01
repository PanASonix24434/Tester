<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class UserExport implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle, WithEvents
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(string $filter)
    {
        $this->filter = $filter;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $filter = $this->filter;

        $user = User::whereNotNull('users.updated_by')
        ->leftjoin('entities as e', 'users.entity_id','=','e.id')
        ->select('users.*', 'e.entity_name');
        
        $users= $user->orderBy('name')->get();

        $collection = new Collection();

        if (!empty($users)) {
            foreach ($users as $user) {
                $collection->push([
                    'name' => $user->name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'roles' => $user->roles->sortBy('name')->pluck('name')->implode(', '),
                    'entity' => $user->entity_name,
                    'status' => $user->is_active ? __('app.active') : __('app.inactive')
                ]);
            }
        }

        return $collection;
    }
 
    public function headings() : array
    {
        return [
            'Nama Penuh',
            'No. Kad Pengenalan',
            'Emel',
            'Peranan',
            'Pejabat Bertugas',
            'Status'
        ];
    }

    public function title() : string
    {
        return __('module.users');
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
