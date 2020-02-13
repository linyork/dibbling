<?php

namespace App\Http\Controllers\v2;


use App\Helper\YoutubeHelper;
use App\Http\Controllers\Controller;
use App\Model\RecordTable;
use Illuminate\Http\Request;
use App\Model\ListTable;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Url;

class ListController extends Controller
{
    public function list()
    {
        try
        {
            $result = \DB::table('record')
                ->join('users', 'record.user_id', '=', 'users.id')
                ->join('list', 'record.list_id', '=', 'list.id')
                ->where('record.record_type', '=', RecordTable::DIBBLING)
                ->where('list.deleted_at','=', NULL)
                ->orderBy('list.updated_at')
                ->get();
//            $result = RecordTable::with(['list', 'user'])
//                ->FirstOrder()
//                ->get();
//            $result = ListTable::orderBy('updated_at')->get();

        }
        catch (\Exception $e)
        {
            $result = $e;
        }
        return response()->json($result);
    }

    public function played()
    {
        try
        {
            $result = \DB::table('record')
                ->join('users', 'record.user_id', '=', 'users.id')
                ->join('list', 'record.list_id', '=', 'list.id')
                ->where('record.record_type', '=', RecordTable::DIBBLING)
                ->where('list.deleted_at','!=', NULL)
                ->orderBy('list.updated_at', 'DESC')
                ->get();
//            $result = RecordTable::with(['list', 'user'])
//                ->FirstOrder()
//                ->onlyTrashed()
//                ->orderBy('updated_at', 'DESC')
//                ->get();
//            $result = ListTable::onlyTrashed()->orderBy('updated_at', 'DESC')->get();
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
        $result = response()->json($result_test);
        return $result;
    }

    public function play($id)
    {
        try
        {
            $list = ListTable::find($id);
            $list->delete();
            $result_test = ($list->trashed()) ? 'Soft delete success.' : 'Soft delete error.';
        }
        catch (\Exception $e)
        {
            $result_test = $e;
        }
        $result = response()->json($result_test);
        return $result;
    }
}
