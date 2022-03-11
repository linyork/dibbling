<?php

namespace App\Services;

use App\Helpers\YoutubeHelper;
use App\Model\LikeModel;
use App\Model\ListModel;
use App\Model\RecordModel;
use App\Model\TagModel;
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
    protected $tagModel;
    protected $record_type;

    public function __construct(ListModel $listModel,RecordModel $recordModel, UserModel $userModel, LikeModel $likeModel, TagModel $tagModel)
    {
        $this->listModel = $listModel;
        $this->recordModel = $recordModel;
        $this->userModel = $userModel;
        $this->likeModel = $likeModel;
        $this->tagModel = $tagModel;
        $this->record_type = [
            '1' => __('web.dibbling.Dibbling'),
            '2' => __('web.list.ReDibbling'),
            '3' => __('web.list.Cut'),
            '4' => __('web.list.Remove'),
            '5' => __('web.like.Liked')
        ];
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

        // 新增 tag table
        foreach($ytHelper->getTags() as $tag)
        {
            $tagModel = (new TagModel());
            $tagModel->list_id = $this->listModel->id;
            $tagModel->tag = $tag;
            $tagModel->save();
        }
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
        DB::table('tag')->where('list_id', '=', $id)->delete();
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
     * @param int $page
     * @param int $limit
     * @param string $order
     * @return \Illuminate\Support\Collection
     */
    public function getList($page = 1, $limit = 12, $order = '')
    {
        $offset = ($page - 1) * $limit;

        return DB::table('record')
            ->select('users.*', 'list.*', DB::raw('count(like.list_id) as likes'))
            ->join('users', 'record.user_id', '=', 'users.id')
            ->join('list', 'record.list_id', '=', 'list.id')
            ->leftJoin('like', 'record.list_id', '=', 'like.list_id')
            ->where('record.record_type', '=', RecordModel::DIBBLING)
            ->where('list.deleted_at', '=', null)
            ->orderBy($this->getOrder($order))
            ->groupBy('record.id')
            ->limit($limit)
            ->offset($offset)
            ->get();
    }

    /**
     * @param int $page
     * @param int $limit
     * @param $userId
     * @param $songName
     * @param string $order
     * @return \Illuminate\Support\Collection
     */
    public function getPlayed($page = 1, $limit = 12, $userId = null, $songName = null, $order = '')
    {
        $offset = ($page - 1) * $limit;

        $reDibbling_query = $this->recordModel->select('list_id', DB::raw('count(id) as count'))->where('record_type', '=', DB::raw(RecordModel::RE_DIBBLING))->groupBy('list_id');

        return DB::table('record')
            ->select(DB::raw('users.id as user_id'), 'users.*', 'list.*', DB::raw('count(like.list_id) as likes'), DB::raw('MAX(reDib.count) as reDib_count'))
            ->join('users', 'record.user_id', '=', 'users.id')
            ->join('list', 'record.list_id', '=', 'list.id')
            ->leftJoin('like', 'record.list_id', '=', 'like.list_id')
            ->leftJoin( DB::raw("({$reDibbling_query->toSql()}) as reDib"), function( $join ){
                $join->on('record.list_id', '=', 'reDib.list_id');
            })
            ->when($userId, function ($query, $user_id) {
                return $query->where('users.id', '=', $user_id);
            })
            ->when($songName, function ($query, $song_name) {
                return $query->where('list.title', 'like', "%$song_name%");
            })
            ->where('record.record_type', '=', DB::raw(RecordModel::DIBBLING))
            ->where('list.deleted_at', '!=', null)
            ->orderBy($this->getOrder($order), 'DESC')
            ->orderBy('list.updated_at', 'DESC')
            ->groupBy(['record.id','list.updated_at'])
            ->limit($limit)
            ->offset($offset)
            ->get();
    }

    /**
     * @param int $page
     * @param int $limit
     * @param $userId
     * @param string $order
     * @return \Illuminate\Support\Collection
     */
    public function getLiked($page = 1, $limit = 12, $userId = null, $songName = null, $order = '')
    {
        $offset = ($page - 1) * $limit;

        $reDibbling_query = $this->recordModel->select('list_id', DB::raw('count(id) as count'))->where('record_type', '=', DB::raw(RecordModel::RE_DIBBLING))->groupBy('list_id');

        $likes_query = $this->likeModel->select('list_id')->where('user_id', DB::raw($userId))->groupBy('list_id');

        return DB::table('record')
            ->select(DB::raw('users.id as user_id'), 'users.*', 'list.*', DB::raw('count(like.list_id) as likes'), DB::raw('MAX(reDib.count) as reDib_count'))
            ->join('users', 'record.user_id', '=', 'users.id')
            ->join('list', 'record.list_id', '=', 'list.id')
            ->join('like', 'record.list_id', '=', 'like.list_id')
            ->leftJoin( DB::raw("({$reDibbling_query->toSql()}) as reDib"), function( $join ){
                $join->on('record.list_id', '=', 'reDib.list_id');
            })
            ->when($songName, function ($query, $song_name) {
                return $query->where('list.title', 'like', "%$song_name%");
            })
            ->whereIn('record.list_id', $likes_query->pluck('list_id')->toArray())
            ->where('record.record_type', '=', DB::raw(RecordModel::DIBBLING))
            ->orderBy($this->getOrder($order), 'DESC')
            ->orderBy('list.updated_at', 'DESC')
            ->groupBy('record.id')
            ->limit($limit)
            ->offset($offset)
            ->get();
    }


    /**
     * getTimeline
     *
     * @return void
     */
    public function getTimeline($page = 1, $limit = 12, $params = [])
    {
        $offset = ($page - 1) * $limit;

        $record_query = $this->recordModel->select('list_id')
            ->where(['user_id' => DB::raw(Auth::user()->id), 'record_type'=> DB::raw(RecordModel::DIBBLING)])
            ->groupBy('list_id');

        $likes_array = [];
        if (in_array($params['order'],['0', '5']) != false) {
            $likes_array = $this->likeModel
                ->select(DB::raw('like.updated_at as time_at'), DB::raw('5 as record_type'), DB::raw('like.user_id as record_user_id'), DB::raw('user.name as record_user_name'), DB::raw('users.id as user_id'), DB::raw('users.name'), DB::raw('list.title'), DB::raw('list.video_id'), DB::raw('list.seal'))
                ->join('users as user', 'user.id', 'like.user_id')
                ->join('record', ['record.list_id' => 'like.list_id', 'record_type' => DB::raw(RecordModel::DIBBLING)])
                ->join('list', 'record.list_id', 'list.id')
                ->join('users', 'record.user_id', '=', 'users.id')
                ->where(function($query) use($params) {
                    $query->whereBetween('like.updated_at',[date('Y-m-d 00:00:00', strtotime($params['start_date'])), date('Y-m-d 23:59:59', strtotime($params['end_date']))]);
                })
                ->where(function($query) use($record_query) {
                    $query->whereIn('like.list_id', $record_query)
                        ->orWhere('like.user_id', DB::raw(Auth::user()->id));
                });
        }

        $record_array = $this->recordModel
            ->select(DB::raw('(CASE WHEN record.record_type = 1 then record.created_at else record.updated_at END) as time_at'), DB::raw('record.record_type'), DB::raw('record.user_id as record_user_id'), DB::raw('user.name as record_user_name'), DB::raw('users.id as user_id'), DB::raw('users.name'), DB::raw('list.title'), DB::raw('list.video_id'), DB::raw('list.seal'))
            ->join('users as user', 'user.id', 'record.user_id')
            ->join('list', 'list_id', '=', 'list.id')
            ->join('record as list_record', ['list_record.list_id' => 'list.id', 'list_record.record_type' => DB::raw(RecordModel::DIBBLING)])
            ->join('users', 'list_record.user_id', 'users.id')
            ->where(function($query) use($params) {
                $query->whereBetween('record.created_at',[date('Y-m-d 00:00:00', strtotime($params['start_date'])), date('Y-m-d 23:59:59', strtotime($params['end_date']))]);
            })
            ->where(function($query) use($record_query) {
                $query->whereIn('record.list_id', $record_query)
                    ->orWhere('record.user_id', DB::raw(Auth::user()->id));
            })
            ->when($params, function ($query, $params) {
                if ($params['order'] == '0') {
                    return;
                }
                return $query->where('record.record_type', DB::raw($params['order']));
            });

        $union_array = $record_array
            ->when($likes_array, function ($query, $likes_array) {
                if ($likes_array) {
                    $query->unionAll($likes_array);
                }
            })
            ->orderBy('time_at', 'desc')
            ->limit($limit)
            ->offset($offset)
            ->get();

        foreach($union_array as $row) {
            if (($row['record_type'] == '1' && (Auth::user()->id != $row['record_user_id']))) {
                continue;
            }
            $data[] = [
                'action' => $row['record_type'],
                'record_type' => $this->record_type[$row['record_type']],
                'user_id' => $row['user_id'],
                'user_name' => $row['name'],
                'name' => Auth::user()->id == $row['record_user_id'] ? "[".__('web.dibbling.You')."]" : $row['record_user_name'],
                'img' => $row['seal'],
                'title' => $row['title'],
                'time' => date('Y-m-d H:i:s', strtotime($row['time_at'])),
            ];
        }

        return $data ?? [];
    }

    /**
     * @param int $list_id
     * @return \Illuminate\Support\Collection
     */
    public function getRecordInfo(int $list_id)
    {
        return DB::table('record')
            ->select('record.created_at', DB::raw('users.name'), DB::raw('record.record_type'), DB::raw("case record.record_type when 1 then '{$this->record_type[1]}' when 2 then '{$this->record_type[2]}' when 3 then '{$this->record_type[3]}' when 4 then '{$this->record_type[4]}' END as type_txt"))
            ->join('users', 'record.user_id', '=', 'users.id')
            ->join('list', 'record.list_id', '=', 'list.id')
            ->where('record.list_id', DB::raw($list_id))
            ->orderBy('created_at', 'asc')
            ->groupBy('record.id')
            ->get();
    }

    /**
     * @param int $list_id
     * @return \Illuminate\Support\Collection
     */
    public function getLikedInfo(int $list_id)
    {
        return DB::table('like')
            ->select('like.created_at', DB::raw('users.name'), DB::raw("'{$this->record_type[5]}' as type_txt"))
            ->join('users', 'like.user_id', '=', 'users.id')
            ->join('list', 'like.list_id', '=', 'list.id')
            ->where('like.list_id', DB::raw($list_id))
            ->orderBy('created_at', 'asc')
            ->groupBy('like.id')
            ->get();
    }
    /**
     * @param string $order
     * @return string
     */
    public function getOrder(string $order)
    {
        switch( $order )
        {
            case 'dibbling':
                return 'reDib_count';
            case 'likes':
                return 'likes';
            case 'default':
            default:
                return 'list.updated_at';
        }
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
