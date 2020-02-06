<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SetLocale extends Controller
{
    public function index(string $locale)
    {
        \App::setLocale($locale);
        return redirect()->back()->cookie('locale', $locale, 60000, null, null, false, false, false, null);
    }
}
