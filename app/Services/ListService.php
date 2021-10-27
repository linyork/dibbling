<?php

namespace App\Services;

use App\Model\LikeModel;
use App\Model\ListModel;
use App\Model\RecordModel;
use App\Model\UserModel;
use Illuminate\Database\Eloquent\Model;
use Yish\Generators\Foundation\Service\Service;

class ListService extends Service
{
    protected $list;
    protected $user;
    protected $like;

    public function __construct(ListModel $list, UserModel $user, LikeModel $like)
    {
        $this->list = $list;
        $this->user = $user;
        $this->like = $like;
    }

    /**
     * @param int $listId
     * @return \Illuminate\Database\Eloquent\Collection|Model
     */
    public function getPlaying(int $listId)
    {
        return $this->list->withTrashed()->find($listId);
    }

    /**
     * @param int $listId
     * @return UserModel
     */
    public function getDibblingUser(int $listId) : UserModel
    {
        $listModel = $this->list->withTrashed()->with( [ 'records' => function( $query ) {
            $query->dibbling();
        } ] )->find( $listId );

        return UserModel::find( $listModel->records->first()->user_id );
    }

    /**
     * @return mixed
     */
    public function next()
    {
        return $this->list->next()->first();
    }

    /**
     * @param int $listId
     * @return LikeModel[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getLikeUsers(int $listId)
    {
        return $this->like
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
        return $this->like
            ->where('user_id', '=', $userId)
            ->where('list_id', '=', $listId)
            ->first();
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

        return \DB::table('record')
            ->select(\DB::raw('users.id as user_id'),'users.*', 'list.*', \DB::raw('count(like.list_id) as likes'))
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
            ->where('list.deleted_at', '!=', null)
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
        return $this->like->whereIn('list_id', $listIds)->with('user')->get();
    }
}
