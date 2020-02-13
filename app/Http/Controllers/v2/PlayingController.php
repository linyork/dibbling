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
        try
        {
            $playingResult = PlayingTable::firstOrFail();
            $listResult = ListTable::withTrashed()->where('id', '=', $playingResult['video_id'])->first();
        }
        catch (\Exception $e)
        {
            $listResult = [];
        }
        return response()->json($listResult);
    }
}
