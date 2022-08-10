<?php

namespace App\Http\Controllers\v3;

use App\Http\Controllers\Controller;
use App\Model\UserModel;
use App\Model\ListModel;
use App\Model\RecordModel;
use App\Model\LikeModel;
use App\Services\ListServiceV3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function users(Request $request, ListServiceV3 $listService) {
        try {
            $user = $listService->getUser($request->input('token'));
            if (!$user) return false;

            $result = $listService->getAllUsers();
        } catch (\Exception $e) {
            $result = [];
        }
        return response()->json($result);
    }

    public function delete(Request $request, ListServiceV3 $listService) {
        try {
            $user = $listService->getUser($request->input('token'));
            if (!$user || $user->role !== UserModel::ROLE_ADMIN) return false;

            $deleteUserId = $request->input('userId');

            DB::beginTransaction();
            // delete list
            DB::table(with(new ListModel)->getTable())
                ->whereIn(
                    'id',
                    function ($query) use ($deleteUserId) {
                        $query->select('list_id')
                            ->from(with(new RecordModel)->getTable())
                            ->where('user_id', $deleteUserId)
                            ->where('record_type', RecordModel::DIBBLING);
                    }
                )->delete();
            // delete record
            DB::table(with(new RecordModel)->getTable())->where('user_id', $deleteUserId)->delete();
            // delete like
            DB::table(with(new LikeModel)->getTable())->where('user_id', $deleteUserId)->delete();
            // delete user
            DB::table(with(new UserModel)->getTable())->where('id', $deleteUserId)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $deleteUserId = 0;
        }
        return response($deleteUserId);
    }
}