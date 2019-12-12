<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Prayertype;
class Language extends Model
{

    protected $table = 'language';
    // protected $fillable = [
    //     'idprayers',
    //     'prayer',
    //     'title',
    //     'subtitle',
    //     'text',
    //     'orderno'
    // ];

    public function user() {
    return $this->belongsTo('App\User','language','id');
  }
    
 
}
