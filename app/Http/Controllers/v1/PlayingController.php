<?php

namespace App\Http\Controllers\v1;

use DB;
use App\Model\ListTable;
use App\Model\PlayingTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlayingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->input('id');
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $playingResult = PlayingTable::find(1);
        $listResult = ListTable::withTrashed()
            ->where('id', '=', $playingResult['video_id'])
            ->first();
        return response()->json($listResult);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
