<?php

namespace App\Http\Controllers;

use App\Model\ListTable;
use App\Model\PlayingTable;
use DB;
use Illuminate\Http\Request;

class Player extends Controller
{
    public function index()
    {
        return view('player');
    }
    
    public function list()
    {
        $dbResult = ListTable::where('deleted_at', '=', null)
            ->orderBy('id')
            ->get();
        return response()->json($dbResult);
    }
    
    public function play_list()
    {
        $dbResult = ListTable::onlyTrashed()->get();
        return response()->json($dbResult);
    }
    
    public function random()
    {
        $result = ListTable::onlyTrashed()->inRandomOrder()->first();
        return response()->json($result);
    }
}
