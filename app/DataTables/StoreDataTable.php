<?php

namespace App\DataTables;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class StoreDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function($query){
                // $btnShow = "<a class='btn btn-info' href='".route('position.show', $query->id)."'>Detail </a>";
                $btnEdit = "<a class='btn btn-warning' href='".route('store.edit', $query->id)."'>Ubah </a>";
                $btnDelete = "<a class='btn btn-danger delete-item' href='".route('store.destroy', $query->id)."'>Hapus </a>";

                // return $btnShow.$btnEdit.$btnDelete;
                return $btnEdit.$btnDelete;
            })
            ->addColumn('status', function($query){
                $active = '<i class="badge badge-success">Active</i>';
                $inactive = '<i class="badge badge-danger">Inactive</i>';

                if($query->status == 1){
                    // return $active;
                    return 'Active';
                }else{
                    // return $inactive;
                    return 'Inactive';
                }
            })
            ->addColumn('code' ,function($query){
                if($query->status_registration == 'Y'){
                    return 'RO-'.$query->code;
                }else{
                    return 'NRO-'.$query->code;
                }
            })
            ->rawColumns(['action', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Customer $model): QueryBuilder
    {
        return $model->newQuery()->where('type', 'S');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('store-table')
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
            // Column::make('id'),
            // Column::make('name'),
            // Column::make('created_at'),
            // Column::make('updated_at'),

            ['data' => 'DT_RowIndex', 'title' => '#'],
            ['data' => 'code', 'title' => 'kode'],
            ['data' => 'name', 'title' => 'nama'],
            ['data' => 'area', 'title' => 'area'],
            ['data' => 'subarea', 'title' => 'sub area'],
            ['data' => 'action', 'title' => 'Aksi', 'class' => 'text-center', 
            'exportable' => false, 'printable' => false]
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Store_' . date('YmdHis');
    }
}
