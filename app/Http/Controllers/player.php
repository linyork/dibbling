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
}
