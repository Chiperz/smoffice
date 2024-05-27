<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OutletExport implements FromCollection ,WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function collection()
    {
        return Customer::where('type', 'O')->get();
    }

    public function map($outlet): array
    {
        $status;
        if($outlet->status_registration == 'Y'){
            $status = 'SMClub';
        }elseif($outlet->status_registration == 'M'){
            $status = 'Mixing';
        }else{
            $status = 'Non-SM';
        }

        return [
            $outlet->code,
            $outlet->name,
            $outlet->phone,
            $outlet->address,
            $outlet->LA,
            $outlet->LO,
            $status,
            $outlet->banner == 1 ? 'Sudah Pasang' : 'Belum Pasang',
            empty($outlet->deploy_area) ? '' : $outlet->deploy_area->name,
            empty($outlet->deploy_sub_area) ? '' : $outlet->deploy_sub_area->name,
            empty($outlet->deploy_branch) ? '' : $outlet->deploy_branch->name,
        ];
    }

    public function headings(): array{
        return [
            'Kode',
            'Nama',
            'No. Telfon',
            'Alamat',
            'Latitude',
            'Longitude',
            'Status Gerai',
            'Spanduk',
            'Area',
            'Sub Area',
            'Cabang'
        ];
    }
}
