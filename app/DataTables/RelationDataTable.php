<?php

namespace App\DataTables;

use App\Models\Country;
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
            })->editColumn('destiny', function ($query) {
                return $query->destiny_1 . ' / ' . $query->destiny_2 . ' - ' .  Country::find($query->destiny_country)->nome;
            })->filterColumn('destiny', function ($query, $keyword) {
                $query->where('destiny_1', 'like', $keyword)->orWhere('destiny_2', 'like', $keyword);
            })->editColumn('origin', function ($query) {
                return $query->origin_city ;
            })->filterColumn('origin', function ($query, $keyword) {
                $query->where('origin_city', 'like', $keyword);
            })->editColumn('fee_type', function ($query) {
                return $query->feeType->name ?? "";
            })->filterColumn('fee_type', function ($query, $keyword) {
                $query->whereHas('feeType',  function ($fee) use ($keyword) {
                    $fee->where('name', 'like', $keyword);
                });
            })->editColumn('partner', function ($query) {
                return $query->partner->name ?? "";
            })->filterColumn('partner', function ($query, $keyword) {
                $query->whereHas('partner',  function ($partner) use ($keyword) {
                    $partner->where('name', 'like', $keyword);
                });
            });
    }


    public function query(RelationPrice $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('tabela_de_preços_datatable')
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
            'number' => ['title' => 'Numero', 'name' => 'number', 'width' => '100px'],
            'fee_type' => ['title' => 'Tarifa', 'name' => 'fee_type', 'width' => '200px'],
            'partner' => ['title' => 'Parceiro', 'name' => 'partner', 'width' => '200px'],
            'origin' => ['title' => 'Origem', 'name' => 'origin', 'width' => '200px'],
            'destiny' => ['title' => 'Destino', 'name' => 'destiny', 'width' => '200px'],
            'type' => ['title' => 'Tipo', 'name' => 'type', 'width' => '200px'],
            'status' => ['title' => 'Status', 'name' => 'status', 'width' => '200px'],
        ];
    }

    protected function filename()
    {
        return 'tabela_de_preços_' . date('YmdHis');
    }
}
