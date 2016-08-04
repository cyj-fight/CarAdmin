<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_type extends Model
{
    public function belongsToUsers(){
        return $this->belongsTo('App\User','user_id');
    }

    public function hasOneType(){
        return $this->hasMany('App\Car_type','id','type_id');
    }
}
