<?php

namespace App\Http\Controllers;

use App\Model\ListTable;
use App\Model\PlayingTable;
use DB;
use Illuminate\Http\Request;

class Player extends Controller
{
    public function index()
    {
        return view('player');
    }
    
    public function playing(string $id)
    {
        $returnJson = DB::table('playing')
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
    
    public function playing_id(){
        $playingResult = PlayingTable::find(1);
        $listResult = ListTable::withTrashed()->where('id', '=', $playingResult['video_id'])
            ->get();
        return response()->json($listResult);
    }
    
    public function list()
    {
        $dbResult = ListTable::where('deleted_at', '=', null)
            ->orderBy('id')
            ->get();
        return response()->json($dbResult);
    }
    
    public function play_list()
    {
        $dbResult = ListTable::onlyTrashed()->get();
        return response()->json($dbResult);
    }
    
    public function random()
    {
        $result = ListTable::onlyTrashed()->inRandomOrder()->first();
        return response()->json($result);
    }
}
