<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_type extends Model
{
    protected $table='user_types';
    protected $fillable=['user_id','type_id'];
    public function belongsToUsers(){
        return $this->belongsTo('App\User','user_id');
    }

    public function hasOneType(){
        return $this->hasOne('App\Car_type','id','type_id');
    }

    public static function CreateNewRelation($user_id,$type_id){
        $arr=array(
            'user_id'=>$user_id,
            'type_id'=>$type_id
        );
        User_type::create($arr);
    }
}
