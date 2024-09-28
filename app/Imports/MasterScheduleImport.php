<?php

namespace App\Imports;

use App\Models\User;
use App\Models\ScheduleVisit;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class MasterScheduleImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows){
        foreach($rows as $row){
            ScheduleVisit::create([
                'name' => $row['Nama Jadwal'],
                'date_start' => $row['Tanggal'],
                'date_end' => $row['Tanggal'],
                'looping' => 1,
                'looping_type' => 'O',
                'user_id' => User::where('name', $row['Nama Staff'])->first()->id,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
