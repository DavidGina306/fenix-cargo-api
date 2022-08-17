<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Services\DataTable;

class UserDatatable extends DataTable
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


    public function query(User $model)
    {
        return $model->newQuery()
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.status'
            );
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('user_datatable')
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
            'name' => ['title' => 'Name', 'name' => 'users.name',  'width' => '200px'],
            'email' => ['title' => 'VAT', 'name' => 'users.email', 'width' => '200px'],
            'status' => ['title' => 'Status', 'name' => 'users.status', 'width' => '50px', 'class' => 'text-center'],
        ];
    }

    protected function filename()
    {
        return 'user_' . date('YmdHis');
    }
}
