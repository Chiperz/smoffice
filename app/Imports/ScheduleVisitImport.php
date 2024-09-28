<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ScheduleVisitImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Master Schedule' => new MasterScheduleImport(),
            'Detail Schedule' => new DetailScheduleImport(),
        ];
    }
}
