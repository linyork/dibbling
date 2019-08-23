<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class Dibbling extends Controller
{
    public function index()
    {
        return view('dibbling');
    }
}
