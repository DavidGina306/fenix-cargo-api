<?php

namespace App\DataTables;

use App\Models\Quote;
use App\Models\RelationPrice;
use Yajra\DataTables\Services\DataTable;
use Str;

class QuoteDataTable extends DataTable
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
            })->editColumn('cliente', function ($query) {
                return $query->customer->name;
            })->filterColumn('cliente', function ($query, $keyword) {
                $query->whereHas('customer', function ($sql) use ($keyword) {
                    $sql->where('name', 'like', $keyword);
                });
            })->editColumn('cliente', function ($query) {
                return $query->customer->name;
            })->filterColumn('cliente', function ($query, $keyword) {
                $query->whereHas('customer', function ($sql) use ($keyword) {
                    $sql->where('name', 'like', $keyword);
                });
            })->editColumn('origem', function ($query) {
                return Str::upper($query->senderAddress->town .' CEP '.$query->senderAddress->postcode);
            })->filterColumn('origem', function ($query, $keyword) {
                $query->whereHas('senderAddress', function ($sql) use ($keyword) {
                    $sql->where('address_line_1', 'like', $keyword)
                        ->orWhere('address_line_1', 'like', $keyword)
                        ->orWhere('address_line_2', 'like', $keyword)
                        ->orWhere('address_line_3', 'like', $keyword)
                        ->orWhere('town', 'like', $keyword)
                        ->orWhere('country', 'like', $keyword);
                });
            })->editColumn('destino', function ($query) {
                return $query->recipienteAddress->town.' CEP '.$query->recipienteAddress->postcode;
            })->filterColumn('destino', function ($query, $keyword) {
                $query->whereHas('recipienteAddress', function ($sql) use ($keyword) {
                    $sql->where('address_line_1', 'like', $keyword)
                        ->orWhere('address_line_1', 'like', $keyword)
                        ->orWhere('address_line_2', 'like', $keyword)
                        ->orWhere('address_line_3', 'like', $keyword)
                        ->orWhere('town', 'like', $keyword)
                        ->orWhere('country', 'like', $keyword);
                });
            });
    }


    public function query(Quote $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('quote_datatable')
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
            'number' => ['title' => 'Cotação', 'name' => 'number', 'width' => '200px'],
            'cliente' => ['title' => 'Cliente',  'width' => '200px'],
            'origem' => ['title' => 'Origem', 'width' => '200px', 'class' => 'text-center'],
            'destino' => ['title' => 'Destino', 'width' => '200px'],
            'value' => ['title' => 'Frete', 'width' => '200px', 'name' => 'value', 'class' => 'text-center'],
            'excess_weight' => ['title' => 'Excedente', 'width' => '200px', 'name' => 'value', 'class' => 'text-center'],
            'fee' => ['title' => 'Taxa', 'width' => '200px', 'name' => 'value', 'class' => 'text-center'],
            'minimum_fee' => ['title' => 'Taxa Minima', 'width' => '200px', 'name' => 'value', 'class' => 'text-center'],
            'insurance' => ['title' => 'Seguro', 'width' => '200px', 'name' => 'value', 'class' => 'text-center'],
            'status' => ['title' => 'Status', 'width' => '50px', 'class' => 'text-center'],
        ];
    }

    protected function filename()
    {
        return 'quote_' . date('YmdHis');
    }
}
