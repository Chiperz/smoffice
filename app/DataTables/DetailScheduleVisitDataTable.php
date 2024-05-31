<?php

namespace App\DataTables;

use App\Models\DetailScheduleVisit;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DetailScheduleVisitDataTable extends DataTable
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
            ->addColumn('code', function($query){
                return $query->customer->code;
            })
            ->addColumn('name', function($query){
                return $query->customer->name;
            })
            ->addColumn('branch', function($query){
                return $query->customer->deploy_branch->name;
            })
            ->addColumn('area', function($query){
                return $query->customer->deploy_area != NULL ? $query->customer->deploy_area->name : '';
            })
            ->addColumn('subarea', function($query){
                return $query->customer->deploy_sub_area != NULL ? $query->customer->deploy_sub_area->name : '';
            })
            ->addColumn('action', function($query){
                // $btnShow = "<a class='btn btn-info' href='".route('schedule-visit.show', $query->id)."'>Detail </a>";
                // $btnEdit = "<a class='btn btn-warning' href='".route('schedule-visit.edit', $query->id)."'>Ubah </a>";
                $btnDelete = "<a class='btn btn-danger delete-item' href='".route('schedule-visit.destroy', $query->id)."'>Hapus </a>";

                // return $btnShow.$btnEdit.$btnDelete;
                // if(Auth::user()->hasPermissionTo('schedule-visit edit') && Auth::user()->hasPermissionTo('schedule-visit view') && Auth::user()->hasPermissionTo('schedule-visit delete')){
                //     return $btnShow.'&nbsp'.$btnEdit.'&nbsp'.$btnDelete;
                // }elseif(Auth::user()->hasPermissionTo('schedule-visit edit')){
                //     return $btnEdit;
                // }elseif(Auth::user()->hasPermissionTo('schedule-visit delete')){
                //     return $btnDelete;
                // }else{
                //     return '';
                // }
                return $btnDelete;
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(DetailScheduleVisit $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('detailschedulevisit-table')
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
            ['data' => 'code', 'title' => 'kode'],
            ['data' => 'name', 'title' => 'nama'],
            ['data' => 'area', 'title' => 'area'],
            ['data' => 'subarea', 'title' => 'sub area'],
            ['data' => 'branch', 'title' => 'cabang'],
            ['data' => 'action', 'title' => 'aksi', 'class' => 'text-center', 
            'exportable' => false, 'printable' => false, 'searchable' => false]
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'DetailScheduleVisit_' . date('YmdHis');
    }
}
