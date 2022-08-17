<?php

namespace App\Services;

class DatatableService
{
    public static function datatable($datatable)
    {
        if (request()->action == 'excel') {
            return $datatable->excel();
        }

        if (request()->action == 'pdf') {
            return $datatable->pdf();
        }

        if (request()->draw) {
            return $datatable->ajax();
        }

        return $datatable->html()->collection;
    }
}
