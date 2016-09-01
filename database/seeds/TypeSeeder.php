<?php
use \Illuminate\Database\Seeder;
use App\Car_type;
use Illuminate\Http\Request;
class TypeSeeder extends Seeder{

    public function run(){
        //DB::table('brands')->delete();
        //DB::table('car_series')->delete();
        //DB::table('car_types')->delete();
        /*for($i=100;$i<200;$i++){
            for($j=1;$j<100001;$j++){
                $request=new Request();
                $request['brand']='品牌'.$i;
                $request['series']='品牌'.$i.'车系'.(int)rand(1,10000);
                $request['type']=$request->get('series').'车型'.(int)rand(1,1000);
                $request['made_at']=\Carbon\Carbon::now();
                $request['emission_standard']=(int)rand(1,3)%2+1;
                Car_type::CreateNewType($request);
            }
        }*/


      /* for($i=1;$i<=10;$i++){
            Car_type::create([
                'name'=>'品牌15车系'.$i,
                'level'=>2,
                'parent_id'=>16527,
            ]);
        }
*/
        for($j=1;$j<=10;$j++){
            $parent_id= 993498+$j;
            for($i=1;$i<=10001;$i++){
            Car_type::create([
                'name'=>'品牌15车系'.$j.'车型'.$i,
                'level'=>3,
                'parent_id'=>$parent_id,
                'seat_num'=>(int)rand(1,5)+5,
                'made_at'=>\Carbon\Carbon::now(),
                'emission_standard'=>(int)rand(1,3)%2+1,
            ]);

        }}
        /*
        for($i=1;$i<=10001;$i++){
            Car_type::create([
                'name'=>'品牌12车系2车型'.$i,
                'level'=>3,
                'parent_id'=>643947,
                'seat_num'=>(int)rand(1,5)+5,
                'made_at'=>\Carbon\Carbon::now(),
                'emission_standard'=>(int)rand(1,3)%2+1,
            ]);

        }
        for($i=1;$i<=10001;$i++){
            Car_type::create([
                'name'=>'品牌12车系3车型'.$i,
                'level'=>3,
                'parent_id'=>643948,
                'seat_num'=>(int)rand(1,5)+5,
                'made_at'=>\Carbon\Carbon::now(),
                'emission_standard'=>(int)rand(1,3)%2+1,
            ]);

        }

        for($i=518;$i<=10001;$i++){
            Car_type::create([
                'name'=>'品牌12车系4车型'.$i,
                'level'=>3,
                'parent_id'=>643949,
                'seat_num'=>(int)rand(1,5)+5,
                'made_at'=>\Carbon\Carbon::now(),
                'emission_standard'=>(int)rand(1,3)%2+1,
            ]);

        }
            for($i=1;$i<=10001;$i++){
                Car_type::create([
                    'name'=>'品牌12车系5车型'.$i,
                    'level'=>3,
                    'parent_id'=>(693438+$j),
                    'seat_num'=>(int)rand(1,5)+5,
                    'made_at'=>\Carbon\Carbon::now(),
                    'emission_standard'=>(int)rand(1,3)%2+1,
                ]);

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