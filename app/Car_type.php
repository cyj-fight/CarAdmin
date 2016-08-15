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
    public function getSeries($str){
        $id=(int)$this->getID($str);
        //dd($id);
        $series=Car_type::find($id)->series;
        $arr=explode('_',$series);
        return $arr[0];
    }

    public function getBrand($str){
        $id=(int)$this->getID($str);
        $series=Car_type::find($id)->series;
        $id=(int)$this->getID($series);
        $brand=Car_type::find($id)->brand;
        return $brand;
    }

    public function getType($str){
        $arr=explode('_',$str);
        return $arr[0];
    }
    public function getID($str){
        $arr=explode('_',$str);
        return $arr[1];
    }

    /**
     * 新建车型
     * @param Request $request
     * @return bool
     */
    public static function CreateNewType(Request $request){
        //先查brand
        $brand_id=0;
        $brand=Car_type::where('brand',$request->get('brand'));
        if($brand->get()->isEmpty()){//brand不存在,直接插入新记录
            Car_type::create(array('brand'=>$request->get('brand')));
            if(!Car_type::orderBy('id','asc')->get()->isEmpty())
            {
                $brand_id=Car_type::orderBy('id','asc')->get()->last()->id;
            }
            $series=$request->get('series').'_'.$brand_id;
            Car_type::create(array('series'=>$series));
            $series_id=$brand_id;
            $type=$request->get('type').'_'.$series_id;
            Car_type::create(array_merge(array('type'=>$type),$request->except(['_method','brand','series','type'])));
            return true;
        }else{
            //再查series
            $brand_id=$brand->first()->id;
            $series=Car_type::where('series',$request->get('series').'_'.$brand_id);
            if($series->get()->isEmpty()){//series不存在,添加记录（但不添加brand）
                $series_id=Car_type::orderBy('id','asc')->get()->last()->id+1;
                $series=$request->get('series').'_'.$brand_id;
                Car_type::create(array('series'=>$series));
                $type=$request->get('type').'_'.$series_id;
                Car_type::create(array_merge(array('type'=>$type),$request->except(['_method','brand','series','type'])));
                return true;
            }else{
                $series_id=$series->first()->id;
                $type=Car_type::where('type',$request->get('type').'_'.$series_id);
                if($type->get()->isEmpty()){//type不存在
                    $type=$request->get('type').'_'.$series_id;
                    $temp=array(
                       'type'=>$type,
                    );
                    //dd(array_merge($temp,$request->except(['brand','series','type'])));
                    Car_type::create(array_merge($temp,$request->except(['_method','brand','series','type'])));
                    return true;
                }else{
                    return false;
                }
            }
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
        $type=Car_type::find($id);
        $arr=explode('_',$type->type);
        $series_id=(int)$arr[1];
        $series=Car_type::find($series_id)->series;
        $arr=explode('_',$series);
        $series=$arr[0];
        $brand_id=(int)$arr[1];
        $brand=Car_type::find($brand_id)->brand;
        if($brand!=$request->get('brand')||$series!=$request->get('series')){
            $type->delete();
            self::CreateNewType($request);
        }else{
            $arr=array('type'=>$request->get('type').'_'.$series_id);
            Car_type::where('id',$id)->update(array_merge($arr,$request->except('brand','series','type','user_id','_method','_token')));
        }

    }

    public static function SelectTypes(Request $request=null){
        /*if($request->get('car_type')==null){
            $types=Car_type::all();
        }else
        {
            $types=Car_type::where('car_type',$request->get('car_type'));
        }*/



        /*$types=DB::table('car_types');
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
        $types=$types->get();*/
        //dd($types);

        $types=DB::table('car_types')->get();
        foreach($types as $type){
            $flag=true;
            if($request!=null){
                $arr=explode('_',$type->type);
                $car_type=$arr[0];
                $series_id=(int)$arr[1];
                $series=Car_type::find($series_id);
                $arr=explode('_',$series);
                $car_series=$arr[0];
                $brand_id=(int)$arr[1];
                $brand=Car_type::find($brand_id);

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
        }
        return $types;
    }
}
