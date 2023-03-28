<?php

namespace App\DataTables;

use App\Models\Country;
use Yajra\DataTables\Services\DataTable;

class CountryDataTable extends DataTable
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

    public function query(Country $model)
    {
        return $model->newQuery()
            ->select(
                'countries.id',
                'countries.ordem',
                'countries.sigla3',
                'countries.sigla2',
                'countries.nome',
                'countries.codigo',
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
            'ordem' => ['title' => 'Ordem', 'name' => 'countries.ordem',  'width' => '200px'],
            'nome' => ['title' => 'Nome', 'name' => 'countries.nome',  'width' => '200px'],
            'codigo' => ['title' => 'Código', 'name' => 'countries.codigo',  'width' => '200px'],
            'sigla3' => ['title' => 'Sigla3', 'name' => 'countries.sigla3',  'width' => '200px'],
            'sigla2' => ['title' => 'Sigla2', 'name' => 'countries.sigla2',  'width' => '200px']

        ];
    }

    protected function filename()
    {
        return 'packing_type_' . date('YmdHis');
    }
}
