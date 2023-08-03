<?php

namespace App\DataTables;

use App\Enums\RelationPriceType;
use App\Models\FeeType;
use App\Models\RelationPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Services\DataTable;

class RelationFenixDataTable extends DataTable
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
            })->addColumn('select', function ($query) {
                return [
                    'id' => $query->id,
                    'status' => $query->status
                ];
            })
            ->editColumn('destiny', function ($query) {
                return  $query->destiny_2;
            })
            ->filterColumn('destiny', function ($query, $keyword) {
                $query->where('destiny_1', 'like', $keyword)
                    ->orWhere('destiny_2', 'like', $keyword);
            })
            ->editColumn('origin', function ($query) {
                return $query->origin_city;
            })
            ->filterColumn('origin', function ($query, $keyword) {
                $query->where('origin_city', 'like', $keyword);
            })
            ->editColumn('fee_type', function ($query) {
                return $query->feeType->name ?? "";
            })
            ->filterColumn('fee_type', function ($query, $keyword) {
                $query->whereHas('feeType', function ($fee) use ($keyword) {
                    $fee->where('name', 'like', $keyword);
                });
            })
            ->editColumn('weight', function ($query) {
                return number_format($query->weight_initial, 1) . ' - ' . number_format($query->weight_final, 1);
            })
            ->filterColumn('weight', function ($query, $keyword) {
                $query->where('weight_initial', 'like', $keyword)
                    ->orWhere('weight_final', 'like', $keyword);
            })
            ->editColumn('deadline', function ($query) {
                return $query->deadline_initial . ' - ' . $query->deadline_final . ' - ' . $query->deadline_type;
            })
            ->filterColumn('deadline', function ($query, $keyword) {
                $query->where('deadline_initial', 'like', $keyword)
                    ->orWhere('deadline_final', 'like', $keyword);
            })
            ->editColumn('fee_rule', function ($query) {
                return $query->feeRule->name ?? "";
            })
            ->filterColumn('fee_rule', function ($query, $keyword) {
                $query->whereHas('feeRule', function ($fee) use ($keyword) {
                    $fee->where('name', 'like', $keyword);
                });
            });
    }

    public function query(RelationPrice $model, Request $request)
    {
        Log::info($request->research);
        $model = $model->newQuery()->where('type', RelationPriceType::FENIX);
        if ($request->research && $feeType = FeeType::query()->find($request->research)) {
            $model->where('fee_type_id', $feeType->id);
        }
        return $model->with('feeType', 'feeRule');
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
            'select' => [
                'name' => 'select',
                'title' => '', // Renderiza o título como HTML
                'orderable' => false,
                'raw' => true, // Adicione esta linha para interpretar como HTML
                'searchable' => false,
                'exportable' => false,
                'data' => 'select', // Adicione esta linha para definir o conteúdo da coluna como 'select'
                'printable' => false,
            ],
            'fee_type' => [
                'title' => 'Tarifa',
                'name' => 'feeType.name', // Corrigido o nome da coluna
                'width' => '200px'
            ],
            'weight' => [
                'title' => 'Peso(I - F)',
                'name' => 'weight',
                'width' => '200px',
                'searchable' => false,
                'orderable' => false
            ],
            'origin' => [
                'title' => 'Origem',
                'name' => 'origin',
                'width' => '200px',
                'orderable' => false
            ],
            'destiny' => [
                'title' => 'Destino',
                'name' => 'destiny',
                'width' => '200px',
                'orderable' => false
            ],
            'fee_rule' => [
                'title' => 'Regra',
                'name' => 'feeRule.name', // Corrigido o nome da coluna
                'width' => '200px',
                'orderable' => false
            ],
            'deadline' => [
                'title' => 'Prazo',
                'name' => 'deadline',
                'width' => '200px',
                'searchable' => false,
                'orderable' => false
            ],
            'status' => [
                'title' => 'Status',
                'name' => 'status',
                'width' => '200px'
            ],
        ];
    }

    protected function filename()
    {
        return 'tabela_de_preços_' . date('YmdHis');
    }

    protected function renderSelectColumnTitle()
    {
        return '<input type="checkbox" id="select-all">'; // Retorne o HTML do título
    }
}
