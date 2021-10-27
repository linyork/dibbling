<?php

namespace App\Model;

use App\Model\UserModel;
use Illuminate\Database\Eloquent\Model;

class RecordTable extends Model
{
    public const DIBBLING = 1;
    public const RE_DIBBLING = 2;
    public const CUT = 3;

    protected $table = 'record';
    protected $primaryKey = 'id';

    public function list()
    {
        return $this->belongsTo(ListTable::class, 'list_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'id');
    }

    public function scopeDibbling( $q )
    {
        return $q->where( 'record_type', RecordTable::DIBBLING );
    }
}
