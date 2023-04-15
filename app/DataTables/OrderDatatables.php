<?php

namespace App\DataTables;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Services\DataTable;

class OrderDatatables extends DataTable
{
    public function dataTable($query)
    {
        return datatables($query)
            ->escapeColumns([])
            ->editColumn('sender', function ($query) {
                return  $query->sender ? $query->sender->name : $query->sender_name;
            })
            ->editColumn('weight', function ($query) {
                return $query->weight.' KG' ;
            })
            ->editColumn('value', function ($query) {
                return 'R$ '.$query->value ;
            })
            ->editColumn('origem', function ($query) {
                Log::info($query);
                return $query->town.' / '.  $query->state;
            })
            ->editColumn('open_date', function ($query) {
                return Carbon::parse($query['open_date'])->format('d/m/Y');
            })
            ->filterColumn('sender', function ($query, $keyword) {
                $query->whereHas('sender', function ($sql) use ($keyword) {
                    $sql->where('name', 'like', $keyword);
                });
            })
            ->filterColumn('origem', function ($query, $keyword) {
                $query->whereHas('addressSender', function ($sql) use ($keyword) {
                    $sql->where('town', 'like', $keyword)->orWhere('state', 'like', $keyword);
                });
            })
            ->editColumn('status', function ($query) {
                return $query->status->letter;
            })->filterColumn('status', function ($query, $keyword) {
                $query->whereHas('status', function ($sql) use ($keyword) {
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
            ->join('addresses as ase', 'orders.sender_address_id', '=', 'ase.id')
            ->join('addresses as ar', 'orders.recipient_address_id', '=', 'ar.id')
            ->leftJoin('customers as c', 'orders.sender_id', '=', 'c.id')
            ->join('statuses as s', 'orders.status_id', '=', 's.id')
            ->select(
                'orders.id',
                'orders.number',
                'orders.status_id',
                'orders.quantity',
                'orders.open_date',
                'orders.sender_name',
                'orders.weight',
                'orders.value',
                'ase.id as address_sender_id',
                'ase.address_line_1',
                'ase.address_line_2',
                'ase.address_line_3',
                'ase.postcode',
                'ase.country',
                'ase.state',
                'ase.town',
                'c.id as sender_id',
                'c.name',
                'c.document',
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
            'open_date' => ['title' => 'Solicitação', 'name' => 'orders.open_date',  'width' => '200px'],
            'origem' => ['title' => 'Origem', 'width' => '200px', 'class' => 'text-center'],
            'quantity' => ['title' => 'Quantidade', 'width' => '200px', 'class' => 'text-center'],
            'weight' => ['title' => 'Peso', 'name' => 'orders.weight',  'width' => '200px'],
            'value' => ['title' => 'Peso', 'name' => 'orders.value',  'width' => '200px'],
            'sender' => ['title' => 'Cliente', 'width' => '200px', 'class' => 'text-center'],
            'status' => ['title' => 'Status',  'width' => '200px', 'class' => 'text-center']
        ];
    }

    protected function filename()
    {
        return 'cabinet_' . date('YmdHis');
    }
}
