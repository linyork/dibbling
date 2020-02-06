<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SetLocale extends Controller
{
    public function index(string $locale)
    {
        \App::setLocale($locale);
        return redirect('dibbling')->cookie('locale', $locale, 6000);
    }
}
