<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class Setting extends Controller
{
    public function index()
    {
        return view('setting');
    }
}
