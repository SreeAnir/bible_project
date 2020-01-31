<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

use Config;

class DeviceToken extends Model
{

    protected $table = 'device_token';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id','unique_id' ,'fcm_token','device_type','created_at' ,'updated_at'
    ];
    
}
