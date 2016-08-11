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
    protected $fillable=['car_type','series_id','user_id','set_num','made_at','emission_standard'];
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
        $series_id=Car_serie::CreateNewSeries($request);
        $type=Car_type::where('car_type',$request->get('car_type'))->where('series_id',$series_id)->get();
        if(!$type->isEmpty()){
            return false;
        }else {
            $series_id=array('series_id'=>$series_id);
            Car_type::create(array_merge($series_id, $request->except('brands', 'ar_series')));
            $type=Car_type::where('car_type',$request->get('car_type'))->get();
            $user=User::where('name',Auth::user())->get();
            User_type::CreateNewRelation(Auth::user()->id,$type->get('0')->id);//1  =>  $user->get('0')->id
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
        $series_id=Car_serie::ChangeSeries($request);
        $series_id=array('series_id'=>$series_id);
        Car_type::where('id',$id)->update(array_merge($series_id,$request->except('brands','car_series','_method','_token')));
    }

    protected static function isSameType(Collection $collection,$id){
        for($i=0;$i<$collection->count();$i++){
            if($collection->get($i)->type_id==$id){
                return true;
            }
        }
        return false;
    }

    public static function SelectTypes(Request $request=null){
        /*if($request->get('car_type')==null){
            $types=Car_type::all();
        }else
        {
            $types=Car_type::where('car_type',$request->get('car_type'));
        }*/
        $types=DB::table('car_series')
            ->join('brands','car_series.brands_id','=','brands.id')
            ->join('car_types','car_series.id','=','car_types.series_id');
            //->where('brands.brands',$brands);
            //->where('car_series.car_series','=',$series)
            //->where('car_types.car_type','=',$type)
            //->where('car_types.emission_standard','=',$request->get('emission_standard'))
            //->get();
        if($request!=null){
            if($request->get('brands')!='null')
            {
                $types=$types->where('brands.brands',$request->get('brands'));
            }

            if($request->get('car_series')!='null'){
                $types=$types->where('car_series.car_series',$request->get('car_series'));
            }
            if($request->get('car_type')!='null'){
                $types=$types->where('car_types.car_type',$request->get('car_type'));
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
