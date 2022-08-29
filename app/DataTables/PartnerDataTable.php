<?php

namespace App\DataTables;

use App\Models\Partner;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Services\DataTable;

class PartnerDataTable extends DataTable
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
            })->editColumn('parceiros', function ($query) {
                return $query->agents->pluck(['name']);
            })->filterColumn('parceiros', function ($query, $keyword) {
                $query->whereHas('agents', function ($sql) use ($keyword) {
                    $sql->where('name', 'like', $keyword);
                });
            })->editColumn('address', function ($query) {
                return $query->town . " ". $query->postcode;
            })->filterColumn('address', function ($query, $keyword) {
                $query->whereHas('address', function ($sql) use ($keyword) {
                    $sql->where('address_line_1', 'like', $keyword)
                        ->orWhere('address_line_1', 'like', $keyword)
                        ->orWhere('address_line_2', 'like', $keyword)
                        ->orWhere('address_line_3', 'like', $keyword)
                        ->orWhere('town', 'like', $keyword)
                        ->orWhere('country', 'like', $keyword);
                });
            });
    }


    public function query(Partner $model)
    {
        return $model->newQuery()
            ->join('addresses as a', 'partners.address_id', '=', 'a.id')
            ->select(
                'partners.id',
                'partners.name',
                'partners.document',
                'partners.status',
                'a.id as id_address',
                'a.address_line_1',
                'a.address_line_2',
                'a.address_line_3',
                'a.postcode',
                'a.country',
                'a.town'
            );
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('partner_datatable')
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
            'name' => ['title' => 'Name', 'name' => 'partners.name',  'width' => '200px'],
            'document' => ['title' => 'CNPJ', 'name' => 'document', 'width' => '200px'],
            'address' => ['title' => 'Endereço', 'width' => '200px', 'class' => 'text-center'],
            'parceiros' => ['title' => 'Parceiros', 'width' => '200px', 'class' => 'text-center'],
            'status' => ['title' => 'Status', 'name' => 'partners.status', 'width' => '50px', 'class' => 'text-center'],
        ];
    }

    protected function filename()
    {
        return 'partner_' . date('YmdHis');
    }
}
