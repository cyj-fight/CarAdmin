<?php
use \Illuminate\Database\Seeder;
use App\User;
class UserSeeder extends Seeder{

    public function run(){
        DB::table('users')->delete();
        User::create([
            'id'=>1,
            'name'=>'root',
            'email'=>'admin@car.com',
            'password'=>Crypt::encrypt('123456'),
            'sex'=>'1',
            'user_group'=>'1',
        ]);
        User::create([],[],[]);
    }
}