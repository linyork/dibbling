<?php

namespace App\Http\Controllers;

class DibblingList extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('list');
    }
}
