<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Model\LikeTable;
use App\Model\PlayingTable;
use App\Model\RecordTable;


class PlayingController extends Controller
{
    public function get()
    {
        try
        {
            $playingResult = PlayingTable::firstOrFail();

            $playingVideo = \DB::table('record')
                ->join('users', 'record.user_id', '=', 'users.id')
                ->join('list', 'record.list_id', '=', 'list.id')
                ->where('record.record_type', '=', RecordTable::DIBBLING)
                ->where('list.id', '=', $playingResult['video_id'])
                ->get()
                ->first();
            $playingVideo = get_object_vars($playingVideo);

            $likes = LikeTable::where('list_id', '=', $playingResult['video_id'])->get();
            $isLike = LikeTable::where('user_id', '=', \Auth::user()->getAuthIdentifier())
                ->where('list_id', '=', $playingResult['video_id'])->first();

            $nextVideo = \DB::table('record')
                ->join('users', 'record.user_id', '=', 'users.id')
                ->join('list', 'record.list_id', '=', 'list.id')
                ->where('record.record_type', '=', RecordTable::DIBBLING)
                ->where('list.deleted_at','=', NULL)
                ->orderBy('list.updated_at')
                ->get()
                ->first();
            if ( $nextVideo )
            {
                $nextVideo = get_object_vars($nextVideo);
            }
            else
            {
                $nextVideo = [
                    'title' => __('web.dibbling.Random'),
                ];
            }

            $data = [
                'playing' => $playingVideo,
                'next' => $nextVideo,
                'likes' => $likes,
                'isLike' => $isLike,
            ];
        }
        catch (\Exception $e)
        {
            $data = [];
        }
        return response()->view('common.video_interface', $data, 200);
    }
}
