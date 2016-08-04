<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car_serie extends Model
{
    public function belongsToBrand(){
        return $this->belongsTo('App\Brand','brand_id');
    }

    public function hasManyTypes(){
        return $this->hasMany('App\Car_type','series_id');
    }
}
