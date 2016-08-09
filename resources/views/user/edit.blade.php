@extends('layout.default')
@section('content')
    <form method="post" action="{{url('admin/user/'.$type->id)}}">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="user_id" value="{{$user->id}}">
        Brand:<input type="text" name=" brands" value="{{$type->belongsToSeries->belongsToBrand->brands}}"><br/>
        Series:<input type="text" name="car_series" value="{{$type->belongsToSeries->car_series}}"><br/>
        Type:<input type="text" name="car_type" value="{{$type->car_type}}"><br/>
        Set-Num:<input type="number" name="set_num" value="{{$type->set_num}}"><br/>
        Made-At:<input type="date" name="made_at" value="{{date("Y-m-d",strtotime($type->made_at))}}"><br/>
        Emission-Standard:
        @if($type->emission_standard=='guo4')
        <input type="radio" name="emission_standard" value="1" checked="checked">国4
        <input type="radio" name="emission_standard" value="2">国5<br/>
        @elseif($type->emission_standard=='guo5')
            <input type="radio" name="emission_standard" value="1">国4
            <input type="radio" name="emission_standard" value="2" checked="checked">国5<br/>
        @endif
        <input type="submit" value="Submit">
    </form>
@endsection