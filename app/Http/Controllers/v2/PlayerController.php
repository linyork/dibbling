<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Model\ListModel;
use App\Model\RecordModel;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
{
    public function next()
    {
        try
        {
            $channel = Cookie::get('channel') ?? 'tw';
            DB::beginTransaction();
            $playedList = DB::table('record')
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
                $listResult = ListModel::onlyTrashed()->where('deleted_at', '<', date('Y-m-d', strtotime('-3 day')))->inRandomOrder()->first();
                if (!$listResult) {
                    $listResult = ListModel::onlyTrashed()->inRandomOrder()->first();
                }
                //update deleted_at
                $listResult->deleted_at = now();
                $listResult->timestamps = false;
                $listResult->save();
            }

            if ( DB::table('playing')->where('channel', '=', $channel)->first() )
            {
                DB::table('playing')
                    ->where('channel', '=', $channel)
                    ->update(['video_id' => $listResult->id]);
            }
            else
            {
                DB::table('playing')
                    ->insert(['video_id' => $listResult->id, 'channel' => $channel]);
            }
            DB::commit();
        }
        catch (\Exception $e)
        {
            DB::rollback();
            $listResult = [];
        }
        return response()->json($listResult);
    }
}
