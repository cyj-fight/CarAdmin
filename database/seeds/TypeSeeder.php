<?php
use \Illuminate\Database\Seeder;
use App\Car_type;
use Illuminate\Http\Request;
class TypeSeeder extends Seeder{

    public function run(){
        //DB::table('brands')->delete();
        //DB::table('car_series')->delete();
        //DB::table('car_types')->delete();
        $msg=array(
            'brand'=>'品牌1',
            'series'=>'车系1',
            'type'=>'车型1',
            'seat_num'=>5,
            'made_at'=>\Carbon\Carbon::now(),
            'emission_standard'=>(int)rand(1,3),
        );
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