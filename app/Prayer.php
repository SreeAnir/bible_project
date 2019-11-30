<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prayer extends Model
{

    protected $table = 'prayers';
    protected $primaryKey = 'idprayers';
    protected $fillable = [
        'idprayers',
        'prayer',
        'title',
        'subtitle',
        'text',
        'orderno'
    ];
}
