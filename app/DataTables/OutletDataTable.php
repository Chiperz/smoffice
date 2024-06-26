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
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class OutletDataTable extends DataTable
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
                if (!empty($request->get('status'))) {
                    $instance->where('status_registration', $request->get('status'));
                }
                if (!empty($request->get('branch'))) {
                    $instance->where('branch_id', $request->get('branch'));
                }
                // if (!empty($request->get('area'))) {
                //     $instance->where('area', 'LIKE', "%".$request->get('area')."%");
                // }
                // if (!empty($request->get('subarea'))) {
                //     $instance->where('subarea', 'LIKE', "%".$request->get('subarea')."%");
                // }
                if (!empty($request->get('search'))) {
                    $instance->where(function($w) use($request){
                       $search = $request->get('search');
                       $w->orWhere('code', 'LIKE', "%$search%")
                       ->orWhere('name', 'LIKE', "%$search%");
                    //    ->orWhere('area', 'LIKE', "%$search%")
                    //    ->orWhere('subarea', 'LIKE', "%$search%");
                   });
               }
            })
            ->addColumn('branch', function($query){
                return $query->deploy_branch->name;
            })
            ->addColumn('area', function($query){
                return $query->deploy_area == null ? '' : $query->deploy_area->name;
            })
            ->addColumn('subarea', function($query){
                return $query->deploy_sub_area == null ? '' : $query->deploy_sub_area->name;
            })
            ->addColumn('action', function($query){
                // $btnShow = "<a class='btn btn-info' href='".route('position.show', $query->id)."'>Detail </a>";
                $btnEdit = "<a class='btn btn-warning' href='".route('outlet.edit', $query->id)."'>Ubah </a>";
                $btnDelete = "<a class='btn btn-danger delete-item' href='".route('outlet.destroy', $query->id)."'>Hapus </a>";

                // return $btnShow.$btnEdit.$btnDelete;
                if(Auth::user()->hasPermissionTo('outlet edit') && Auth::user()->hasPermissionTo('outlet delete')){
                    return $btnEdit.'&nbsp'.$btnDelete;
                }elseif(Auth::user()->hasPermissionTo('outlet edit')){
                    return $btnEdit;
                }elseif(Auth::user()->hasPermissionTo('outlet delete')){
                    return $btnDelete;
                }else{
                    return '';
                }
            })
            ->addColumn('status', function($query){
                $sm = '<span class="badge rounded-pill bg-success">Sudah</span>';
                $nonsm = '<span class="badge rounded-pill bg-danger">Belum</span>';
                $mix = '<span class="badge rounded-pill bg-secondary">Mixing</span>';

                if($query->status_registration == 'Y'){
                    return $sm;
                }elseif($query->status_registration == 'M'){
                    return $mix;
                }else{
                    return $nonsm;
                }
            })
            // ->addColumn('code' ,function($query){
            //     if($query->status_registration == 'Y'){
            //         return 'RO-'.$query->code;
            //     }else if($query->status_registration == 'M'){
            //         return 'MX-'.$query->code;
            //     }else{
            //         return 'NRO-'.$query->code;
            //     }
            // })
            ->rawColumns(['action', 'status', 'branch','area','subarea'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Customer $model): QueryBuilder
    {
        return $model->newQuery()->where('type', 'O');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('outlet-table')
                    ->columns($this->getColumns())
                    // ->minifiedAjax()
                    ->ajax([
                        'url'  => route('outlet.index'),
                        'type' => 'GET',
                        'data' => "function(data){
                            data.status = $('select[name=status]').val(),
                            data.branch = $('select[name=branch]').val(),
                            data.search = $('input[type=search]').val();
                        }"
                    ])
                    //->dom('Bfrtip')
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
            'exportable' => false, 'printable' => false, 'searchable' => false],
            ['data' => 'code', 'title' => 'kode'],
            ['data' => 'name', 'title' => 'nama'],
            ['data' => 'status', 'title' => 'status registrasi'],
            ['data' => 'branch', 'title' => 'cabang'],
            ['data' => 'area', 'title' => 'area'],
            ['data' => 'subarea', 'title' => 'sub area'],
            ['data' => 'action', 'title' => 'aksi', 'class' => 'text-center', 
            'exportable' => false, 'printable' => false, 'searchable' => false]
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Outlet_' . date('YmdHis');
    }
}
