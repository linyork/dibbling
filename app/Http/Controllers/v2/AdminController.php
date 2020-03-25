<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Model\LikeTable;
use App\Model\ListTable;
use App\Model\RecordTable;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function deleteUser(string $deleteUserId)
    {
        try
        {
            \DB::beginTransaction();
            // delete list
            \DB::table(with(new ListTable)->getTable())
                ->whereIn('id', function ($query) use ($deleteUserId)
                {
                    $query->select('list_id')
                        ->from(with(new RecordTable)->getTable())
                        ->where('user_id', $deleteUserId)
                        ->where('record_type', RecordTable::DIBBLING);
                }
            )->delete();
            // delete record
            \DB::table(with(new RecordTable)->getTable())->where('user_id', $deleteUserId)->delete();
            // delete like
            \DB::table(with(new LikeTable)->getTable())->where('user_id', $deleteUserId)->delete();
            // delete user
            \DB::table(with(new User)->getTable())->where('id', $deleteUserId)->delete();
            \DB::commit();
        }
        catch (\Exception $e)
        {
            \DB::rollback();
            $deleteUserId = 0;
        }
        return response($deleteUserId);
    }
}
