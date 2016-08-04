<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public function hasManySeries(){
        return $this->hasMany('App\Car_serie','brand_id','id');
    }
}
