<?php

namespace App\DataTables;

use App\Models\Customer;
use Yajra\DataTables\Services\DataTable;

class CustomerDataTable extends DataTable
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
            })->editColumn('type', function ($query) {
                return $query->type == "J" ? "Juridica" : "Fisica";
            });
    }


    public function query(Customer $model)
    {
        return $model->newQuery()
            ->select(
                'customers.id',
                'customers.name',
                'customers.role',
                'customers.document',
                'customers.type',
                'customers.status',
                'customers.email',
                'customers.email_2',
                'customers.contact',
                'customers.contact_2'
            );
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('customer_datatable')
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
            'name' => ['title' => 'Name', 'name' => 'customers.name',  'width' => '200px'],
            'type' => ['title' => 'Tipo Cliente', 'name' => 'customers.type', 'width' => '200px'],
            'document' => ['title' => 'Documento', 'name' => 'customers.document', 'width' => '200px'],
            'email' => ['title' => 'Email', 'name' => 'customers.email', 'width' => '200px'],
            'contact' => ['title' => 'Contato', 'name' => 'customers.contact', 'width' => '200px'],
            'status' => ['title' => 'Status', 'name' => 'customers.status', 'width' => '50px', 'class' => 'text-center'],
        ];
    }

    protected function filename()
    {
        return 'customer_' . date('YmdHis');
    }
}
