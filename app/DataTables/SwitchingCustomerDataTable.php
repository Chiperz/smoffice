<?php

namespace App\DataTables;

use App\Models\HeaderVisit;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SwitchingCustomerDataTable extends DataTable
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
                // return date('d-m-Y', strtotime($query->date));
                return $query->date;
            })
            ->addColumn('code', function($query){
                return $query->customer->code != null ? $query->customer->code : '';
            })
            ->addColumn('cust_name', function($query){
                return $query->customer->name != null ? $query->customer->name : '';
            })
            ->addColumn('before', function($query){
                return $query->switching->status_before;
            })
            ->addColumn('after', function($query){
                return $query->switching->status_after;
            })
            ->addColumn('action', 'switchingcustomer.action')
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(HeaderVisit $model): QueryBuilder
    {
        return $model->newQuery()
            ->with('customer')
            ->with('switching');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('switchingcustomer-table')
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
            ['data' => 'DT_RowIndex', 'title' => '#', 'class' => 'text-center', 
            'exportable' => false, 'printable' => false, 'searchable' => false, 'visible' => true],
            ['data' => 'date', 'title' => 'tanggal'],
            ['data' => 'code', 'title' => 'kode'],
            ['data' => 'cust_name', 'title' => 'nama'],
            ['data' => 'before', 'title' => 'sebelumnya'],
            ['data' => 'after', 'title' => 'menjadi'],
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SwitchingCustomer_' . date('YmdHis');
    }
}
