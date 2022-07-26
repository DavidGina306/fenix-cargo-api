<?php

namespace App\DataTables;

use App\Models\PackingType;
use Yajra\DataTables\Services\DataTable;

class PackingTypeDatatable extends DataTable
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

    public function query(PackingType $model)
    {
        return $model->newQuery()
            ->select(
                'packing_types.id',
                'packing_types.name',
                'packing_types.status'
            );
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('packing_type_datatable')
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
            'name' => ['title' => 'Nome', 'name' => 'packing_types.name',  'width' => '200px'],
            'status' => ['title' => 'Status', 'status' => 'packing_types.status',  'width' => '200px']
        ];
    }

    protected function filename()
    {
        return 'packing_type_' . date('YmdHis');
    }
}
