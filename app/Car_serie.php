<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Request;

class Car_serie extends Model
{
    protected $table='car_series';
    protected $fillable=['car_series','brands_id'];
    public function belongsToBrand(){
        return $this->belongsTo('App\Brand','brands_id');
    }

    public function hasManyTypes(){
        return $this->hasMany('App\Car_type','series_id','id');
    }

    public static function CreateNewSeries(Request $request){
        $brand_id=Brand::CreateNewBrand($request);
        $series=Car_serie::where('car_series',$request->get('car_series'))->where('brands_id',$brand_id)->get();
        if(!$series->isEmpty()){
            return $series->get('0')->id;
        }else{
            $brand_id=array('brands_id'=>$brand_id);
            $car_series=array('car_series'=>$request->get('car_series'));
            Car_serie::create(array_merge($brand_id,$car_series));
            $series=Car_serie::where('car_series',$request->get('car_series'))->get();
            return $series->get('0')->id;
        }
    }

    public static function ChangeSeries(Request $request){
        $brand_id=Brand::ChangeBrand($request);
        $series=Car_serie::where('car_series',$request->get('car_series'))->where('brands_id',$brand_id)->get();
        if((!$series->isEmpty())){
                return $series->get('0')->id;
        }else{
            $brand_id=array('brands_id'=>$brand_id);
            $car_series=array('car_series'=>$request->get('car_series'));
            Car_serie::create(array_merge($brand_id,$car_series));
            $series=Car_serie::where('car_series',$request->get('car_series'))
                ->where('brands_id',$brand_id)->get();
            return $series->get('0')->id;
        }
    }

    protected static function isSameSeries(Collection $collection,$id){
        for($i=0;$i<$collection->count();$i++){
            if($collection->get($i)->series_id==$id){
                return true;
            }
        }
        return false;
    }

    public static function SelectSeries(Request $request){
        $brands=Brand::SelectBrands($request);
        if($brands->count()>1){
            //$series=Car_serie::all();
            if($request->get('car_series')==null){
                $series=Car_serie::all();
            }else{
                $series=Car_serie::where('car_series',$request->get('car_series'))->get();
            }
        }else{
            //$series=Car_serie::where('brand_id',$brands->get('0')->id);
            if($request->get('car_series')==null){
                $series=Car_serie::where('brand_id',$brands->get('0')->id)->get();
            }else{
                $series=Car_serie::where('brand_id',$brands->get('0')->id)->where('car_series',$request->get('car_series'))->get();
            }
        }
        return $series;
    }
}
