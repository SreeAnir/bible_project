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
        'weekDescription',
        'psalter',
        'saintOfTheDay',
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
        $lang=  Auth::user()->lang['ShortName'] ;
        parent::__construct();
        $this->setTable('bibledata_'.$lang);
    }

}
