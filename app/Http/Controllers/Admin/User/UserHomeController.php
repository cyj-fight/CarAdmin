<?php

namespace App\Http\Controllers\Admin\User;

use App\Car_type;
use App\Http\Controllers\Admin\UserController;
use App\User_type;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Brand;

class UserHomeController extends UserController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(User_type::where('user_id',Auth::user()->id)->get());
        return view('user.index')->withUser(Auth::user())->withTypes(User_type::where('user_id',Auth::user()->id)->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create')->withUser(Auth::user());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
           'brands'=>'required',
            'car_series'=>'required',
            'car_type'=>'required',
            'set_num'=>'required',
            'made_at'=>'required',
            'emission_standard'=>'required',
        ]);

        $flag=Car_type::CreateNewType($request);
        if($flag){
            return Redirect::to('admin/user')->withBrands(Brand::all());
        }else{
            return Redirect::back()->withInput->withErrors('车型添加失败');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('user.edit')->withType(Car_type::find($id))->withUser(Auth::user());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'brands'=>'required',
            'car_series'=>'required',
            'car_type'=>'required',
            'set_num'=>'required',
            'made_at'=>'required',
            'emission_standard'=>'required',
        ]);
        Car_type::ChangeType($request,$id);

        return Redirect::to('admin/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type=Car_type::findOrFail($id);
        $record=User_type::where('type_id',$id)->first();
        $record->delete();
        $type->delete();
        return Redirect::back();
    }
}
