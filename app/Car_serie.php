<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Request;

class Car_serie extends Model
{
    protected $fillable=['car_series','brand_id'];
    public function belongsToBrand(){
        return $this->belongsTo('App\Brand','brand_id');
    }

    public function hasManyTypes(){
        return $this->hasMany('App\Car_type','series_id');
    }

    public static function CreateNewSeries(Request $request){
        $brand_id=Brand::CreateNewBrand($request);
        if($series=Car_serie::findOrFail($request->get('car_series'))){
            return $series->id;
        }else{
            Car_serie::create(array_merge($brand_id,$request->get('car_series')));
            $series=Car_serie::find($request->get('car_series'));
            return $series->id;
        }
    }
}
