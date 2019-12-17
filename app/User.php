<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Config;

class User extends Authenticatable
{
    use Notifiable;
    const SUPER_ADMIN_TYPE = 1;
    const ADMIN_USER = 2;
    const DEFAULT_TYPE = 0;

    const ACTIVE = 1;
    const DELETED = 2;
    const INACTIVE = 0;

    public function isAdmin(){   
        Config::set('lang_prefix',$this->lang['ShortName']) ;
        if($this->type === self::ADMIN_USER){
            return true;
        }
        return $this->type === self::SUPER_ADMIN_TYPE;    
    }

     
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function lang() {
    return $this->belongsTo('App\Language','language','id');
    }
}
