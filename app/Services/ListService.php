<?php

namespace App\Services;

use App\Helper\YoutubeHelper;
use App\Model\LikeModel;
use App\Model\ListModel;
use App\Model\RecordModel;
use App\Model\UserModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yish\Generators\Foundation\Service\Service;

class ListService extends Service
{
    protected $listModel;
    protected $recordModel;
    protected $userModel;
    protected $likeModel;

    public function __construct(ListModel $listModel,RecordModel $recordModel, UserModel $userModel, LikeModel $likeModel)
    {
        $this->listModel = $listModel;
        $this->recordModel = $recordModel;
        $this->userModel = $userModel;
        $this->likeModel = $likeModel;
    }

    /**
     * @param YoutubeHelper $ytHelper
     */
    public function dibbling(YoutubeHelper $ytHelper)
    {
        // 新增 list table
        $this->listModel->video_id = $ytHelper->getVideoId();
        $this->listModel->title = $ytHelper->getTitle();
        $this->listModel->seal = $ytHelper->getSeal();
        $this->listModel->duration = $ytHelper->getDuration();
        $this->listModel->ip = request()->ip();
        $this->listModel->created_at = now();
        $this->listModel->updated_at = now();
        $this->listModel->save();

        // 新增 record table
        $this->recordModel->user_id = Auth::user()->id;
        $this->recordModel->list_id = $this->listModel->id;
        $this->recordModel->record_type = RecordModel::DIBBLING;
        $this->recordModel->save();

    }

    /**
     * @param int $id
     * @return bool|null
     */
    public function reDibbling(int $id)
    {
        $result = $this->listModel::onlyTrashed()->find($id)->restore();
        $this->recordModel->user_id = Auth::user()->id;
        $this->recordModel->list_id = $id;
        $this->recordModel->record_type = RecordModel::RE_DIBBLING;
        $this->recordModel->save();
        return $result;
    }

    /**
     * @param int $id
     * @return string
     */
    public function realDelete(int $id) : string
    {
        $list = $this->listModel->withTrashed()->find($id);
        $list->forceDelete();
        DB::table('record')->where('list_id', '=', $id)->delete();
        DB::table('like')->where('list_id', '=', $id)->delete();
        return 'Real delete success.';
    }

    /**
     * softDelete
     *
     * @param int $id
     * @return string
     */
    public function softDelete(int $id) : string
    {
        $list = $this->listModel->withTrashed()->find($id);
        $list->delete();
        $softDelete = $list->trashed();
        if($softDelete)
        {
            $this->recordModel->user_id = Auth::user()->id;
            $this->recordModel->list_id = $id;
            $this->recordModel->record_type = RecordModel::CUT;
            $this->recordModel->save();
        }

        return $softDelete ? 'Soft delete success.' : 'Soft delete error.';
    }

    /**
     * @param int $listId
     * @return \Illuminate\Database\Eloquent\Collection|Model
     */
    public function getPlaying(int $listId)
    {
        return $this->listModel->withTrashed()->find($listId);
    }

    /**
     * @param string $videoId
     * @return ListModel[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function getSongByVideoId(string $videoId)
    {
        return $this->listModel
            ->withTrashed()
            ->where('video_id', '=',$videoId)
            ->get();
    }

    /**
     * @param int $listId
     * @return UserModel
     */
    public function getDibblingUser(int $listId) : UserModel
    {
        $listModel = $this->listModel->withTrashed()->with( [ 'records' => function( $query ) {
            $query->dibbling();
        } ] )->find( $listId );

        return UserModel::find( $listModel->records->first()->user_id );
    }

    /**
     * @return mixed
     */
    public function next()
    {
        return $this->listModel->next()->first();
    }

    /**
     * @param int $listId
     * @return LikeModel[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getLikeUsers(int $listId)
    {
        return $this->likeModel
            ->with('user')
            ->where('list_id', '=', $listId)
            ->get();
    }

    /**
     * @param int $listId
     * @param int $userId
     * @return mixed
     */
    public function getUserIsLike(int $listId, int $userId)
    {
        return $this->likeModel
            ->where('user_id', '=', $userId)
            ->where('list_id', '=', $listId)
            ->first();
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return DB::table('record')
            ->select('users.*', 'list.*', DB::raw('count(like.list_id) as likes'))
            ->join('users', 'record.user_id', '=', 'users.id')
            ->join('list', 'record.list_id', '=', 'list.id')
            ->leftJoin('like', 'record.list_id', '=', 'like.list_id')
            ->where('record.record_type', '=', RecordModel::DIBBLING)
            ->where('list.deleted_at', '=', null)
            ->orderBy('list.updated_at')
            ->groupBy('record.id')
            ->get();
    }

    /**
     * @param int $page
     * @param int $userId
     * @param string $songName
     * @return mixed
     */
    public function getPlayed($page, $userId, $songName)
    {
        $limit = 12;
        $offset = ($page - 1) * $limit;

        return DB::table('record')
            ->select(DB::raw('users.id as user_id'),'users.*', 'list.*', DB::raw('count(like.list_id) as likes'))
            ->join('users', 'record.user_id', '=', 'users.id')
            ->join('list', 'record.list_id', '=', 'list.id')
            ->leftJoin('like', 'record.list_id', '=', 'like.list_id')
            ->when($userId, function ($query, $user_id) {
                return $query->where('users.id', '=', $user_id);
            })
            ->when($songName, function ($query, $song_name) {
                return $query->where('list.title', 'like', "%$song_name%");
            })
            ->where('record.record_type', '=', RecordModel::DIBBLING)
            //->where('list.deleted_at', '!=', null)
            ->orderBy('list.updated_at', 'DESC')
            ->groupBy('record.id')
            ->limit($limit)
            ->offset($offset)
            ->get();
    }

    /**
     * @param int $page
     * @param int $userId
     * @return mixed
     */
    public function getLiked($page)
    {
        $limit = 12;
        $offset = ($page - 1) * $limit;

        return DB::table('record')
            ->select(DB::raw('users.id as user_id'),'users.*', 'list.*', DB::raw('count(like.list_id) as likes'))
            ->join('users', 'record.user_id', '=', 'users.id')
            ->join('list', 'record.list_id', '=', 'list.id')
            ->join('like', 'record.list_id', '=', 'like.list_id')
            ->where('record.record_type', '=', RecordModel::DIBBLING)
            ->where('like.user_id', '=',  Auth::user()->id)
            ->orderBy('list.updated_at', 'DESC')
            ->groupBy('record.id')
            ->limit($limit)
            ->offset($offset)
            ->get();
    }

    /**
     * @param array $listIds
     * @return mixed
     */
    public function getLikes(array $listIds)
    {
        return $this->likeModel->whereIn('list_id', $listIds)->with('user')->get();
    }
}
