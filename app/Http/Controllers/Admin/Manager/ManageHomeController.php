<?php

namespace App\Http\Controllers\Admin\Manager;

use App\Brand;
use App\Car_type;
use App\Http\Controllers\Admin\ManageController;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ManageHomeController extends ManageController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(Car_type::SelectTypes());
        return view('manager.index')->withTypes(Car_type::SelectTypes());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manager.create')->withUser(Auth::user());
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
            return Redirect::to('admin/manager')->withBrands(Brand::all());
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
        return view('manager.edit')->withType(Car_type::find($id))->withUser(Auth::user());
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

        return Redirect::to('admin/manager');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Car_type::DeleteType($id)){
            return Redirect::back();
        }
        return Redirect::back()->withErroes('删除失败');
    }

    public function getSelect(){
        //dd(Car_type::SelectTypes($request));
        return view('manager.select');

    }

    public function postSelect(Request $request){
        //dd(Car_type::SelectTypes($request));
        return view('manager.select')->withTypes(Car_type::SelectTypes($request));

    }

}
