<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Config;

class solemnityDates extends Authenticatable
{
    // use Notifiable;
    // const SUPER_ADMIN_TYPE = 1;
    // const ADMIN_USER = 2;
    // const DEFAULT_TYPE = 0;

    // const ACTIVE = 1;
    // const DELETED = 2;
    // const INACTIVE = 0;
 

         protected $table = 'solemnity_dates';

}
