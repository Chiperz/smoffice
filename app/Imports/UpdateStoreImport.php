<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Customer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class UpdateStoreImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        // dd($rows);
        foreach($rows as $row){
            if($row['Status Display'] == "Y"){
                $status = true;
            }else{
                $status = false;
            }
            $customer = Customer::where('code', $row['Kode Pelanggan'])
                ->update([
                    'status_display' => $status, 
                    'date_display' => $row['Tanggal Display']
                ]);
        }
    }
}
