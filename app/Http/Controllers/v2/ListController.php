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
    /**
     * 清單頁面
     * @param ListService $listService
     * @return Response
     */
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

    /**
     * 紀錄頁面
     * @param Request $request
     * @param ListService $listService
     * @return Response
     */
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

    /**
     * 點播歌曲
     * @param Request $request
     * @param YoutubeHelper $youtubeHelper
     * @return \Illuminate\Http\JsonResponse
     */
    public function insert(Request $request, YoutubeHelper $youtubeHelper, ListService $listService)
    {
        try
        {
            $videoId = $request->input('videoId');
            $youtubeHelper->paser($videoId);
            if ( $youtubeHelper->getStatus() )
            {
                if($listService->getSongByVideoId($videoId)) throw new \Exception('此影片已有人點過');

                $listService->dibbling( $youtubeHelper);
                $returnJson['msg'] = '成功點播"' . $youtubeHelper->getTitle() . '"';
                $returnJson['title'] = $youtubeHelper->getTitle();
            }
            else
            {
                $returnJson['status'] = $youtubeHelper->getStatus();
                $returnJson['title'] = $youtubeHelper->getTitle();
                $returnJson['msg'] = $youtubeHelper->getErrMsg();
            }
        }
        catch (\Exception $e)
        {
            $returnJson['status'] = false;
            $returnJson['msg'] = $e->getMessage();
        }
        return response()->json($returnJson);
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
