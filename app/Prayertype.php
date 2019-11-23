<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prayertype extends Model
{

    protected $table = 'prayertype';
    protected $fillable = [
        'id',
        'name',
    ];
}
