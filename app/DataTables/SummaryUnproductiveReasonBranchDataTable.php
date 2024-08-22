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

class SummaryUnproductiveReasonBranchDataTable extends DataTable
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
            // ->addColumn('branch', function($query){
            //     return $query->visit->customer->deploy_branch->name;
            // })
            // ->addColumn('staff', function($query){
            //     return $query->visit->user->name;
            // })
            // ->addColumn('reason', function($query){
            //     return $query->unproductive_reason->name;
            // })
            ->addColumn('date', function($query){
                return date('d F Y', strtotime($query->date));
            })
            ->addColumn('code', function($query){
                return $query->customer->code;
            })
            ->addColumn('name', function($query){
                return $query->customer->name;
            })
            ->addColumn('staff', function($query){
                return $query->user->name;
            })
            ->addColumn('store_reason', function($query){
                $details = $query->store_reason()->get();
                $data = '';

                foreach($details as $number => $row){
                    $data .= $number == 0 ? $row->unproductive_reason->name : ', '.$row->unproductive_reason->name;
                }

                return $data;
            })
            // ->addColumn('action', 'summaryunproductivereasonbranch.action')
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(HeaderVisit $model): QueryBuilder
    {
        return $model
            // ->groupBy('user_id')
            ->whereHas('customer', function($filter){
                $filter->where('type', 'S');
            })
            ->whereHas('store_reason', function($filter){
                $filter->where('unproductive_reason_id', '!=', NULL);
            })
            ->orderBy('date', 'DESC')
            ->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('summaryunproductivereasonbranch-table')
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
            Column::make('no')
                ->data('DT_RowIndex')
                ->orderable(false)
                ->searchable(false),
            // Column::make('branch'),
            Column::make('date'),
            Column::make('code'),
            Column::make('name'),
            Column::make('staff'),
            Column::make('store_reason'),
            // Column::computed('action')
            //       ->exportable(false)
            //       ->printable(false)
            //       ->width(60)
            //       ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SummaryUnproductiveReasonBranch_' . date('YmdHis');
    }
}
