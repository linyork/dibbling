<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class DibblingRecord extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        Cookie::queue('dibbling_token', Auth::user()->api_token, 120);
        return view('record');
    }
}
