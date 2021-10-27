<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Model\LikeModel;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Request $request)
    {
        try
        {
            $userId = \Auth::user()->getAuthIdentifier();
            $videoId = $request->input('videoId');
            \DB::beginTransaction();
            $like = \DB::table('like')
                ->where('user_id', '=', $userId)
                ->where('list_id', '=', $videoId)
                ->get()
                ->first();
            if ( $like )
            {
                \DB::table('like')
                    ->where('user_id', '=', $userId)
                    ->where('list_id', '=', $videoId)
                    ->delete();
                $result = ['like' => false];
            }
            else
            {
                $like = new LikeModel();
                $like->user_id = $userId;
                $like->list_id = $videoId;
                $like->created_at = now();
                $like->updated_at = now();
                $like->save();
                $result = ['like' => true];
            }

            \DB::commit();
        }
        catch (\Exception $e)
        {
            \DB::rollback();
            $result = [];
        }
        return response()->json($result);
    }
}
