<?php

namespace App\Http\Controllers\v2;

use App\Helper\YoutubeHelper;
use App\Http\Controllers\Controller;
use App\Model\ListModel;
use App\Model\RecordModel;
use App\Services\ListService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ListController extends Controller
{
    public function list(ListService $listService)
    {
        try
        {
            $record_data['list'] = $listService->getList();
            $record_data['likes'] = $listService->getLikes( array_keys( $record_data['list']->keyBy( 'id' )->toArray() ) );
        }
        catch (\Exception $e)
        {
            $record_data = [ 'list' => [], 'likes' => [] ];
        }
        return response()->view( 'common.list', $record_data, Response::HTTP_OK );
    }

    public function played(Request $request, ListService $listService)
    {
        try
        {
            $page = $request->post( 'page' );
            $user_id = $request->post( 'user_id' );
            $song_name = $request->post( 'song_name' );

            $record_data['records'] = $listService->getPlayed( $page, $user_id, $song_name );
            $record_data['likes'] = $listService->getLikes( array_keys( $record_data['records']->keyBy( 'id' )->toArray() ) );
        }
        catch (\Exception $e)
        {
            $record_data = [ 'records' => [], 'likes' => [] ];
        }
        return response()->view( 'common.record', $record_data, Response::HTTP_OK );
    }

    public function insert(Request $request, YoutubeHelper $youtubeHelper)
    {
        try
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
                $list = \DB::table('list')
                    ->where('video_id', '=',$videoId)
                    ->limit(1)
                    ->get()
                    ->toArray();
                if($list){
                    $returnJson['msg'] = '此影片已有人點過';
                    $returnJson['status'] = false;
                    $returnJson['title'] = '重複';
                    return response()->json($returnJson);
                }
                $list = new ListModel;
                $list->video_id = $videoId;
                $list->title = $youtubeHelper->getTitle();
                $list->seal = $youtubeHelper->getSeal();
                $list->duration = $youtubeHelper->getDuration();
                $list->ip = request()->ip();
                $list->created_at = now();
                $list->updated_at = now();
                $list->save();
                $returnJson['msg'] = '成功點播"' . $youtubeHelper->getTitle() . '"';
                $returnJson['title'] = $youtubeHelper->getTitle();

                $record = new RecordModel;
                $record->user_id = \Auth::user()->id;
                $record->list_id = $list->id;
                $record->record_type = RecordModel::DIBBLING;
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
        catch (\Exception $e)
        {
            return response()->json($e->getMessage());
        }
    }

    public function redibbling($id)
    {
        try
        {
            $list = ListModel::onlyTrashed()->find($id);
            $result = $list->restore();
            $record = new RecordModel;
            $record->user_id = \Auth::user()->id;
            $record->list_id = $list->id;
            $record->record_type = RecordModel::RE_DIBBLING;
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
            $list = ListModel::withTrashed()->find($id);

            if ( $request->input('real') )
            {
                \DB::table('record')->where('list_id', '=', $id)->delete();
                \DB::table('like')->where('list_id', '=', $id)->delete();
                $list->forceDelete();
                $result_test = 'Real delete success.';
            }
            else
            {
                $record = new RecordModel;
                $record->user_id = \Auth::user()->id;
                $record->list_id = $id;
                $record->record_type = RecordModel::CUT;
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
