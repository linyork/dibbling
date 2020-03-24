<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListTable extends Model
{
    use SoftDeletes;

    protected $table = 'list';
    protected $primaryKey = 'id';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function records()
    {
        return $this->hasMany(RecordTable::class, 'list_id', 'id');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeWithDibblingById ($query, $id)
    {
        return $query->withTrashed()
            ->join('record', 'record.list_id', '=', 'list.id')
            ->join('users', 'users.id', '=', 'record.user_id')
            ->where('record.record_type', '=', RecordTable::DIBBLING)
            ->where('list.id', '=', $id);
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
            ->where('record.record_type', '=', RecordTable::DIBBLING)
            ->where('list.deleted_at', NULL)
            ->orderBy('list.updated_at');
    }
}
