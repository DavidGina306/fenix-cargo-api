<?php

namespace App\DataTables;

use App\Models\Invoice;
use Yajra\DataTables\Services\DataTable;

class InvoiceDatatable extends DataTable
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
            });
    }

    public function query(Invoice $model)
    {
        return $model->newQuery()
            ->select(
                'invoices.id',
                'invoices.number',
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
            'number' => ['title' => 'Nome', 'number' => 'invoices.number',  'width' => '200px'],
            'status' => ['title' => 'Status', 'status' => 'invoices.status',  'width' => '200px']
        ];
    }

    protected function filename()
    {
        return 'packing_type_' . date('YmdHis');
    }
}
