<?php

namespace App\Http\Controllers\v3;

use App\Helpers\YoutubeHelper;
use App\Http\Controllers\Controller;
use App\Services\ListServiceV3;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ListController extends Controller {
    /**
     * 清單頁面
     * @param ListService $listService
     * @return Response
     */
    public function list(Request $request, ListServiceV3 $listService) {
        try {
            $user = $listService->getUser($request->input('token'));
            if (!$user) return false;

            $page = $request->input('page');
            $limit = $request->input('limit');

            $record_data = $listService->getList($page, $limit);

            //get liked users
            $record_data = $this->mergeLikeUsers($record_data, $listService);
        } catch (\Exception $e) {
            $record_data = [];
        }
        return response()->json($record_data);
    }

    /**
     * 紀錄頁面
     * @param Request $request
     * @param ListService $listService
     * @return Response
     */
    public function played(Request $request, ListServiceV3 $listService) {
        try {
            $user = $listService->getUser($request->input('token'));
            if (!$user) return false;

            $page = $request->input('page');
            $limit = $request->input('limit');
            $order = $request->input('order');
            $user_id = $request->input('userId');
            $song_name = $request->input('search');

            $record_data = $listService->getPlayed($page, $limit, $user_id, $song_name, $order);

            //get liked users
            $record_data = $this->mergeLikeUsers($record_data, $listService);
        } catch (\Exception $e) {
            $record_data = [];
        }
        return response()->json($record_data);
    }

    /**
     * 喜歡頁面
     * @param Request $request
     * @param ListService $listService
     * @return Response
     */
    public function liked(Request $request, ListServiceV3 $listService) {
        try {
            $user = $listService->getUser($request->input('token'));
            if (!$user) return false;

            $page = $request->input('page');
            $limit = $request->input('limit');
            $order = $request->input('order');
            $user_id = $request->input('userId');
            $song_name = $request->input('search');

            $liked_data = $listService->getLiked($page, $limit, $user_id, $song_name, $order);

            //get liked users
            $liked_data = $this->mergeLikeUsers($liked_data, $listService);
        } catch (\Exception $e) {
            $liked_data = [];
        }
        return response()->json($liked_data);
    }

    public function mergeLikeUsers($list, $listService) {
        foreach ($list as $idx => $row) {
            if ($row->likes > 0) {
                $list[$idx]->liked = $listService->getLikeUsers($row->id);
            } else {
                $list[$idx]->liked = [];
            }
        }
        return $list;
    }

    /**
     * 資訊頁面
     * @param Request $request
     * @param ListService $listService
     * @return Response
     */
    public function info(Request $request, ListServiceV3 $listService) {
        try {
            $user = $listService->getUser($request->input('token'));
            if (!$user) return false;

            $list_id = $request->input('listId');

            $info_data['records'] = $listService->getRecordInfo($list_id)->toArray();
            $info_data['like'] = $listService->getLikedInfo($list_id)->toArray();

            $ret_data = array_merge($info_data['records'], $info_data['like']);
        } catch (\Exception $e) {
            $ret_data = [];
        }

        //排序
        usort($ret_data, fn ($a, $b) => $a->created_at > $b->created_at);

        return response()->json($ret_data);
    }


    /**
     * 點播歷程
     * @param Request $request
     * @param ListService $listService
     * @return Response
     */
    public function timeline(Request $request, ListServiceV3 $listService) {
        try {
            $user = $listService->getUser($request->input('token'));
            if (!$user) return false;

            $page = $request->input('page');
            $limit = $request->input('limit');

            $params = [
                'user_id' => $user->id,
                'start_date' => $request->input('startDate'),
                'end_date' => $request->input('endDate'),
                'order' => $request->input('order') ?? '0',
            ];
            $result = $listService->getTimeline($page, $limit, $params);
        } catch (\LogicException $e) {
            $result = false;
        }

        return response()->json($result);
    }

    /**
     * 點播歌曲
     * @param Request $request
     * @param YoutubeHelper $youtubeHelper
     * @param ListService $listService
     * @return \Illuminate\Http\JsonResponse
     */
    public function dibbling(Request $request, YoutubeHelper $youtubeHelper, ListServiceV3 $listService) {
        try {
            $user = $listService->getUser($request->input('token'));
            if (!$user) return false;

            $videoId = $request->input('videoId');
            $youtubeHelper->parser($videoId);
            if ($youtubeHelper->getStatus()) {
                if ($this_video = $listService->getSongByVideoId($youtubeHelper->getVideoId())->first()) {
                    throw new \LogicException('exist');
                }

                $listService->dibbling($user->id, $youtubeHelper);
            }
            $returnJson['status'] = $youtubeHelper->getStatus();
            $returnJson['title'] = $youtubeHelper->getTitle();
            $returnJson['msg'] = $youtubeHelper->getErrMsg();
        } catch (\LogicException $e) {
            $returnJson['status'] = false;
            $returnJson['msg'] = $e->getMessage();
            $returnJson['list'] = [
                'id' => $this_video['id'],
                'title' => $this_video['title'],
                'user' => $listService->getDibblingUser($this_video['id'])->name
            ];
        } catch (\Exception $e) {
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
    public function redibbling(Request $request, ListServiceV3 $listService) {
        try {
            $user = $listService->getUser($request->input('token'));
            if (!$user) return false;

            $listId = $request->input('listId');
            $result = $listService->reDibbling($listId, $user->id);
        } catch (\Exception $e) {
            $result = false;
        }
        return response()->json($result);
    }

    /**
     * @param Request $request
     * @param ListService $listService
     * @return \Illuminate\Http\JsonResponse
     */
    public function cut(Request $request, ListServiceV3 $listService) {
        try {
            $user = $listService->getUser($request->input('token'));
            if (!$user) return false;

            if ($request->input('realDelete') == 'true') {
                $result = $listService->realDelete($request->input('listId'));
            } else {
                $result = $listService->softDelete($request->input('listId'), $user->id);
            }
        } catch (\Exception $e) {
            $result = false;
        }
        return response()->json($result);
    }
}