<?php

namespace App\Http\Controllers\Admin\Manager;

use App\Brand;
use App\Car_type;
use App\Http\Controllers\Admin\ManageController;
use Illuminate\Database\Eloquent\Collection;
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
        return view('manager.index')->withTypes(Car_type::SelectTypes())->withBrands(Car_type::where('level',1)->get())->withSeries(Car_type::where('level',2)->get());
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
            'brand'=>'required',
            'series'=>'required',
            'type'=>'required',
            'seat_num'=>'required',
            'made_at'=>'required',
            'emission_standard'=>'required',
        ]);

        $flag=Car_type::CreateNewType($request);
        if($flag){
            return Redirect::to('admin/manager')->withTypes(Car_type::all());
        }else{
            return Redirect::back()->withErrors('车型添加失败');
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
            'brand'=>'required',
            'series'=>'required',
            'type'=>'required',
            'seat_num'=>'required',
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

    public function postSelect(Request $request){
        //dd(Car_type::SelectTypes($request));
        $types=Car_type::SelectTypes($request);
        return $types;
        //return view('manager.index')->withBrands(Car_type::where('level',1)->get())->withSeries(Car_type::SelectSeries($request))->withTypes(Car_type::SelectTypes($request));

    }

    public function postSelectBrand(Request $request){
        $series=Car_type::SelectSeries($request);
        //$types=Car_type::SelectTypes($request);
        //dd($types->all());
        //$collection=new Collection();
        //$all=$collection->merge($series)->merge($types);
        //$all=array_merge(array($series),array($types));
        //dd($all);
        return $series;
    }

    public function postSelectSeries(Request $request){
        $types=Car_type::selectTypes($request);
        return $types;
    }

    public function getParents($id){
        $brand=Car_type::getBrand($id);
        $series=Car_type::getSeries($id);
        return array($brand,$series);
    }

}
