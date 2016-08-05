<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Car_type extends Model
{
    protected $fillable=['car_type','series_id','set_num','made_at','emission_standard'];
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
        if($type=Car_type::findOrFail($request->get('car_type'))){
            return false;
        }else {
            $series_id=array('series_id'=>$series_id);
            Car_type::create(array_merge($series_id, $request->except('brands', 'ar_series')));
            $type=Car_type::find($request->get('car_type'));
            $user=User::find(Auth::user());
            User_type::CreateNewRelation($type->id,$user->id);
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
        Car_type::where('id',$id)->update(array_merge($series_id,$request->except('brands','car_series')));
    }
}
