<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Prayer;
class Prayertype extends Model
{

    protected $table = 'prayertype';
    protected $fillable = [
        'id',
        'name',
    ];
   public function prayer() {
    return $this->hasOne('App\Prayer','id','prayer');
  }
    
}
