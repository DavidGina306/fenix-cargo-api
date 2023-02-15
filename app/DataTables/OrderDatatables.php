<?php

namespace App\DataTables;

use App\Models\Order;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;

class OrderDatatables extends DataTable
{
    public function dataTable($query)
    {
        return datatables($query)
            ->escapeColumns([])
            ->editColumn('customer', function ($query) {
                return $query->customer->name;
            })
            ->editColumn('open_date', function ($query) {
                return Carbon::parse($query['open_date'])->format('d/m/Y');
            })
            ->filterColumn('customer', function ($query, $keyword) {
                $query->whereHas('customer', function ($sql) use ($keyword) {
                    $sql->where('name', 'like', $keyword);
                });
            })
            ->editColumn('locale', function ($query) {
                return $query->locale->name;
            })->filterColumn('locale', function ($query, $keyword) {
                $query->whereHas('locale', function ($sql) use ($keyword) {
                    $sql->where('name', 'like', $keyword);
                });
            })
            ->addColumn('action', function ($query) {
                return [
                    'id' => $query->id,
                    'status' => $query->status
                ];
            });
    }

    public function query(Order $model)
    {
        return $model->newQuery()
            ->join('addresses as a', 'orders.address_id', '=', 'a.id')
            ->join('customers as c', 'orders.customer_id', '=', 'c.id')
            ->join('locales as l', 'orders.locale_id', '=', 'l.id')
            ->select(
                'orders.id',
                'orders.number',
                'orders.status',
                'orders.quantity',
                'orders.open_date',
                'a.id as id_address',
                'a.address_line_1',
                'a.address_line_2',
                'a.address_line_3',
                'a.postcode',
                'a.country',
                'a.town',
                'c.id as customer_id',
                'c.name',
                'c.document',
                'l.id as locale_id',
                'l.name',
            );
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('cabinet_datatable')
            ->columns($this->getColumns())
            ->parameters($this->getBuilderParameters() ?? []);
    }


    protected function getColumns()
    {
        return [
            'action' => [
                'title' => 'Ações',
                'orderable' => false,
                'searchable' => false,
                'exportable' => false,
                'printable' => false,
                'width' => '10px'
            ],
            'number' => ['title' => 'MINUTA', 'name' => 'orders.number',  'width' => '200px'],
            'locale' => ['title' => 'Armazém', 'width' => '200px', 'class' => 'text-center'],
            'quantity' => ['title' => 'Quantidade', 'width' => '200px', 'class' => 'text-center'],
            'customer' => ['title' => 'Cliente', 'width' => '200px', 'class' => 'text-center'],
            'open_date' => ['title' => 'Entrada', 'name' => 'orders.open_date',  'width' => '200px'],
            'status' => ['title' => 'Status', 'status' => 'orders.status',  'width' => '200px']
        ];
    }

    protected function filename()
    {
        return 'cabinet_' . date('YmdHis');
    }
}
