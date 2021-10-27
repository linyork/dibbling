<?php

namespace App\Model;

use App\Model\UserModel;
use Illuminate\Database\Eloquent\Model;

class LikeTable extends Model
{
    protected $table = 'like';
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'id');
    }
}
