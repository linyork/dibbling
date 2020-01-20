<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Model\PlayingTable;
use App\Model\ListTable;
use Illuminate\Http\Request;


class PlayingController extends Controller
{
    public function get()
    {
        $playingResult = PlayingTable::find(1);
        $listResult = ListTable::withTrashed()
            ->where('id', '=', $playingResult['video_id'])
            ->first();
        return response()->json($listResult);
    }

    public function playing(Request $request)
    {
        $id = $request->input('id');
        $returnJson = \DB::table('playing')
            ->where('id', 1)
            ->update(['video_id' => $id]);
        if($returnJson === 0)
        {
            $returnJson = DB::table('playing')->insert(
                [
                    'id' => 1,
                    'video_id' => $id,
                ]
            );
        }
        return response()->json($returnJson);
    }
}
