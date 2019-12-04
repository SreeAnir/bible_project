<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Prayertype;
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
    public function prayertype() {
    return $this->belongsTo('App\Prayertype','prayer','id');
  }
}
