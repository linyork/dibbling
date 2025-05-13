<?php

namespace App\Http\Controllers\v2;

use App\Helpers\YoutubeHelper;
use App\Http\Controllers\Controller;
use App\Services\ListService;
use App\Model\RecordModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    /**
     * 清單頁面
     * @param ListService $listService
     * @return Response
     */
    public function list(Request $request, ListService $listService)
    {
        try
        {
            $page = $request->post( 'page' );
            $limit = $request->post( 'limit' );
            $record_data['list'] = $listService->getList($page, $limit);
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
            $limit = $request->post( 'limit' );
            $order = $request->post( 'order' );
            $user_id = $request->post( 'user_id' );
            $song_name = $request->post( 'song_name' );

            $record_data['records'] = $listService->getPlayed( $page, $limit, $user_id, $song_name, $order );
            $record_data['likes'] = $listService->getLikes( array_keys( $record_data['records']->keyBy( 'id' )->toArray() ) );
        }
        catch (\Exception $e)
        {
            $record_data = [ 'records' => [], 'likes' => [] ];
        }
        return response()->view( 'common.record', $record_data, Response::HTTP_OK );
    }

    /**
     * 喜歡頁面
     * @param Request $request
     * @param ListService $listService
     * @return Response
     */
    public function liked(Request $request, ListService $listService)
    {
        try
        {
            $page = $request->post( 'page' );
            $limit = $request->post( 'limit' );
            $order = $request->post( 'order' );
            $user_id = $request->post( 'user_id' );
            $song_name = $request->post( 'song_name' );

            $liked_data['records'] = $listService->getLiked( $page, $limit, $user_id, $song_name, $order );
            $liked_data['likes'] = $listService->getLikes( array_keys( $liked_data['records']->keyBy( 'id' )->toArray() ) );
        }
        catch (\Exception $e)
        {
            $liked_data = [ 'records' => [], 'likes' => [] ];
        }
        return response()->view( 'common.record', $liked_data, Response::HTTP_OK );
    }

    /**
     * 資訊頁面
     * @param Request $request
     * @param ListService $listService
     * @return Response
     */
    public function info(Request $request, ListService $listService)
    {
        try
        {
            $list_id = $request->post( 'list_id' );

            $info_data['records'] = $listService->getRecordInfo($list_id)->toArray();
            $info_data['like'] = $listService->getLikedInfo($list_id)->toArray();

            $ret_data = array_merge($info_data['records'], $info_data['like']);
        }
        catch (\Exception $e)
        {
            $ret_data = [];
        }

        //排序
        usort($ret_data, fn($a,$b) => $a->created_at > $b->created_at);

        return response()->json( $ret_data );
    }

    /**
     * 設定播放起訖時間
     * @param Request $request
     * @param ListService $listService
     * @return Response
     */
    public function setRange(Request $request, ListService $listService)
    {
        $result = [
            'status' => false,
            'msg' => __('web.msg.SetRange Error'),
        ];

        try
        {
            $list_id = $request->post('list_id');
            $max = $request->post('max');
            $min = $request->post('min');

            $list = $listService->getRecordInfo($list_id)->first();

            // 只有 admin 或自己可以操作
            $user = Auth::user();
            if ($user->id == $list->user_id || $user->role === 'admin') {
                if ($min < $max && $max <= $list->duration) {
                    $ret = $listService->setSongRange($list_id, $min, $max);
                    if ($ret) {
                        $result = [
                            'status' => true,
                            'msg' => __('web.msg.Success'),
                        ];
                    }
                }
            } else {
                $result['msg'] = __('web.msg.Access Denied');
            }
        }
        catch (\Exception $e)
        {
            $result = [
                'status' => false,
                'msg' => $e->getMessage(),
            ];
        }
        return response()->json($result);
    }

    /**
     * 點播歷程
     * @param Request $request
     * @param ListService $listService
     * @return Response
     */
    public function timeline(Request $request, ListService $listService)
    {
        try
        {
            $page = $request->post( 'page' );
            $limit = $request->post( 'limit' );

            $params = [
                'start_date' => $request->post('start_date'),
                'end_date' => $request->post('end_date'),
                'order' => $request->post('order') ?? '0',
            ];
            $ret_data['list'] = $listService->getTimeline($page, $limit, $params);
        }
        catch (\LogicException $e)
        {
            $ret_data['msg'] = $e->getMessage();
            return response()->json($ret_data);
        }

        return response()->view( 'common.timeline', $ret_data, Response::HTTP_OK );
    }

    /**
     * 點播歌曲
     * @param Request $request
     * @param YoutubeHelper $youtubeHelper
     * @param ListService $listService
     * @return \Illuminate\Http\JsonResponse
     */
    public function insert(Request $request, YoutubeHelper $youtubeHelper, ListService $listService)
    {
        try
        {
            $videoId = $request->input('videoId');
            $youtubeHelper->parser($videoId);
            if ( $youtubeHelper->getStatus() )
            {
                if( $this_video = $listService->getSongByVideoId( $youtubeHelper->getVideoId() )->first() )
                {
                    // 已被刪除的點播人歌曲，直接賦予給最新點播的使用者
                    $dibblingUser = $listService->getDibblingUser($this_video['id']);
                    if ($dibblingUser->trashed()) {
                        $listService->reDibbling($this_video['id'], RecordModel::DIBBLING);
                        $returnJson['msg'] = __('web.msg.Dibbling Success').PHP_EOL.PHP_EOL.$youtubeHelper->getTitle();
                        $returnJson['title'] = $youtubeHelper->getTitle();
                    } else {
                        throw new \LogicException( __('web.msg.Dibbling Exist',['title' => $this_video['title'], 'user' => $dibblingUser->name]) );
                    }
                } else {
                    $listService->dibbling( $youtubeHelper);
                    $returnJson['msg'] = __('web.msg.Dibbling Success').PHP_EOL.PHP_EOL.$youtubeHelper->getTitle();
                    $returnJson['title'] = $youtubeHelper->getTitle();
                }
            }
            else
            {
                $returnJson['status'] = $youtubeHelper->getStatus();
                $returnJson['title'] = $youtubeHelper->getTitle();
                $returnJson['msg'] = $youtubeHelper->getErrMsg();
            }
        }
        catch (\LogicException $e)
        {
            $returnJson['status'] = false;
            $returnJson['redibbling_id'] = $this_video['id'];
            $returnJson['msg'] = $e->getMessage();
        }
        catch (\Exception $e)
        {
            $returnJson['status'] = false;
            $returnJson['msg'] = $e->getMessage();
        }
        return response()->json($returnJson);
    }

    /**
     * 再點播
     * @param ListService $listService
     * @param $id
     * @param $recordType
     * @return \Illuminate\Http\JsonResponse
     */
    public function redibbling(ListService $listService, $id, $recordType = RecordModel::RE_DIBBLING)
    {
        try
        {
            $result = $listService->reDibbling($id, $recordType);
        }
        catch (\Exception $e)
        {
            $result = false;
        }
        return response()->json($result);
    }

    /**
     * @param Request $request
     * @param ListService $listService
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, ListService $listService, $id)
    {
        try
        {
            if ( $request->input('real') == 'true' )
            {
                $result_test = $listService->realDelete($id);
            }
            else
            {
                $result_test = $listService->softDelete($id);
            }
        }
        catch (\Exception $e)
        {
            $result_test = $e;
        }
        return response()->json($result_test);
    }
}
