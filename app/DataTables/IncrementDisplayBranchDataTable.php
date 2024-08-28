<?php

namespace App\DataTables;

use App\Models\DetailStoreVisit;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class IncrementDisplayBranchDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'incrementdisplaybranch.action')
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(DetailStoreVisit $model): QueryBuilder
    {
        $id = request()->id;
        $dateFrom = request()->dateFrom;
        $dateTo = request()->dateTo;
        // return $model->newQuery();
        return $model->selectRaw('
            COUNT(detail_store_visits.display_product_id) as count_display,
            detail_store_visits.display_product_id as display_id,
            display_products.name as display_name, 
            MONTHNAME(detail_store_visits.created_at) as month,
            MONTH(detail_store_visits.created_at) as serial
        ')
        ->join('display_products', 'display_products.id', 'detail_store_visits.display_product_id')
        ->whereHas('header_visit', function($query) use ($id){
            $query->whereHas('customer', function($q) use ($id){
                $q->where('branch_id', $id);
            });
        })
        ->whereBetween('detail_store_visits.created_at', [
            $dateFrom,
            $dateTo
        ])
        ->groupBy('display_product_id', 'display_name','month','serial')
        ->orderBy('serial', 'asc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('incrementdisplaybranch-table')
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
            // Column::computed('action')
            //       ->exportable(false)
            //       ->printable(false)
            //       ->width(60)
            //       ->addClass('text-center'),
            Column::make('month'),
            Column::make('display_name'),
            Column::make('count_display'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'IncrementDisplayBranch_' . date('YmdHis');
    }
}
