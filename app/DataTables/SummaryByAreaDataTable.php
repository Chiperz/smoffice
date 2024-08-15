<?php

namespace App\DataTables;

use App\Models\Area;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SummaryByAreaDataTable extends DataTable
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
                $btnShow = "<a class='btn btn-info' href='".route('summary-area', $query->id)."'>Detail </a>";
                // $btnEdit = "<a class='btn btn-warning' href='".route('subarea.edit', $query->id)."'>Ubah </a>";
                // $btnDelete = "<a class='btn btn-danger delete-item' href='".route('subarea.destroy', $query->id)."'>Hapus </a>";

                // return $btnShow.$btnEdit.$btnDelete;
                return $btnShow;
            })
            ->addColumn('outlet_regist', function($query){
                return $query->customer()->where(['type' => 'O', 'status_registration' => 'Y'])->count();
            })
            ->addColumn('outlet_mixing', function($query){
                return $query->customer()->where(['type' => 'O', 'status_registration' => 'M'])->count();
            })
            ->addColumn('outlet_non_regist', function($query){
                return $query->customer()->where(['type' => 'O', 'status_registration' => 'N'])->count();
            })
            ->addColumn('visited', function($query){
                $customers = $query->customer()->where('type', 'O')->get();
                $visited = '';
                foreach($customers as $customer){
                    $visited = intval($visited)+$customer->visit()->whereMonth('date', date('m'))->count();
                }
                return $visited;
            })
            ->addColumn('switch', function($query){
                $customers = $query->customer()->where('type', 'O')->get();
                $switched = '';
                foreach($customers as $customer){
                    $visit = $customer->visit()->whereMonth('date', date('m'))->get();
                    foreach($visit as $row){
                        $switched = intval($switched)+$row->status_changed()->where('status_after', 'Y')->count();
                    }
                }
                return $switched;
            })
            ->addColumn('precentage', function($query){
                $customers = $query->customer()->where('type', 'O')->get();
                $visited = '';$switched = '';
                foreach($customers as $customer){
                    $visited = intval($visited)+$customer->visit()->whereMonth('date', date('m'))->count();
                }
                foreach($customers as $customer){
                    $visit = $customer->visit()->whereMonth('date', date('m'))->get();
                    foreach($visit as $row){
                        $switched = intval($switched)+$row->status_changed()->where('status_after', 'Y')->count();
                    }
                }

                if($switched == 0 || $switched == NULL){
                    return '0%';
                }elseif($visited == 0 || $visited == NULL){
                    return '0%';
                }else{
                    return round(intval($switched)/intval($visited), 2).'%';
                }

            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Area $model): QueryBuilder
    {
        return $model
            ->where('branch_id', request()->id)
            ->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('summarybyarea-table')
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
                ->searchable('false')
                ->orderable('false'),
            Column::make('name'),
            Column::make('outlet_regist')
                ->title('smclub'),
            Column::make('outlet_mixing')
                ->title('mixing'),
            Column::make('outlet_non_regist')
                ->title('non-smclub'),
            Column::make('visited')
                ->title('terkunjungi(bulan ini)'),
            Column::make('switch')
                ->title('yang menjadi smclub(bulan ini)'),
            Column::make('precentage')
                ->title('%'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(200)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SummaryByArea_' . date('YmdHis');
    }
}
