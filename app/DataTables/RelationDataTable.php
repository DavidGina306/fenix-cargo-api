<?php

namespace App\DataTables;

use App\Models\RelationPrice;
use Yajra\DataTables\Services\DataTable;

class RelationDataTable extends DataTable
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


    public function query(RelationPrice $model)
    {
        return $model->newQuery();
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
                'title' => 'Ações',
                'orderable' => false,
                'searchable' => false,
                'exportable' => false,
                'printable' => false,
                'width' => '10px'
            ],
            'numero' => ['title' => 'Numero', 'width' => '200px'],
            'tarifa' => ['title' => 'Tarifa',  'width' => '200px'],
            'origem' => ['title' => 'Origem','width' => '50px', 'class' => 'text-center'],
            'destino' => ['title' => 'Taxa Mínima', 'width' => '200px'],
            'status' => ['title' => 'Excedente','width' => '50px', 'class' => 'text-center'],
            'prazo' => ['title' => 'Prazo','width' => '50px', 'class' => 'text-center'],
        ];
    }

    protected function filename()
    {
        return 'user_' . date('YmdHis');
    }
}
