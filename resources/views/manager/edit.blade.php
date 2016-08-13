@extends('layout.default')
@section('content')
    <form method="post" action="{{url('admin/manager/'.$type->id)}}">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="user_id" value="{{$user->id}}">
        Brand:<input type="text" name=" brand" value="{{$type->getBrand($type->type)}}"><br/>
        Series:<input type="text" name="series" value="{{$type->getSeries($type->series)}}"><br/>
        Type:<input type="text" name="type" value="{{$type->getType($type->type)}}"><br/>
        Set-Num:<input type="number" name="seat_num" value="{{$type->seat_num}}"><br/>
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