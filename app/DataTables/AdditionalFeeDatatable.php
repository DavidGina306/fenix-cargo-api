<?php

namespace App\DataTables;

use App\Models\AdditionalFee;
use Yajra\DataTables\Services\DataTable;

class AdditionalFeeDatatable extends DataTable
{
    public function dataTable($query)
    {
        return datatables($query)
            ->escapeColumns([])
            ->addColumn('action', function ($query) {
                return [
                    'id' => $query->id,
                    'value' => $query->value,
                    'status' => $query->status
                ];
            });
    }

    public function query(AdditionalFee $model)
    {
        return $model->newQuery()
            ->select(
                'additional_fees.id',
                'additional_fees.name',
                'additional_fees.value',
                'additional_fees.status'
            );
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('additional_fees_datatable')
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
            'name' => ['title' => 'Nome', 'name' => 'additional_fees.name',  'width' => '200px'],
            'value' => ['title' => 'Valor', 'name' => 'additional_fees.value',  'width' => '200px'],
            'status' => ['title' => 'Status', 'status' => 'additional_fees.status',  'width' => '200px']
        ];
    }

    protected function filename()
    {
        return 'additional_fees_' . date('YmdHis');
    }
}
