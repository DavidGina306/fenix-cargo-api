<?php

namespace App\DataTables;

use App\Models\Locale;
use Yajra\DataTables\Services\DataTable;

class LocaleDataTable extends DataTable
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


    public function query(Locale $model)
    {
        return $model->newQuery()
            ->select(
                'locales.id',
                'locales.name',
                'locales.status'
            );
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('locale_datatable')
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
            'name' => ['title' => 'Nome', 'name' => 'locales.name',  'width' => '200px'],
            'status' => ['title' => 'Status', 'name' => 'locales.status', 'width' => '50px', 'class' => 'text-center'],
        ];
    }

    protected function filename()
    {
        return 'customer_' . date('YmdHis');
    }
}
