<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListModel extends Model
{
    use SoftDeletes;

    protected $table = 'list';
    protected $primaryKey = 'id';

    public function records()
    {
        return $this->hasMany(RecordModel::class, 'list_id', 'id');
    }

    public function like()
    {
        return $this->hasMany(LikeModel::class, 'list_id', 'id');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNext ($query)
    {
        return $query->withTrashed()
            ->join('record', 'record.list_id', '=', 'list.id')
            ->join('users', 'users.id', '=', 'record.user_id')
            ->where('record.record_type', '=', RecordModel::DIBBLING)
            ->where('list.deleted_at', NULL)
            ->orderBy('list.updated_at');
    }
}
