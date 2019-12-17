<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

use Config;

class AppMessage extends Model
{

    protected $table = 'app_message';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'text',
    ];
}
