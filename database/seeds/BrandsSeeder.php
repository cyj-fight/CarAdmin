<?php
use \Illuminate\Database\Seeder;
use App\Brand;
class BrandsSeeder extends Seeder{

    public function run(){
        DB::table('brands')->delete();
        for($i=1;$i<=5;$i++){
            Brand::create([
                'id'=>$i,
                'brands'=>'brand'.$i,
            ]);
        }
    }
}