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
            })->editColumn('destiny', function ($query) {
                return $query->destiny_initial . ' / ' . $query->destiny_final . ' - ' .  $query->destiny_state;
            })->filterColumn('destiny', function ($query, $keyword) {
                $query->where('destiny_initial', 'like', $keyword)->orWhere('destiny_final', 'like', $keyword);
            })->editColumn('origin', function ($query) {
                return $query->origin_initial . ' - ' . $query->origin_state;
            })->filterColumn('origin', function ($query, $keyword) {
                $query->where('origin_initial', 'like', $keyword);
            })->editColumn('fee_type', function ($query) {
                return $query->feeType->name;
            })->filterColumn('fee_type', function ($query, $keyword) {
                $query->whereHas('feeType',  function ($fee) use ($keyword) {
                    $fee->where('name', 'like', $keyword);
                });
            })->editColumn('minimum', function ($query) {
                return $query->relationPriceDetails()->whereHas('feeRule',  function ($rule) {
                    $rule->where('name', 'like', 'Taxa Minima');
                })->first()->value ?? "N\A";
            })->filterColumn('minimum', function ($query, $keyword) {
                $query->whereHas('relationPriceDetails',  function ($fee) use ($keyword) {
                    $fee->whereHas('feeRule',  function ($rule) {
                        $rule->where('name', 'like', 'Taxa Minima');
                    })->where('value', $keyword);
                });
            })->editColumn('excess', function ($query) {
                return $query->relationPriceDetails()->whereHas('feeRule',  function ($rule) {
                    $rule->where('name', 'like', 'Excedente fixo por kg');
                })->first()->weight_initial ?? "N\A";
            })->filterColumn('excess', function ($query, $keyword) {
                $query->whereHas('relationPriceDetails',  function ($fee) use ($keyword) {
                    $fee->whereHas('feeRule',  function ($rule) {
                        $rule->where('name', 'like', 'Excedente fixo por kg');
                    })->where('weight_initial', $keyword);
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
            'origin' => ['title' => 'Origem', 'name' => 'origin', 'width' => '200px'],
            'destiny' => ['title' => 'Destino', 'name' => 'destiny', 'width' => '200px'],
            'minimum' => ['title' => 'Taxa Mínima', 'name' => 'minimum', 'width' => '200px'],
            'excess' => ['title' => 'Exc Kg', 'name' => 'excess', 'width' => '200px'],
            'status' => ['title' => 'Status', 'name' => 'status', 'width' => '200px'],
        ];
    }

    protected function filename()
    {
        return 'tabela_de_preços_' . date('YmdHis');
    }
}
