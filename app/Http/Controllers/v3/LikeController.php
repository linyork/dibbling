<?php

namespace App\Http\Controllers\v3;

use App\Http\Controllers\Controller;
use App\Model\LikeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\ListServiceV3;

class LikeController extends Controller {
    public function like(Request $request, ListServiceV3 $listService) {
        try {
            $user = $listService->getUser($request->input('token'));

            $userId = $user->id;
            $listId = $request->input('listId');

            DB::beginTransaction();
            $liked = DB::table('like')
                ->where('user_id', '=', $userId)
                ->where('list_id', '=', $listId);
            if ($liked->get()->first()) {
                $liked->delete();
            } else {
                $like = new LikeModel();
                $like->user_id = $userId;
                $like->list_id = $listId;
                $like->created_at = now();
                $like->updated_at = now();
                $like->save();
            }

            $result = $listService->getLikeUsers($listId);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $result = false;
        }
        return response()->json($result);
    }
}