<?php

namespace App\DataTables;

use App\Models\Cabinet;
use Yajra\DataTables\Services\DataTable;

class CabinetDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables($query)
            ->escapeColumns([])
            ->editColumn('customer', function ($query) {
                return $query->customer->name;
            })->filterColumn('customer', function ($query, $keyword) {
                $query->whereHas('customer', function ($sql) use ($keyword) {
                    $sql->where('name', 'like', $keyword);
                });
            })
            ->editColumn('total', function ($query) {
                return $query->objects->count();
            })
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
            ->join('addresses as a', 'cabinets.address_id', '=', 'a.id')
            ->join('customers as c', 'cabinets.customer_id', '=', 'c.id')
            ->select(
                'cabinets.id',
                'cabinets.order',
                'cabinets.status',
                'cabinets.entry_date',
                'cabinets.doc_value',
                'cabinets.storage_locale',
                'a.id as id_address',
                'a.address_line_1',
                'a.address_line_2',
                'a.address_line_3',
                'a.postcode',
                'a.country',
                'a.town',
                'c.id as customer_id',
                'c.name',
                'c.document'
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
            'order' => ['title' => 'Ordem', 'name' => 'cabinets.order',  'width' => '200px'],
            'storage_locale' => ['title' => 'Armazém', 'name' => 'cabinets.storage_locale',  'width' => '200px'],
            'customer' => ['title' => 'Parceiros', 'width' => '200px', 'class' => 'text-center'],
            'entry_date' => ['title' => 'Entrada', 'name' => 'cabinets.entry_date',  'width' => '200px'],
            'total' => ['title' => 'Objetos', 'width' => '200px', 'class' => 'text-center', 'searchable' => false, 'orderable' => false],
            'status' => ['title' => 'Status', 'status' => 'cabinets.status',  'width' => '200px']
        ];
    }

    protected function filename()
    {
        return 'cabinet_' . date('YmdHis');
    }
}
