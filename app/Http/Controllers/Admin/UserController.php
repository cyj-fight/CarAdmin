<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function __construct()
    {
        $this->isUserGroup2();
    }

    protected function isUserGroup2(){
        if(Gate::denies('isUserGroup2')){
           echo '你没有权限';
            // return Redirect::to('admin/');
            abort(403);
        }
    }
}
