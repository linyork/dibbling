<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class dibbling extends Controller
{
    public function index()
    {
        return view('dibbling');
    }
    
    public function dibbling(string $videoId)
    {
        $dbResult = DB::table('list')->insert(
            [
                'video_id' => $videoId,
                'ip'    => request()->ip(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        return response()->json($dbResult);
    }
}
