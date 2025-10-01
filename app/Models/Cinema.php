<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cinema extends Model
{
    // mendaftar softdelets
    use softDeletes;
    // mendaftarkan nama column yang akan diisi, nama2 column selain id dan timestamp
    protected $fillable = [
        'name',
        'location'
    ];

    // fungsi relasi, karna one to many, namanya jamak
    public function schedules()
    {
        // pendefinisian jenis relasi (one to one/one to many)
        return $this->hasMany(Schedule::class);
    }
}
