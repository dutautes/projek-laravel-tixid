<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use softDeletes;

    protected $fillable = [
        'cinema_id',
        'movie_id',
        'price',
        'hours'
    ];
}
