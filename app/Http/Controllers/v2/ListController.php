<?php

namespace App\Http\Controllers\v2;

use App\Helper\YoutubeHelper;
use App\Http\Controllers\Controller;
use App\Model\LikeTable;
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
                ->select('users.*', 'list.*', \DB::raw('count(like.list_id) as likes'))
                ->join('users', 'record.user_id', '=', 'users.id')
                ->join('list', 'record.list_id', '=', 'list.id')
                ->leftJoin('like', 'record.list_id', '=', 'like.list_id')
                ->where('record.record_type', '=', RecordTable::DIBBLING)
                ->where('list.deleted_at', '=', null)
                ->orderBy('list.updated_at')
                ->groupBy('record.id')
                ->get();
            $likes = \DB::table('like')
                ->where('user_id', '=', \Auth::user()->getAuthIdentifier())
                ->get()
                ->keyBy('list_id')
                ->toArray();
        }
        catch (\Exception $e)
        {
            $list = [];
        }
        return response()->view('common.list', ['list' => $list, 'likes' => $likes], 200);
    }

    public function played(Request $request)
    {
        try
        {
            $user_id = $request->post('user_id');
            $song_name = $request->post('song_name');
            $page = $request->post('page');
            $limit = 12;
            $offset = ($page - 1) * $limit;

            $records = \DB::table('record')
                ->select(\DB::raw('users.id as user_id'),'users.*', 'list.*', \DB::raw('count(like.list_id) as likes'))
                ->join('users', 'record.user_id', '=', 'users.id')
                ->join('list', 'record.list_id', '=', 'list.id')
                ->leftJoin('like', 'record.list_id', '=', 'like.list_id')
                ->when($user_id, function ($query, $user_id) {
                    return $query->where('users.id', '=', $user_id);
                })
                ->when($song_name, function ($query, $song_name) {
                    return $query->where('list.title', 'like', "%$song_name%");
                })
                ->where('record.record_type', '=', RecordTable::DIBBLING)
                ->where('list.deleted_at', '!=', null)
                ->orderBy('list.updated_at', 'DESC')
                ->groupBy('record.id')
                ->limit($limit)
                ->offset($offset)
                ->get();

            if ( ! $records )
            {
                return response()->json([]);
            }

            $likes = LikeTable::with('user')->get();
            $record_data = ['records' => $records, 'likes' => $likes];
        }
        catch (\Exception $e)
        {
            $record_data = ['records' => [], 'likes' => []];
        }
        return response()->view('common.record', $record_data, 200);
    }

    public function insert(Request $request, YoutubeHelper $youtubeHelper)
    {
        $videoId_string = $request->input('videoId');
        if ( strlen($videoId_string) >= 12 )
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

            if ( $request->input('real') )
            {
                \DB::table('record')->where('list_id', '=', $id)->delete();
                \DB::table('like')->where('list_id', '=', $id)->delete();
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
