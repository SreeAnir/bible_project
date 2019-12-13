<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

use App\Prayertype;
use Config;

class Prayer extends Model
{

    protected $table = 'prayers_en';
    protected $primaryKey = 'idprayers';
    protected $fillable = [
        'idprayers',
        'prayer',
        'title',
        'subtitle',
        'text',
        'orderno'
    ];
    public function __construct($type = null) {
        $lang=  Auth::user()->lang['ShortName'] ;
        parent::__construct();
        if($lang!='en'){
        $this->setTable('prayers_'.$lang);
        }
    }
    public function prayertype() {
    return $this->belongsTo('App\Prayertype','prayer','id');
  }
}
