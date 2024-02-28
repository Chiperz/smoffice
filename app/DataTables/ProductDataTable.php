<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
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
                $btnEdit = "<a class='btn btn-warning' href='".route('product.edit', $query->id)."'>Ubah </a>";
                $btnDelete = "<a class='btn btn-danger delete-item' href='".route('product.destroy', $query->id)."'>Hapus </a>";

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
            ->addColumn('category', function($query){
                if(empty($query->category->name)){
                    return "TIDAK DIKETAHUI";
                }

                return $query->category->name;
            })
            ->addColumn('brand', function($query){
                if(empty($query->brand->name)){
                    return "TIDAK DIKETAHUI";
                }

                return $query->brand->name;
            })
            ->addColumn('subBrand', function($query){
                if(empty($query->subBrand->name)){
                    return "TIDAK DIKETAHUI";
                }

                return $query->brand->name;
            })
            ->rawColumns(['action', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('product-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
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
            ['data' => 'DT_RowIndex', 'title' => '#'],
            ['data' => 'code', 'title' => 'Kode'],
            ['data' => 'name', 'title' => 'Nama'],
            ['data' => 'category', 'title' => 'Kategori'],
            ['data' => 'brand', 'title' => 'Brand'],
            ['data' => 'subBrand', 'title' => 'Sub Brand'],
            ['data' => 'status', 'title' => 'Status'],
            ['data' => 'action', 'title' => 'Aksi', 'class' => 'text-center'],
            // Column::computed('action')
            //       ->exportable(false)
            //       ->printable(false)
            //       ->width(300)
            //       ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Product_' . date('YmdHis');
    }
}
