<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListTable extends Model
{
    use SoftDeletes;

    protected $table = 'list';
    protected $primaryKey = 'id';
}
