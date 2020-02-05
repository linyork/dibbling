<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecordTable extends Model
{
    use SoftDeletes;

    protected $table = 'record';
    protected $primaryKey = 'id';

    /**
     * @return BelongsTo
     */
    public function list()
    {
        return $this->belongsTo(ListTable::class, 'list_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeFirstOrder($query)
    {
        return $query->where('record_type', 1);
    }
}
