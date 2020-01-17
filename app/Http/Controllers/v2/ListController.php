<?php

namespace App\Http\Controllers\v2;


use App\Helper\YoutubeHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\ListTable;

class ListController extends Controller
{
    public function list()
    {
        try
        {
            $result = ListTable::orderBy('updated_at')->get();
        }
        catch (\Exception $e)
        {
            $result = [];
        }
        return response()->json($result);
    }

    public function played()
    {
        try
        {
            $result = ListTable::onlyTrashed()->orderBy('updated_at', 'DESC')->get();
        }
        catch (\Exception $e)
        {
            $result = [];
        }
        return response()->json($result);
    }

    public function random()
    {
        try
        {
            $result = ListTable::onlyTrashed()->inRandomOrder()->first();
        }
        catch (\Exception $e)
        {
            $result = [];
        }
        return response()->json($result);
    }

    public function insert(Request $request, YoutubeHelper $youtubeHelper)
    {
        $videoId = $request->input('videoId');
        $returnJson = [
            'videoId' => $videoId,
            'status' => true,
            'title' => '點播成功',
            'msg' => '',
        ];

        $youtubeHelper->paser($videoId);
        if ( $youtubeHelper->getStatus() )
        {
            \DB::table('list')->insert(
                [
                    'video_id' => $videoId,
                    'title' => $youtubeHelper->getTitle(),
                    'ip' => request()->ip(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
            $returnJson['title'] = $youtubeHelper->getTitle();
        }
        else
        {
            $returnJson['status'] = false;
            $returnJson['title'] = '點播失敗';
            $returnJson['msg'] = $youtubeHelper->getErrMsg();
        }
        return response()->json($returnJson);
    }
}
