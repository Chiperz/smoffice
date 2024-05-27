<?php

namespace App\Exports;

use App\Models\HeaderVisit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportSwitchingOutletExport implements FromCollection ,WithMapping, WithHeadings
{
    protected $from, $to;
    function __construct($from, $to){
        $this->from = $from;
        $this->to = $to;
    }

    public function collection()
    {
        $query = HeaderVisit::with('customer')
        ->with('customer')
        ->with('status_changed')
        ->orWhereHas('status_changed', function($query){
            $query->where('status_before', '!=', null);
        });
        $query->whereBetween('date', [$this->from, $this->to]);
        // if($this->staff != NULL){
        //     $query->where('user_id', $this->staff);
        // }

        return $query->get();
    }

    public function map($headervisit): array
    {
        $statusBefore;$statusAfter;
        if($headervisit->status_changed->status_before == 'Y'){
            $statusBefore = 'SMClub';
        }elseif($headervisit->status_changed->status_before == 'M'){
            $statusBefore = 'Mixing';
        }else{
            $statusBefore = 'Non-SMClub';
        }

        if($headervisit->status_changed->status_after == 'Y'){
            $statusAfter = 'SMClub';
        }elseif($headervisit->status_changed->status_after == 'M'){
            $statusAfter = 'Mixing';
        }else{
            $statusAfter = 'Non-SMClub';
        }

        return[
            date('d/m/Y', strtotime($headervisit->date)),
            $headervisit->customer->code,
            $headervisit->customer->name,
            $statusBefore,
            $statusAfter
        ];
    }

    public function headings(): array{
        return [
            'Tanggal Perubahan',
            'Kode',
            'Nama',
            'Status Sebelumnya',
            'Status Sekarang'
        ];
    }
}
