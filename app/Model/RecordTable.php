<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class RecordTable extends Model
{
    public const DIBBLING = 1;
    public const RE_DIBBLING = 2;
    public const CUT = 3;

    protected $table = 'record';
    protected $primaryKey = 'id';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function list()
    {
        return $this->belongsTo(ListTable::class, 'list_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
