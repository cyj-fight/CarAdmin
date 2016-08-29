<?php
use \Illuminate\Database\Seeder;
use App\Car_type;
use Illuminate\Http\Request;
class TypeSeeder extends Seeder{

    public function run(){
        //DB::table('brands')->delete();
        //DB::table('car_series')->delete();
        //DB::table('car_types')->delete();
        for($i=5;$i<100;$i++){
            for($j=1;$j<100001;$j++){
                $request=new Request();
                $request['brand']='品牌'.$i;
                $request['series']='品牌'.$i.'车系'.(int)rand(1,10000);
                $request['type']=$request->get('series').'车型'.(int)rand(1,1000);
                $request['made_at']=\Carbon\Carbon::now();
                $request['emission_standard']=(int)rand(1,3)%2+1;
                Car_type::CreateNewType($request);
            }
        }


        /*$sum=0;
        for($i=1;$i<=5;$i++){
            for($j=1;$j<=3;$j++){
                for($k=1;$k<5;$k++){
                    $sum++;
                    $num=$k+4;
                    $std=$k%2+1;
                    Car_type::create([
                        'id'=>$sum,
                        'brand'=>'brand'.$i,
                        'series'=>'series'.$j,
                        'type'=>'type'.$k.'_series'.$j.'_brand'.$i,
                        'user_id'=>1,
                        'seat_num'=>$num,
                        'made_at'=>\Carbon\Carbon::now(),
                        'emission_standard'=>$std,
                    ]);
                }
            }
        }*/
    }
}