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

    public function map($store): array
    {
        return [
            $store->code,
            $store->name,
            $store->phone,
            $store->address,
            $store->LA,
            $store->LO,
            empty($store->deploy_area) ? '' : $store->deploy_area->name,
            empty($store->deploy_sub_area) ? '' : $store->deploy_sub_area->name,
            empty($store->deploy_branch) ? '' : $store->deploy_branch->name,
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
            'Area',
            'Sub Area',
            'Cabang'
        ];
    }
}
