<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class Setting extends Controller
{
    public function index()
    {
        Cookie::queue('dibbling_token', Auth::user()->api_token, 120);
        return view('setting');
    }
}
