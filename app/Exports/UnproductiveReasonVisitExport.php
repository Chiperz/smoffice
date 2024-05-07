<?php

namespace App\Exports;

use App\Models\HeaderVisit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UnproductiveReasonVisitExport implements FromCollection ,WithMapping, WithHeadings
{
    protected $from, $to, $staff;
    function __construct($from, $to, $staff){
        $this->from = $from;
        $this->to = $to;
        $this->staff = $staff;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = HeaderVisit::with('user')
        ->with('customer')
        ->with('outlet_reason')
        ->orWhereHas('outlet_reason', function($query){
            $query->where('unproductive_reason_id', '!=', null);
        });
        $query->whereBetween('date', [$this->from, $this->to]);
        if($this->staff != NULL){
            $query->where('user_id', $this->staff);
        }

        return $query->get();
    }

    public function map($headervisit): array
    {
        return[
            date('d/m/Y', strtotime($headervisit->date)),
            $headervisit->user->name,
            $headervisit->customer->code,
            $headervisit->customer->name,
            implode(",", collect($headervisit->outlet_reason)
                    ->reduce(function($acc, $i) {
                        $acc[] = 
                        $i->unproductive_reason->name;
                        return array_unique($acc);
                    }, 
            [])),
        ];
    }

    public function headings(): array{
        return [
            'Tanggal Kunjungan',
            'Nama Staff',
            'Kode',
            'Nama',
            'Alasan Tidak Produktif'
        ];
    }
}
