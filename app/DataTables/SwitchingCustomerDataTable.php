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
use Illuminate\Http\Request;

class SwitchingCustomerDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query, Request $request): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('start_date'))) {
                    $instance->whereBetween('date', [$request->get('start_date'),$request->get('end_date') ]);
                }
                if (!empty($request->get('end_date'))) {
                    $instance->whereBetween('date', [$request->get('start_date'),$request->get('end_date') ]);
                }
                if (!empty($request->get('search'))) {
                    $instance->where(function($w) use($request){
                       $search = $request->get('search');
                       $w->whereHas('customer', function($q) use ($search){
                        $q->where('code', 'LIKE', '%'.$search.'%')
                            ->orWhere('name', 'LIKE', '%'.$search.'%');
                       });
                   });
               }
            })
            ->addColumn('date', function($query){
                return date('d-m-Y', strtotime($query->date));
                // return $query->date;
            })
            ->addColumn('code', function($query){
                return $query->customer->code != null ? $query->customer->code : '';
            })
            ->addColumn('cust_name', function($query){
                return $query->customer->name != null ? $query->customer->name : '';
            })
            ->addColumn('before', function($query){
                if($query->status_changed->status_before == 'Y'){
                    return 'SMClub';
                }elseif($query->status_changed->status_before == 'M'){
                    return 'Mixing';
                }else{
                    return 'Non-SMClub';
                }
            })
            ->addColumn('after', function($query){
                if($query->status_changed->status_after == 'Y'){
                    return 'SMClub';
                }elseif($query->status_changed->status_after == 'M'){
                    return 'Mixing';
                }else{
                    return 'Non-SMClub';
                }
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(HeaderVisit $model): QueryBuilder
    {
        return $model->newQuery()
            ->with('customer')
            ->with('status_changed')
            ->whereHas('status_changed', function($q){
                $q->where('status_before', '!=', null);
            });
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('switchingcustomer-table')
                    ->columns($this->getColumns())
                    // ->minifiedAjax()
                    ->ajax([
                        'url'  => route('report-switching'),
                        'type' => 'GET',
                        'data' => "function(data){
                            data.start_date = $('input[name=start_date]').val(),
                            data.end_date = $('input[name=end_date]').val(),
                            data.search = $('input[type=search]').val();
                        }"
                    ])
                    // ->dom('Bfrtip')
                    // ->dom('lBrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->responsive()
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
