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
    protected $fillable=['name','parent_id','level','user_id','seat_num','made_at','emission_standard'];
    public static function getSeries($id){
        $series=Car_type::where('level',2)->find($id);
        //dd($id);
        return $series;
    }

    public static function getBrand($id){
        $series=Car_type::getSeries($id);
        $brand=Car_type::where('level',1)->find($series->parent_id);
        return $brand;
    }

    /**
     * 新建车型
     * @param Request $request
     * @return bool
     */
    public static function CreateNewType(Request $request){
        //先查brand
        $brand=Car_type::where('level','=',1)->where('name',$request->get('brand'));
        if($brand->get()->isEmpty()){//brand不存在,直接插入新记录
            //新建brand
            Car_type::create(array(
                'name'=>$request->get('brand'),
                'parent_id'=>0,
                'level'=>1,
            ));
            $brand_id=Car_type::where('level','=',1)->where('name',$request->get('brand'))->first()->id;
            //新建series
            Car_type::create(array(
                'name'=>$request->get('series'),
                'parent_id'=>$brand_id,
                'level'=>2,
            ));
            $series_id=++$brand_id;
            //新建type
            Car_type::create(array_merge(array(
                'name'=>$request->get('type'),
                'parent_id'=>$series_id,
                'level'=>3,
            ),$request->except(['_method','brand','series','type'])));
            return true;
        }else{
            //再查series
            $brand_id=$brand->first()->id;
            $series=Car_type::where('level','=',2)->where('parent_id','=',$brand_id)->where('name',$request->get('series'));
            if($series->get()->isEmpty()){//series不存在,添加记录（但不添加brand）
                //新建series
                Car_type::create(array(
                    'name'=>$request->get('series'),
                    'parent_id'=>$brand_id,
                    'level'=>2,
                ));
                $series_id=Car_type::orderBy('id','asc')->get()->last()->id;
                //新建type
                Car_type::create(array_merge(array(
                    'name'=>$request->get('type'),
                    'parent_id'=>$series_id,
                    'level'=>3,
                    ),$request->except(['_method','brand','series','type'])));
                return true;
            }else{
                $series_id=$series->first()->id;
                $type=Car_type::where('level','=',3)->where('parent_id','=',$series_id)->where('name',$request->get('type'));
                if($type->get()->isEmpty()){//type不存在
                    //dd(array_merge($temp,$request->except(['brand','series','type'])));
                    Car_type::create(array_merge(array(
                        'name'=>$request->get('type'),
                        'parent_id'=>$series_id,
                        'level'=>3,
                    ),$request->except(['_method','brand','series','type'])));
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
        $series_id=$type->parent_id;
        $series=Car_type::find($series_id);
        $brand_id=$series->parent_id;
        $brand=Car_type::find($brand_id);
        if($brand->name!=$request->get('brand')||$series->name!=$request->get('series')){
            $type->delete();
            self::CreateNewType($request);
        }else{
            $arr=array('name'=>$request->get('type'));
            Car_type::where('id',$id)->update(array_merge($arr,$request->except('brand','series','type','user_id','_method','_token')));
        }

    }

    public static function SelectTypes(Request $request=null){
        //dd($request);
        /*if($request->get('car_type')==null){
            $types=Car_type::all();
        }else
        {
            $types=Car_type::where('car_type',$request->get('car_type'));
        }*/



        /*$types=Car_type::where('type','<>','');
            //->where('brands.brands',$brands);
            //->where('car_series.car_series','=',$series)
            //->where('car_types.car_type','=',$type)
            //->where('car_types.emission_standard','=',$request->get('emission_standard'))
            //->get();
        if($request!=null){
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

            if($request->get('type')!='null'){
                $types=$types->where('type','like',$request->get('type').'%');
            }

            if($request->get('series')!='null'){
                $series=Car_type::where('series','like',$request->get('series').'%')->get();
                if(!$series->isEmpty()){
                    $temp=DB::table('car_types')->where('type','<>','');
                    foreach($series as $car_series){
                        $temp=$temp->orwhere('type','like','%'.$car_series->id);
                    }
                    $types=$types->where($temp);
                }else{
                    $types=$types->where('user_id','<',0);
                }
            }

            if($request->get('brand')!='null')
            {
                $brand=Car_type::where('brand',$request->get('brand'))->first();
                if(count((array)$brand)<1){

                    $types=$types->where('user_id','<',0);
                }else{
                    $series=Car_type::where('series','like','%'.$brand->id)->get();
                    //dd($series);
                    if(!$series->isEmpty()){
                        //$temp=DB::table('car_types')->where('type','<>','');
                        foreach($series as $car_series){
                            //$temp=$temp->orwhere('type','like','%'.$car_series->id);
                            $types=$types->orwhere('type','like','%'.$car_series->id);
                        }
                    }else{
                        $types=$types->where('user_id','<',0);
                    }
                }
            }
        }

        $types=$types->get();*/
        //dd($types);
        $types=DB::table('car_types')->where('level','=','3')->get();
        $result=collect();
        foreach($types as $type){
            $flag=true;
            if($request!=null){
                $car_type=$type->name;
                $series_id=$type->parent_id;
                $series=Car_type::where('level',2)->find($series_id);
                $car_series=$series->name;
                $brand_id=$series->parent_id;
                $brand=Car_type::where('level',1)->find($brand_id);
                //var_dump($brand);
                $emission_standard=$type->emission_standard;
                if($request->get('brand')!=''&&$brand->name!=$request->get('brand'))
                {
                        $flag=false;
                }

                if($request->get('series')!=''&&$car_series!=$request->get('series')){
                    $flag=false;
                }
                if($request->get('type')!=''&&$car_type!=$request->get('type')){
                    $flag=false;
                }
                if($request->get('emission_standard')){
                    $standard=$request->get('emission_standard');
                    if($standard=='1'){
                        $standard='guo4';
                    }
                    if($standard=='2'){
                        $standard='guo5';
                    }
                    if($emission_standard!=$standard){
                        $flag=false;
                    }
                    //$types=$types->where('emission_standard','=',$standard);
                    //$types=$types->get();
                    //dd($standard);
                }
            }
            //var_dump($flag);
            if($flag==true){
                //var_dump($type);
                //echo '<br/>';
                $result->prepend($type);
            }
        }
        return $result;
    }

    public static function SelectSeries(Request $request){
        if($request->get('brand')!=''){
            $brand=Car_type::where('level',1)->where('name',$request->get('brand'))->get();
            $series=Car_type::where('level',2)->where('parent_id',$brand->id)->get();
            return $series;
        }
    }
}