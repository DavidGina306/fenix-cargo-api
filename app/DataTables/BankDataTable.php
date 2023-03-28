<?php

namespace App\DataTables;

use App\Models\Bank;
use Yajra\DataTables\Services\DataTable;

class BankDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables($query)
            ->escapeColumns([])
            ->addColumn('action', function ($query) {
                return [
                    'id' => $query->id,
                ];
            });
    }

    public function query(Bank $model)
    {
        return $model->newQuery()
            ->select(
                'banks.id',
                'banks.name',
                'banks.code'
            );
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('doc_type_datatable')
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
            'name' => ['title' => 'Nome', 'name' => 'banks.name',  'width' => '200px'],
            'code' => ['title' => 'Código', 'name' => 'banks.code',  'width' => '200px']
        ];
    }

    protected function filename()
    {
        return 'packing_type_' . date('YmdHis');
    }
}
