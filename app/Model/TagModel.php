<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagModel extends Model
{
    protected $table = 'tag';
    protected $primaryKey = 'id';

    protected $fillable = [
        'list_id',
        'tag'
    ];

    public $timestamps = false;
}
