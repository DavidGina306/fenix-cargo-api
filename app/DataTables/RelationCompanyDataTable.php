<?php

namespace App\DataTables;

use App\Enums\RelationPriceType;
use App\Models\Country;
use App\Models\RelationPrice;
use Yajra\DataTables\Services\DataTable;

class RelationCompanyDataTable extends DataTable
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
                return  $query->destiny_2;
            })->filterColumn('destiny', function ($query, $keyword) {
                $query->where('destiny_1', 'like', $keyword)->orWhere('destiny_2', 'like', $keyword);
            })->editColumn('origin', function ($query) {
                return $query->origin_city ;
            })->filterColumn('origin', function ($query, $keyword) {
                $query->where('origin_city', 'like', $keyword);
            })->editColumn('partner', function ($query) {
                return $query->partner->name ?? "";
            })->filterColumn('partner', function ($query, $keyword) {
                $query->whereHas('partner',  function ($partner) use ($keyword) {
                    $partner->where('name', 'like', $keyword);
                });
            })->editColumn('value', function ($query) {
                return '$ ' . $query->value;
            })->editColumn('weight', function ($query) {
                return number_format($query->weight_initial, 1) . ' - ' . number_format($query->weight_final, 1);
            })
            ->filterColumn('weight', function ($query, $keyword) {
                $query->where('weight_initial', 'like', $keyword)
                    ->orWhere('weight_final', 'like', $keyword);
            });
    }


    public function query(RelationPrice $model)
    {
        return $model->newQuery()->where('type', RelationPriceType::COMPANY);
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
            'partner' => ['title' => 'Parceiro', 'name' => 'partner', 'width' => '200px', 'orderable' => false],
            'weight' => [
                'title' => 'Peso(I - F)',
                'name' => 'weight',
                'width' => '200px',
                'searchable' => false,
                'orderable' => false
            ],
            'value' => ['title' => 'Frete', 'name' => 'value', 'width' => '200px'],
            'origin' => ['title' => 'Origem', 'name' => 'origin', 'width' => '200px'],
            'destiny' => ['title' => 'Destino', 'name' => 'destiny', 'width' => '200px'],
            'status' => ['title' => 'Status', 'name' => 'status', 'width' => '200px'],
        ];
    }

    protected function filename()
    {
        return 'tabela_de_preços_' . date('YmdHis');
    }
}
