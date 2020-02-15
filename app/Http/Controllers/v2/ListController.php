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
            $list = \DB::table('record')
                ->join('users', 'record.user_id', '=', 'users.id')
                ->join('list', 'record.list_id', '=', 'list.id')
                ->where('record.record_type', '=', RecordTable::DIBBLING)
                ->where('list.deleted_at','=', NULL)
                ->orderBy('list.updated_at')
                ->get();
        }
        catch (\Exception $e)
        {
            $list = [];
        }
        return response()->view('common.list', ['list' => $list], 200);
    }

    public function played()
    {
        try
        {
            $records = \DB::table('record')
                ->join('users', 'record.user_id', '=', 'users.id')
                ->join('list', 'record.list_id', '=', 'list.id')
                ->where('record.record_type', '=', RecordTable::DIBBLING)
                ->where('list.deleted_at','!=', NULL)
                ->orderBy('list.updated_at', 'DESC')
                ->get();
        }
        catch (\Exception $e)
        {
            $records = [];
        }
        return response()->view('common.record', ['records' => $records], 200);
    }


    public function insert(Request $request, YoutubeHelper $youtubeHelper)
    {
        $videoId_string = $request->input('videoId');
        if(strlen($videoId_string) >= 12)
        {
            parse_str(parse_url($videoId_string, PHP_URL_QUERY), $get);
            $videoId = $get['v'];
        }
        else
        {
            $videoId = $videoId_string;
        }

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
            $list->seal = $youtubeHelper->getSeal();
            $list->duration = $youtubeHelper->getDuration();
            $list->ip = request()->ip();
            $list->created_at = now();
            $list->updated_at = now();
            $list->save();

            $record = new RecordTable;
            $record->user_id = \Auth::user()->id;
            $record->list_id = $list->id;
            $record->record_type = RecordTable::DIBBLING;
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
            $record->record_type = RecordTable::RE_DIBBLING;
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

            if($request->input('real'))
            {
                \DB::table('record')->where('list_id','=', $id)->delete();
                $list->forceDelete();
                $result_test = 'Real delete success.';
            }
            else
            {
                $record = new RecordTable;
                $record->user_id = \Auth::user()->id;
                $record->list_id = $id;
                $record->record_type = RecordTable::CUT;
                $list->delete();
                $result_test = ($list->trashed()) ? 'Soft delete success.' : 'Soft delete error.';
            }

            $record->save();
        }
        catch (\Exception $e)
        {
            $result_test = $e;
        }
        return response()->json($result_test);
    }

}
