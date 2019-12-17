<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

use Config;

class Patron extends Model
{

    protected $table = 'patron';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'patron_name',
        'patron_image',
        'patron_text',
        'patron_date',
    ];
}
