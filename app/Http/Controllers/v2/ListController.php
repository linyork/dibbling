<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Model\ListTable;

class ListController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $dbResult = ListTable::orderBy('updated_at')->get();
        return response()->json($dbResult);
    }
}
