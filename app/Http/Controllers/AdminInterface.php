<?php

namespace App\Http\Controllers;

class AdminInterface extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin_interface');
    }
}
