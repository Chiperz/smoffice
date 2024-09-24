<?php

namespace App\DataTables;

use App\Models\Customer;
use App\Models\DetailStoreVisit;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class StoreHasDisplayDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('date', function($query){
                return date('d F Y', strtotime($query->visit()->whereHas('detail_store')->latest()->first()->date));
            })
            ->addColumn('category', function($query){
                $dataVisit = $query->visit()->whereHas('detail_store')->latest()->first()->id;
                $data ='';
                $categories = DetailStoreVisit::where('header_visit_id', $dataVisit)->distinct()->get('category_product_id');
                // return DetailStoreVisit::where('header_visit_id', $dataVisit)->get('category_product_id');
                foreach($categories as $number => $row){
                    $data .= $number == 0 ? $row->category->name : ', '.$row->category->name;
                }
                return $data;
            })
            ->addColumn('display', function($query){
                $dataVisit = $query->visit()->whereHas('detail_store')->latest()->first()->id;
                $data ='';
                $displays = DetailStoreVisit::where('header_visit_id', $dataVisit)->distinct()->get('display_product_id');
                // return DetailStoreVisit::where('header_visit_id', $dataVisit)->get('category_product_id');
                foreach($displays as $number => $row){
                    $data .= $number == 0 ? $row->display->name : ', '.$row->display->name;
                }
                return $data;
            })
            ->addColumn('display', function($query){
                $dataVisit = $query->visit()->whereHas('detail_store')->latest()->first()->id;
                $data ='';
                $displays = DetailStoreVisit::where('header_visit_id', $dataVisit)->distinct()->get('display_product_id');
                // return DetailStoreVisit::where('header_visit_id', $dataVisit)->get('category_product_id');
                foreach($displays as $number => $row){
                    $data .= $number == 0 ? $row->display->name : ', '.$row->display->name;
                }
                return $data;
            })
            ->addColumn('action', function($query){
                $btnShow = "<a class='btn btn-info' href='".route('visit.show', $query->visit()->whereHas('detail_store')->latest()->first()->id)."'>Detail </a>";
                return $btnShow;
            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Customer $model): QueryBuilder
    {

        return $model->newQuery()
            ->where('type', 'S')
            ->where('branch_id', $this->id)
            ->whereHas('visit', function ($query){
                return $query
                    ->whereNotNull('time_out')
                    ->whereHas('detail_store', function ($q){
                        return $q->whereNotNull('category_product_id');
                    });
            })
            ->latest();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('storehasdisplay-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        // Button::make('excel'),
                        // Button::make('csv'),
                        // Button::make('pdf'),
                        // Button::make('print'),
                        // Button::make('reset'),
                        // Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('code')
                ->title('kode'),
            Column::make('name')
                ->title('nama'),
            Column::make('date')
                ->title('tanggal visit'),
            Column::make('display')
                ->title('jenis display'),
            Column::make('category')
                ->title('kategori display'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'StoreHasDisplay_' . date('YmdHis');
    }
}
