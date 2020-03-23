<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Model\LikeTable;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function deleteUser(string $deleteUserId)
    {
        try
        {
            \DB::beginTransaction();

            \DB::commit();
        }
        catch (\Exception $e)
        {
            \DB::rollback();
            $deleteUserId = 0;
        }
        return response()->json($deleteUserId);
    }
}
