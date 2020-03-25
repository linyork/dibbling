<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Model\LikeTable;
use App\Model\ListTable;
use App\Model\PlayingTable;
use App\User;


class PlayingController extends Controller
{
    public function get()
    {
        try
        {
            $playingResult = PlayingTable::firstOrFail();
            $playingVideo = ListTable::withDibblingById($playingResult['video_id'])->first();
            $nextVideo = ListTable::next()->first();
            $likes = LikeTable::with('user')->where('list_id', '=', $playingResult['video_id'])->get();
            $isLike = LikeTable::where('user_id', '=', \Auth::user()->getAuthIdentifier())
                ->where('list_id', '=', $playingResult['video_id'])->first();

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
