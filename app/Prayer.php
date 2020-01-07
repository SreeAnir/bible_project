<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

use App\Prayertype;
use Config;

class Prayer extends Model
{
    const ACTIVE = 1;
    const DELETED = 2;
    const INACTIVE = 0;
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
        $lang='en';
        if(Auth::user()){
        $lang= Auth::user()->lang['ShortName'] ;
        }
        else{
          
            if(Config::get('lang_prefix') !=""){
               $lang= Config::get('lang_prefix') ; 
                 //test 
                  //   echo Config::get('lang_prefix');
                   //  die() ;
               $this->setTable('prayers_'.$lang);
            }
        }
        $this->setTable('prayers_'.$lang);
        parent::__construct();
        // if($lang!='en'){
        
        // }
    }
    public function prayertype() {
    return $this->belongsTo('App\Prayertype','prayer','id');
  }
}
