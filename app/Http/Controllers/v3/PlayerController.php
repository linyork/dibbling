<?php

namespace App\Http\Controllers\v3;

use App\Http\Controllers\Controller;
use App\Model\ListModel;
use Illuminate\Support\Facades\DB;
use App\Services\ListServiceV3;

class PlayerController extends Controller {
    public function next(ListServiceV3 $listService) {
        try {
            DB::beginTransaction();

            $playedList = $listService->getPlaying();

            if ($playedList) {
                ListModel::withTrashed()->find($playedList->list_id)->delete();
                $listResult = $playedList;
            } else {
                $listResult = ListModel::onlyTrashed()->where('deleted_at', '<', date('Y-m-d', strtotime('-7 day')))->inRandomOrder()
                    ->first();
                if (!$listResult) {
                    $listResult = ListModel::onlyTrashed()->inRandomOrder()->first();
                }
                //update deleted_at
                $listResult->deleted_at = now();
                $listResult->timestamps = false;
                $listResult->save();
                $listResult = $listService->getPlaying($listResult->id);
            }

            $listResult->liked = $listService->getLikeUsers($listResult->list_id);
            $listResult->next = $listService->next();

            if (DB::table('playing')->first()) {
                DB::table('playing')->update(['video_id' => $listResult->id]);
            } else {
                DB::table('playing')->insert(['video_id' => $listResult->id]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $listResult = false;
        }
        return response()->json($listResult);
    }
}