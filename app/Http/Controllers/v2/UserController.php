<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Model\UserModel;


class UserController extends Controller
{
    public function index()
    {
        try
        {
            $result = UserModel::find(\Auth::user()->getAuthIdentifier())->toArray();
        }
        catch (\Exception $e)
        {
            $result = [];
        }
        return response()->json($result);
    }
}
