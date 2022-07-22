<?php

namespace App\Http\Controllers\v3;

use App\Http\Controllers\Controller;
use App\Model\UserModel;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class UserController extends Controller {
    use AuthenticatesUsers;

    public function login(Request $request) {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            //success
            $result = UserModel::whereEmail($request->input('email'))->first();
        } else {
            //failed
            $result = false;
        }
        return response()->json($result);
    }
}