<?php
use \Illuminate\Database\Seeder;
use App\Car_serie;
class SeriesSeeder extends Seeder{

    public function run(){
        DB::table('car_series')->delete();
        $sum=0;
        for($i=1;$i<=5;$i++){
            for($j=1;$j<=3;$j++){
                $sum++;
                Car_serie::create([
                   'id'=>$sum,
                    'car_series'=>'series'.$j.'_brand'.$i,
                    'brands_id'=>$i,
                ]);
            }
        }
    }
}