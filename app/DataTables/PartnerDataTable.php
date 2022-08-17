<?php

namespace App\DataTables;

use App\Models\Partner;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Services\DataTable;

class PartnerDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables($query)
            ->escapeColumns([])
            ->addColumn('action', function ($query) {
                return [
                    'id' => $query->id,
                    'status' => $query->status
                ];
            })->editColumn('image', function ($query) {
                return $query->variations->first()->images()->first()->value;
            })->filterColumn('quantity', function ($query, $keyword) {
                $query->whereHas('variations', function ($sql) use ($keyword) {
                    $sql->where('quantity', 'like', $keyword);
                });
            })->filterColumn('price', function ($query, $keyword) {
                $query->whereHas('variations', function ($sql) use ($keyword) {
                    $sql->where('price', 'like', $keyword);
                });
            });
    }


    public function query(Partner $model)
    {
        return $model->newQuery()
            ->leftJoin('categories as c', 'products.category_id', '=', 'c.id')
            ->select(
                'products.id',
                'products.name',
                'products.description',
                'products.status',
                'products.vat',
                'c.name as category',
                (DB::raw("(select v.quantity from variations v where v.product_id = products.id limit 1) as quantity")),
                (DB::raw("(select v.quantity from variations v where v.product_id = products.id limit 1) as price"))
            );
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('company_datatable')
            ->columns($this->getColumns())
            ->parameters($this->getBuilderParameters() ?? []);
    }


    protected function getColumns()
    {
        return [
            'action' => [
                'title' => 'Actions',
                'orderable' => false,
                'searchable' => false,
                'exportable' => false,
                'printable' => false,
                'width' => '10px'
            ],
            'image' => [
                'title' => '#', 'width' => '200px',
                'orderable' => false,
                'searchable' => false,
            ],
            'name' => ['title' => 'Name', 'name' => 'products.name',  'width' => '200px'],
            'vat' => ['title' => 'VAT', 'name' => 'products.vat', 'width' => '200px'],
            'category' => ['title' => 'Category', 'name' => 'c.name as category', 'width' => '200px'],
            'price' => ['title' => 'Price', 'width' => '200px', 'class' => 'text-center'],
            'quantity' => ['title' => 'Quantity', 'width' => '200px', 'class' => 'text-center'],
            'status' => ['title' => 'Status', 'name' => 'products.status', 'width' => '50px', 'class' => 'text-center'],
        ];
    }

    protected function filename()
    {
        return 'company_' . date('YmdHis');
    }
}
