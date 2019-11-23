<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bibledata extends Model
{

    protected $table = 'bibledata';
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

}
