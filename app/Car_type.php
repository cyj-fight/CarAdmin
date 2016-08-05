<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Car_type extends Model
{
    protected $table='car_types';
    protected $fillable=['car_type','series_id','set_num','made_at','emission_standard'];
    public function belongsToSeries(){
        return $this->belongsTo('App\Car_serie','series_id');
    }

    public function belongsToUserType(){
        return $this->belongsTo('App\User_type','id');
    }

    /**
     * 新建车型     ！！！！存在问题：时间不对
     * @param Request $request
     * @return bool
     */
    public static function CreateNewType(Request $request){
        $series_id=Car_serie::CreateNewSeries($request);
        $type=Car_type::where('car_type',$request->get('car_type'))->get();
        if((!$type->isEmpty())&&(Car_type::isSameType($type,$series_id))){
            return false;
        }else {
            $series_id=array('series_id'=>$series_id);
            Car_type::create(array_merge($series_id, $request->except('brands', 'ar_series')));
            $type=Car_type::where('car_type',$request->get('car_type'))->get();
            $user=User::where('name',Auth::user())->get();
            User_type::CreateNewRelation(1,$type->get('0')->id);//1  =>  $user->get('0')->id
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

    public static function ChangeType(Request $request,$id){
        $series_id=Car_serie::ChangeSeries($request);
        $series_id=array('series_id'=>$series_id);
        Car_type::where('id',$id)->update(array_merge($series_id,$request->except('brands','car_type')));
    }

    protected static function isSameType(Collection $collection,$id){
        for($i=0;$i<$collection->count();$i++){
            if($collection->get($i)->type_id==$id){
                return true;
            }
        }
        return false;
    }
}
