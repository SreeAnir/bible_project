<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;

use Illuminate\Support\Facades\Auth;
class Bibledata extends Model
{

    protected $table = 'bibledata_en';
    protected $primaryKey = 'dataId';
    protected $fillable = [
        'dataId',
        'date',
        'ribbonColor',
        'intercessoryPrayer',
        'dailyQuote',
        'weekDescription',
        'psalter',
        'saintOfTheDay',
        'saintOfTheDayText',
        'significanceOfTheDay',
        'firstReadingReference',
        'firstReadingTitle',
        'firstReadingText',
        'psalmReference',
        'psalmText',
        'psalmResponse',
        'secondReadingReference',
        'secondReadingTitle',
        'secondReadingText',
        'gospel_accumulation',
        'prayer_faith',
        'gospelReference',
        'gospelTitle',
        'gospelText',
        'reflectionText',
        'readText',
        'reflectText',
        'prayText',
        'actText'
    ];
    public function __construct($type = null) {
        // $lang= Config::get('lang_prefix') ;
        $lang='en';
        if(Auth::user()){
        $lang= Auth::user()->lang['ShortName'] ;
        }else{
            if(Config::get('lang_prefix') !=""){
               $lang= Config::get('lang_prefix') ; 
            }
        }
        parent::__construct();
        $this->setTable('bibledata_'.$lang);
    }

}
