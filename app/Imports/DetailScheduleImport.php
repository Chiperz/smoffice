<?php

namespace App\Imports;

use App\Models\Customer;
use App\Models\ScheduleVisit;
use Illuminate\Support\Collection;
use App\Models\DetailScheduleVisit;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class DetailScheduleImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows){
        foreach($rows as $row){
            DetailScheduleVisit::create([
                'schedule_visit_id' => ScheduleVisit::where('name', $row['Nama Jadwal'])->first()->id,
                'customer_id' => Customer::where('code', $row['Kode Pelanggan'])->first()->id
            ]);
        }
    }
}
