<?php

namespace App\Http\Controllers\Admin\User;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;

class PasswordController extends Controller
{
    use ResetsPasswords;

    public function getEmail(){
        return view('auth.userpassword');
    }

    public function postEmail(Request $request){
        DB::table('password_resets')
            ->insert([['email'=>Auth::user()->email,'token'=>$request->get('_token'),'created_at'=>Carbon::now()]]);
                return redirect('admin/password/reset/'.$request->get('_token'));
    }

    public function getReset($token = null)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }

        return view('auth.userreset')->with('token', $token);
    }

}
