<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class player extends Controller
{
    public function index()
    {
        return view('player');
    }
}
