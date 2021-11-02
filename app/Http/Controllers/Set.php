<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;

class Set extends Controller
{
    public function locale(string $locale)
    {
        App::setLocale($locale);
        return redirect()->back()->cookie('locale', $locale, 60000, null, null, false, false, false, null);
    }

    public function mode(string $mode)
    {
        return redirect()->back()->cookie('mode', $mode, 60000, null, null, false, false, false, null);
    }
}
