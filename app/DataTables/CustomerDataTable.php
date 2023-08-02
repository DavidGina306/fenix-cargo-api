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
            })->editColumn('agents', function ($query) {
                return $query->agents->pluck(['name']);
            })->filterColumn('agents', function ($query, $keyword) {
                $query->whereHas('agents', function ($sql) use ($keyword) {
                    $sql->where('name', 'like', $keyword);
                });
            })->editColumn('email', function ($query) {
                return $query->agents->pluck(['email']);
            })->filterColumn('email', function ($query, $keyword) {
                $query->whereHas('agents', function ($sql) use ($keyword) {
                    $sql->where('email', 'like', $keyword);
                });
            })->editColumn('contact', function ($query) {
                return $query->agents->pluck(['contact']);
            })->filterColumn('contact', function ($query, $keyword) {
                $query->whereHas('agents', function ($sql) use ($keyword) {
                    $sql->where('contact', 'like', $keyword);
                });
            });
    }


    public function query(Customer $model)
    {
        return $model->newQuery()
            ->leftJoin('customer_agents as ca', 'ca.customer_id', '=', 'customers.id')
            ->select(
                'customers.id',
                'customers.name',
                'customers.role',
                'customers.document',
                'customers.type',
                'customers.status',
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
            'agents' => ['title' => 'Responsaveis', 'width' => '200px', 'class' => 'text-center'],
            'email' => ['title' => 'Email', 'width' => '200px', 'class' => 'text-center'],
            'contact' => ['title' => 'Contato', 'width' => '200px', 'class' => 'text-center'],
            'status' => [
                'title' => 'Status',
                'name' => 'customers.status',
                'width' => '50px',
                'class' => 'text-center'
            ],
        ];
    }

    protected function filename()
    {
        return 'customer_' . date('YmdHis');
    }
}
