<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LikeModel extends Model
{
    protected $table = 'like';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'list_id'
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'id');
    }
}
