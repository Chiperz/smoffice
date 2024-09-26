<?php

namespace App\DataTables;

use App\Models\Area;
use App\Models\Customer;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class SummaryStoreHasVisitedDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('visited', function($query){
                $data = Customer::where(['area_id' => $query->id], ['type' => 'S'])
                    ->whereHas('visit', function($q){
                        return $q->whereNotNull('time_out');
                    })->count();
                return $data;
            })
            ->addColumn('all', function($query){
                return $query->customer()->where('type', 'S')->count();
            })
            ->addColumn('precentage', function($query){
                $visited = Customer::where(['area_id' => $query->id], ['type' => 'S'])
                ->whereHas('visit', function($q){
                    return $q->whereNotNull('time_out');
                })->count();
                $all = $query->customer()->where('type', 'S')->count();
                return $data = number_format(($visited/$all)*100 ,2)."%";
            })
            ->addColumn('action', function($query){
                $btnShow = "<a class='btn btn-info' href=''>Detail </a>";
                return $btnShow;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Area $model): QueryBuilder
    {
        return $model->newQuery()
            ->where('branch_id', $this->id);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('summarystorehasvisited-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(0)
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
            Column::make('name'),
            Column::make('visited'),
            Column::make('all'),
            Column::make('precentage'),
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
        return 'SummaryStoreHasVisited_' . date('YmdHis');
    }
}
