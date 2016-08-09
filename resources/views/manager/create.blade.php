@extends('layout.default')
@section('content')
    <form method="post" action="{{url('admin/manager')}}">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="user_id" value="{{$user->id}}">
        Brand:<input type="text" name=" brands"><br/>
        Series:<input type="text" name="car_series"><br/>
        Type:<input type="text" name="car_type"><br/>
        Set-Num:<input type="number" name="set_num"><br/>
        Made-At:<input type="date" name="made_at"><br/>
        Emission-Standard:<input type="radio" name="emission_standard" value="1">国4
        <input type="radio" name="emission_standard" value="2">国5<br/>
        <input type="submit" value="Submit">
    </form>
@endsection