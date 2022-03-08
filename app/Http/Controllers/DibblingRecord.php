<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class DibblingRecord extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user_id = $request->get('user_id') ?? 0;
        return view('record', ['user_id' => $user_id]);
    }

    public function index_tmp($user_id = 0)
    {
        return view('record', ['user_id' => $user_id]);
    }
}
