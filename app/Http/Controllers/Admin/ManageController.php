<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class ManageController extends Controller
{
    public function __construct()
    {
        $this->isUserGroup1();
    }

    protected function isUserGroup1(){
        if(Gate::denies('isUserGroup1')){
            echo '你没有权限';
            die;
        }
    }
}
