<?php
use \Illuminate\Database\Seeder;
use App\User_type;
class UserTypeSeeder extends Seeder{

    public function run(){
        DB::table('user_types')->delete();
        for($i=1;$i<=60;$i++){
            User_type::create([
                'id'=>$i,
                'user_id'=>1,
                'type_id'=>$i,
            ]);
        }

    }
}