<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car_type extends Model
{
    public function belongsToSeries(){
        return $this->belongsTo('App\Car_serie','series_id');
    }

    public function belongsToUserType(){
        return $this->belongsTo('App\User_type','id');
    }
}
