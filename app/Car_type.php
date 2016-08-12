<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Car_type extends Model
{
    protected $table='car_types';
    protected $fillable=['brand','series','type','user_id','seat_num','made_at','emission_standard'];
    public function belongsToSeries(){
        return $this->belongsTo('App\Car_serie','series_id');
    }

    public function belongsToUserType(){
        return $this->belongsTo('App\User_type','id');
    }

    /**
     * 新建车型
     * @param Request $request
     * @return bool
     */
    public static function CreateNewType(Request $request){
        $type=Car_type::where('type',$request->get('type'))
            ->where('brand',$request->get('brand'))
            ->where('series',$request->get('series'))
            ->get();
        if(!$type->isEmpty()){
            return false;
        }else {
            Car_type::create( $request->all());
            return true;
        }
    }

    /**
     * 删除车型
     * @param $id
     * @return bool
     */
    public static function DeleteType($id){
        if($type=Car_type::find($id)){
            $type->delete();
            return true;
        }else{
            return false;
        }
    }

    /**
     * 修改车型信息
     * @param Request $request
     * @param $id
     */
    public static function ChangeType(Request $request,$id){
        //dd(Car_type::where('id',$id)->get());
        Car_type::where('id',$id)->update($request->except('user_id','_method','_token'));
    }

    public static function SelectTypes(Request $request=null){
        /*if($request->get('car_type')==null){
            $types=Car_type::all();
        }else
        {
            $types=Car_type::where('car_type',$request->get('car_type'));
        }*/
        $types=DB::table('car_types');
            //->where('brands.brands',$brands);
            //->where('car_series.car_series','=',$series)
            //->where('car_types.car_type','=',$type)
            //->where('car_types.emission_standard','=',$request->get('emission_standard'))
            //->get();
        if($request!=null){
            if($request->get('brand')!='null')
            {
                $types=$types->where('brand',$request->get('brand'));
            }

            if($request->get('series')!='null'){
                $types=$types->where('series',$request->get('series'));
            }
            if($request->get('type')!='null'){
                $types=$types->where('type',$request->get('type'));
            }
            if($request->get('emission_standard')){
                $standard=$request->get('emission_standard');
                if($standard=='1'){
                    $standard='guo4';
                }
                if($standard=='2'){
                    $standard='guo5';
                }
                $types=$types->where('emission_standard','=',$standard);
                //$types=$types->get();
                //dd($standard);
            }
        }
        $types=$types->get();
        //dd($types);
        return $types;
    }
}
