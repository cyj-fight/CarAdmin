<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Request;

class Brand extends Model
{
    protected $fillable=['brands'];
    public function hasManySeries(){
        return $this->hasMany('App\Car_serie','brand_id','id');
    }

    public static function CreateNewBrand(Request $request){
        if($brand=Brand::findOrFail($request->get('brands'))){
            return $brand->id;
        }else{
            Brand::create($request->get('brands'));
            $brand=Brand::find($request->get('brands'));
            return $brand->id;
        }
    }
}
