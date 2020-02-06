<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Setting extends Controller
{
    public function index()
    {
        return view('setting');
    }
}
