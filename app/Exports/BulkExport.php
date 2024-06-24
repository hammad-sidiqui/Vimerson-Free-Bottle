<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

// Models
use App\User;

class BulkExport implements FromQuery, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {                
        return [
            'ID',
            'first_name',
            'last_name',
            'email',
            'phone_number',
            'created_at',
            'updated_at',
        ];
    }

    public function query()
    {
        return User::query();
    }

    public function map($bulk): array
    {        
        return [
            $bulk->id,
            $bulk->first_name,
            $bulk->last_name,
            $bulk->email,
            $bulk->phone_number,
            Date::dateTimeToExcel($bulk->created_at),
            Date::dateTimeToExcel($bulk->updated_at),
        ];
    }
}
