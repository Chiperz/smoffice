<?php

namespace App\DataTables;

use App\Models\SubArea;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

use Illuminate\Support\Facades\Auth;

class SubAreaDataTable extends DataTable
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
            ->addColumn('branch', function($query){
                return $query->branch->name;
            })
            ->addColumn('area', function($query){
                return $query->area->name;
            })
            ->addColumn('action', function($query){
                // $btnShow = "<a class='btn btn-info' href='".route('position.show', $query->id)."'>Detail </a>";
                $btnEdit = "<a class='btn btn-warning' href='".route('subarea.edit', $query->id)."'>Ubah </a>";
                $btnDelete = "<a class='btn btn-danger delete-item' href='".route('subarea.destroy', $query->id)."'>Hapus </a>";

                // return $btnShow.$btnEdit.$btnDelete;
                if(Auth::user()->hasPermissionTo('sub_area edit') && Auth::user()->hasPermissionTo('sub_area delete')){
                    return $btnEdit.'&nbsp'.$btnDelete;
                }elseif(Auth::user()->hasPermissionTo('sub_area edit')){
                    return $btnEdit;
                }elseif(Auth::user()->hasPermissionTo('sub_area delete')){
                    return $btnDelete;
                }else{
                    return '';
                }
            })
            ->rawColumns(['action','branch','area'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SubArea $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('subarea-table')
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
            'exportable' => false, 'printable' => false, 'searchable' => false],
            ['data' => 'branch', 'title' => 'cabang'],
            ['data' => 'area', 'title' => 'area'],
            ['data' => 'name', 'title' => 'nama'],
            ['data' => 'action', 'title' => 'aksi', 'class' => 'text-center', 
            'exportable' => false, 'printable' => false, 'searchable' => false]
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SubArea_' . date('YmdHis');
    }
}
