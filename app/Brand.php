<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class Brand extends Model
{
    protected $table='brands';
    protected $fillable=['brands'];

    public function hasManySeries(){
        return $this->hasMany('App\Car_serie','brands_id','id');
    }

    public static function CreateNewBrand(Request $request){
        $brand=Brand::where('brands',$request->get('brands'))->get();
        if(!$brand->isEmpty()){
            return $brand->get('0')->id;
        }else{
            Brand::create(array('brands'=>$request->get('brands')));
            $brand=Brand::where('brands',$request->get('brands'))->get();
            return $brand->get('0')->id;
        }
    }

    public static function ChangeBrand(Request $request){
        return self::CreateNewBrand($request);
    }

    public static function SelectBrands(Request $request){
        /*if($request->get('brands')==null){
            $brands=Brand::all();
        }else{
            $brands=Brand::where('brands',$request->get('brands'))->get();
        }*/
        $brands=DB::table('brands')->select('brands',$request->get('brands'))->get();
        return $brands;
    }
}
