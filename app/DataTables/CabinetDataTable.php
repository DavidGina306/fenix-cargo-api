<?php

namespace App\DataTables;

use App\Models\Cabinet;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CabinetDataTable extends DataTable
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

    public function query(Cabinet $model)
    {
        return $model->newQuery()
            ->select(
                'cabinets.id',
                'cabinets.name',
                'cabinets.status'
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
            'name' => ['title' => 'Nome', 'name' => 'cabinets.name',  'width' => '200px'],
            'status' => ['title' => 'Status', 'status' => 'cabinets.status',  'width' => '200px']
        ];
    }

    protected function filename()
    {
        return 'cabinet_' . date('YmdHis');
    }
}
