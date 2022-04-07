<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PlayingModel extends Model
{
    protected $table = 'playing';
    protected $primaryKey = 'id';

    protected $fillable = [
        'video_id'
    ];
}
