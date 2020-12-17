<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class Set extends Controller
{
    public function locale(string $locale)
    {
        Cookie::queue('dibbling_token', Auth::user()->api_token, 120);
        \App::setLocale($locale);
        return redirect()->back()->cookie('locale', $locale, 60000, null, null, false, false, false, null);
    }

    public function mode(string $mode)
    {
        Cookie::queue('dibbling_token', Auth::user()->api_token, 120);
        return redirect()->back()->cookie('mode', $mode, 60000, null, null, false, false, false, null);
    }
}
