<?php

namespace App\Services;

use App\Model\LikeTable;
use App\Model\ListTable;
use App\Model\RecordTable;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Yish\Generators\Foundation\Service\Service;

class ListService extends Service
{
    protected $list;
    protected $user;
    protected $like;

    public function __construct(ListTable $list, User $user, LikeTable $like)
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
     * @return User
     */
    public function getDibblingUser(int $listId) : User
    {
        $listModel = $this->list->withTrashed()->with( [ 'records' => function( $query ) {
            $query->dibbling();
        } ] )->find( $listId );

        return User::find( $listModel->records->first()->user_id );
    }

    /**
     * @return mixed
     */
    public function next()
    {
        return $this->list->next()->firstOrFail();
    }

    /**
     * @param int $listId
     * @return LikeTable[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
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
}
