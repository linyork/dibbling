<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class player extends Controller
{
    public function index()
    {
        return view('player');
    }
    
    public function list()
    {
        $dbResult = \App\ListTable::where('played', 0)
            ->orderBy('id')
            ->get();
        return response()->json($dbResult);
    }
}
