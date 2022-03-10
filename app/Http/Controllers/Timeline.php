<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class Timeline extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'start_date' => date('Y-m-d', strtotime(Auth::user()->created_at)),
            'end_date' => date('Y-m-d')
        ];
        return view('timeline', $data);
    }
}
