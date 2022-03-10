<?php

namespace App\Http\Controllers\v2;

use App\Helpers\YoutubeHelper;
use App\Http\Controllers\Controller;
use App\Services\ListService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

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
     * 點播歷程
     * @param Request $request
     * @param ListService $listService
     * @return Response
     */
    public function timeline(Request $request, ListService $listService)
    {
        try
        {
            $page = $request->post( 'page' ) ?? 1;
            $order = $request->post('order') ?? '0';
            $start_date_original = $request->post('start_date');
            $end_date_original = $request->post('end_date');
            if (carbon::parse($start_date_original)->diffInDays($end_date_original, false) < 0) {
                throw new \LogicException(__('web.msg.SelectorDate'));
            }

            //get duration of page
            $start_today = $page == 1 ? 1 : 0;
            $search_by_month = 2;
            $ed_month = ($page - 1) * $search_by_month;
            $st_month = $ed_month + $search_by_month;
            $start_date = date("Y-m-d", strtotime("-{$st_month} month"));
            $end_date = date("Y-m-d", strtotime("+{$start_today} day", strtotime("-{$ed_month} month")));

            if (carbon::parse($end_date)->diffInDays($end_date_original, false) < -($start_today)) {
                $end_date = $end_date_original;
            }
            if (carbon::parse($start_date_original)->diffInDays($end_date, false) < 0) {
                $end_date = $start_date_original;
            }
            if (carbon::parse($start_date_original)->diffInDays($start_date, false) < 0) {
                $start_date = $start_date_original;
            }

            $params = [
                'start_date' => $start_date,
                'end_date' => $end_date,
                'order' => $order,
            ];
            $ret_data['list'] = $listService->getTimeline($params);
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
                    throw new \LogicException( __('web.msg.Dibbling Exist',['title' => $this_video['title'], 'user' => $listService->getDibblingUser($this_video['id'])->name]) );
                }

                $listService->dibbling( $youtubeHelper);
                $returnJson['msg'] = __('web.msg.Dibbling Success').PHP_EOL.PHP_EOL.$youtubeHelper->getTitle();
                $returnJson['title'] = $youtubeHelper->getTitle();
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function redibbling(ListService $listService, $id)
    {
        try
        {
            $result = $listService->reDibbling($id);
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
