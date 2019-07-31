<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class dibbling extends Controller
{
    public function index()
    {
        $users = DB::select('select * from yorktest where id = ?', [1]);
    
        return $users;
//        return view('dibbling');
    }
}
