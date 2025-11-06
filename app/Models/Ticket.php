<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use softDeletes;

    protected $fillable = [
        'user_id',
        'schedule_id',
        'promo_id',
        'rows_of_seats',
        'quantity',
        'total_price',
        'activated',
        'date',
        'hours'
    ];

    protected function casts(): array
    {
        return ['rows_of_seats' => 'array'];
    }


    // relasi user id


    // relasi schedule id


    // relasi promo id
}
