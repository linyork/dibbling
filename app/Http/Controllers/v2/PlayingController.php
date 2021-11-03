<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Model\PlayingModel;
use App\Services\ListService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PlayingController extends Controller
{
    public function get(ListService $listService)
    {
        try
        {
            $video_id = (int)PlayingModel::firstOrFail()->video_id;

            $data = [
                'playing' => $listService->getPlaying( $video_id ),
                'dibblingUser' => $listService->getDibblingUser( $video_id ),
                'next' => $listService->next(),
                'likes' => $listService->getLikeUsers( $video_id ),
                'isLike' => $listService->getUserIsLike( $video_id, Auth::user()->getAuthIdentifier()),
            ];
        }
        catch (\Exception $e)
        {
            $data = [];
        }

        return response()->view('common.video_interface', $data, Response::HTTP_OK);
    }
}
