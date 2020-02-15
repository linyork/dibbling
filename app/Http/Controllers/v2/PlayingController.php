<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Model\PlayingTable;
use App\Model\ListTable;
use App\Model\RecordTable;
use Illuminate\Http\Request;


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
            ];
        }
        catch (\Exception $e)
        {
            $data = [];
        }
        return response()->view('common.video_interface', $data, 200);
    }
}
