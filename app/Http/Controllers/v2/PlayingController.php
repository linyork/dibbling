<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Model\PlayingModel;
use App\Services\ListService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class PlayingController extends Controller
{
    public function get(ListService $listService)
    {
        try
        {
            $channel = Cookie::get('channel') ?? 'tw';
            $video_id = (int)PlayingModel::where('channel', '=', $channel)->firstOrFail()->video_id;

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
