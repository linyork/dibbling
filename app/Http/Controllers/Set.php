<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class Set extends Controller
{
    public function locale(string $locale)
    {
        App::setLocale($locale);
        return redirect()->back()->withCookie(Cookie::forever('locale', $locale));
    }

    public function mode(string $mode)
    {
        return redirect()->back()->withCookie(Cookie::forever('mode', $mode));
    }

    public function channel(string $channel)
    {
        return redirect()->back()->withCookie(Cookie::forever('channel', $channel));
    }
}
