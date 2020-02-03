<?php

namespace App\Http\Controllers\v2;


use App\Helper\YoutubeHelper;
use App\Http\Controllers\Controller;
use App\Model\RecordTable;
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
            $returnJson['title'] = $youtubeHelper->getTitle();

            $list = new ListTable;
            $list->video_id = $videoId;
            $list->title = $youtubeHelper->getTitle();
            $list->ip = request()->ip();
            $list->created_at = now();
            $list->updated_at = now();
            $list->save();

            $record = new RecordTable;
            $record->user_id = \Auth::user()->id;
            $record->list_id = $list->id;
            $record->record_type = 1;
            $record->save();
        }
        else
        {
            $returnJson['status'] = false;
            $returnJson['title'] = '點播失敗';
            $returnJson['msg'] = $youtubeHelper->getErrMsg();
        }
        return response()->json($returnJson);
    }

    public function redibbling($id)
    {
        try
        {
            $list = ListTable::onlyTrashed()->find($id);
            $result = $list->restore();
            $record = new RecordTable;
            $record->user_id = \Auth::user()->id;
            $record->list_id = $list->id;
            $record->record_type = 2;
            $record->save();
        }
        catch (\Exception $e)
        {
            $result = false;
        }

        return response()->json($result);
    }

    public function destroy(Request $request, $id)
    {
        try
        {
            $list = ListTable::withTrashed()->find($id);

            $record = new RecordTable;
            $record->user_id = \Auth::user()->id;
            $record->list_id = $id;
            if($request->input('real'))
            {
                $record->record_type = 4;
                $list->forceDelete();
                $result_test = 'Real delete success.';
            }
            else
            {
                $record->record_type = 3;
                $list->delete();
                $result_test = ($list->trashed()) ? 'Soft delete success.' : 'Soft delete error.';
            }

            $record->save();
        }
        catch (\Exception $e)
        {
            $result_test = $e;
        }
        $result = response()->json($result_test);
        return $result;
    }
}
