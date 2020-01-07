<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

use Config;

class Splash extends Model
{

    protected $table = 'splash';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'messsage',
        'language',
        'image',
    ];
}
