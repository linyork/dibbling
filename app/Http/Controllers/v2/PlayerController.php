<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Model\ListModel;
use App\Model\RecordModel;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function next()
    {
        try
        {
            \DB::beginTransaction();
            $playedList = \DB::table('record')
                ->join('users', 'record.user_id', '=', 'users.id')
                ->join('list', 'record.list_id', '=', 'list.id')
                ->where('record.record_type', '=', RecordModel::DIBBLING)
                ->where('list.deleted_at','=', NULL)
                ->orderBy('list.updated_at')
                ->get()
                ->first();
            if ( $playedList )
            {
                ListModel::withTrashed()->find($playedList->list_id)->delete();
                $listResult = $playedList;
            }
            else
            {
                $listResult = ListModel::onlyTrashed()->inRandomOrder()->first();
            }

            if ( \DB::table('playing')->first() )
            {
                \DB::table('playing')->update(['video_id' => $listResult->id]);
            }
            else
            {
                \DB::table('playing')->insert(['video_id' => $listResult->id]);
            }
            \DB::commit();
        }
        catch (\Exception $e)
        {
            \DB::rollback();
            $listResult = [];
        }
        return response()->json($listResult);
    }
}
