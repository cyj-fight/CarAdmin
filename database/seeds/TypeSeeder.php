<?php
use \Illuminate\Database\Seeder;
use App\Car_type;
class TypeSeeder extends Seeder{

    public function run(){
        //DB::table('brands')->delete();
        //DB::table('car_series')->delete();
        DB::table('car_types')->delete();
        $sum=0;
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
        }
    }
}