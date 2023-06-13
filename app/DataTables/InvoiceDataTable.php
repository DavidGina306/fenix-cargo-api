<?php

namespace App\DataTables;

use App\Models\Invoice;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;

class InvoiceDatatable extends DataTable
{
    public function dataTable($query)
    {
        return datatables($query)
            ->escapeColumns([])
            ->editColumn('payer', function ($query) {
                return $query->payer ? $query->payer->name . " - " . $query->payer->document : $query->payer_name;
            })
            ->editColumn('created_at', function ($query) {
                return Carbon::parse($query['created_at'])->format('d/m/Y');
            })
            ->filterColumn('payer', function ($query, $keyword) {
                $query->whereHas('payer', function ($sql) use ($keyword) {
                    $sql->where('name', 'like', $keyword)->orWhere('document', 'like', $keyword);
                });
            })
            ->addColumn('minutas', function ($query) {
                $minutas = $query->orders->pluck('number')->implode(', ');
                return $minutas;
            })
            ->addColumn('action', function ($query) {
                return [
                    'id' => $query->id,
                ];
            });
    }

    public function query(Invoice $model)
    {
        return $model->newQuery()
            ->leftJoin('customers as c', 'invoices.payer_id', '=', 'c.id')
            ->leftJoin('payment_types as pt', 'invoices.payment_type_id', '=', 'pt.id')
            ->select(
                'invoices.id',
                'invoices.number',
                'invoices.value',
                'c.id as payer_id',
                'c.name',
                'c.document',
                'invoices.created_at',
                'pt.name as payment_name'
            );
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('invoice_datatable')
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
            'created_at' => [
                'title' => 'Emissão',
                'name' => 'invoices.created_at',
                'data' => 'created_at',
                'width' => '200px',
                'searchable' => true,
                'sortable' => true,
                'render' => function ($date) {
                    return Carbon::parse($date)->format('d/m/Y');
                }
            ],
            'number' => [
                'title' => 'Numero',
                'name' => 'invoices.number',
                'data' => 'number',
                'width' => '200px',
                'searchable' => true,
                'sortable' => true
            ],
            'payer' => [
                'title' => 'Expeditor',
                'name' => 'c.name',
                'data' => 'name',
                'width' => '200px',
                'searchable' => true,
                'sortable' => true
            ],
            'minutas' => [
                'title' => 'Minutas',
                'name' => 'minutas',
                'data' => 'minutas',
                'class' => 'text-center',
                'searchable' => false,
                'sortable' => false
            ],
            'payment_name' => [
                'title' => 'Pagamento',
                'name' => 'pt.name',
                'data' => 'payment_name',
                'class' => 'text-center',
                'searchable' => true,
                'sortable' => true
            ],
            'value' => [
                'title' => 'Valor',
                'name' => 'invoices.value',
                'data' => 'value',
                'class' => 'text-center',
                'searchable' => true,
                'sortable' => true
            ],
        ];
    }
    protected function filename()
    {
        return 'packing_type_' . date('YmdHis');
    }
}
