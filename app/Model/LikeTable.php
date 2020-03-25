<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class LikeTable extends Model
{
    protected $table = 'like';
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
