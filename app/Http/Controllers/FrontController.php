<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Car_serie;
use App\Car_type;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('front.index')->withBrands(Car_type::where('level',1)->get())->withTypes(Car_type::where('level',3)->get());
    }

    public function postSelect(Request $request){
        //dd(Car_type::SelectTypes($request));
        $types=Car_type::SelectTypes($request);
        //return $types;
        return view('front.index')->withBrands(Car_type::where('level',1)->get())->withSeries(Car_type::SelectSeries($request))->withTypes(Car_type::SelectTypes($request));

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

    public function getParents(Request $request){
        $id=(int)$request->get('id');
        $brand=Car_type::getBrand($id);
        $series=Car_type::getSeries($id);
        return array($brand,$series);
    }

}
