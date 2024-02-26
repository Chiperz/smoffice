<?php

namespace App\DataTables;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BranchDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function($query){
                // $btnShow = "<a class='btn btn-info' href='".route('branch.show', $query->id)."'>Detail </a>";
                $btnEdit = "<a class='btn btn-warning' href='".route('branch.edit', $query->id)."'>Ubah </a>";
                $btnDelete = "<a class='btn btn-danger' href='".route('branch.destroy', $query->id)."'>Hapus </a>";

                // return $btnShow.$btnEdit.$btnDelete;
                return $btnEdit.$btnDelete;
            })
            // ->addIndexColumn('no', function($query){
            //     return 'DT_RowIndex';
            // })
            // ->addColumn('no', function(){
            //     return $no = 'DT_RowIndex';
            // })
            ->addIndexColumn()
            // ->make(true);
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Branch $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('branch-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->addIndex()
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
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
            'no' => 'DT_RowIndex',
            Column::make('id'),
            Column::make('code'),
            Column::make('name'),
            Column::make('notes'),
            // Column::make('created_at'),
            // Column::make('updated_at'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(300)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Branch_' . date('YmdHis');
    }
}
