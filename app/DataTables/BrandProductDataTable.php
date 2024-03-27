<?php

namespace App\DataTables;

use App\Models\BrandProduct;
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

class BrandProductDataTable extends DataTable
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
            ->addColumn('action', function($query){
                // $btnShow = "<a class='btn btn-info' href='".route('position.show', $query->id)."'>Detail </a>";
                $btnEdit = "<a class='btn btn-warning' href='".route('brand.edit', $query->id)."'>Ubah </a>";
                $btnDelete = "<a class='btn btn-danger delete-item' href='".route('brand.destroy', $query->id)."'>Hapus </a>";

                // return $btnShow.$btnEdit.$btnDelete;
                if(Auth::user()->hasPermissionTo('brand_product edit') && Auth::user()->hasPermissionTo('brand_product delete')){
                    return $btnEdit.'&nbsp'.$btnDelete;
                }elseif(Auth::user()->hasPermissionTo('brand_product edit')){
                    return $btnEdit;
                }elseif(Auth::user()->hasPermissionTo('brand_product delete')){
                    return $btnDelete;
                }else{
                    return '';
                }
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
            ->addColumn('category', function($query){
                if(empty($query->category->name)){
                    return "TIDAK DIKETAHUI";
                }

                return $query->category->name;
            })
            ->rawColumns(['action', 'status'])
            // ->filter(function ($instance) use ($request) {
            //     if ($request->get('status') == '0' || $request->get('status') == '1') {
            //         $instance->where('status', $request->get('status'));
            //     }
            //     if (!empty($request->get('search'))) {
            //          $instance->where(function($w) use($request){
            //             $search = $request->get('search');
            //             $w->orWhere('name', 'LIKE', "%$search%");
            //             // ->orWhere('email', 'LIKE', "%$search%");
            //         });
            //     }
            // })
            ->filterColumn('status', function($query, $request) {
                $sql = "status = ?";
                $query->whereRaw($sql, ["%{$request->status}%"]);
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(BrandProduct $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('brandproduct-table')
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
            ['data' => 'name', 'title' => 'nama'],
            ['data' => 'category', 'title' => 'kategori'],
            ['data' => 'status', 'title' => 'status'],
            ['data' => 'action', 'title' => 'aksi', 'class' => 'text-center', 
            'exportable' => false, 'printable' => false, 'searchable' => false]
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'BrandProduct_' . date('YmdHis');
    }
}
