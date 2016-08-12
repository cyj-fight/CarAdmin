@extends('layout.default')
@section('content')
<form method="post" action="{{url('admin/user')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="user_id" value="{{$user->id}}">
    Brand:<input type="text" name=" brand"><br/>
    Series:<input type="text" name="series"><br/>
    Type:<input type="text" name="type"><br/>
    Set-Num:<input type="number" name="seat_num"><br/>
    Made-At:<input type="date" name="made_at"><br/>
    Emission-Standard:<input type="radio" name="emission_standard" value="1">国4
    <input type="radio" name="emission_standard" value="2">国5<br/>
    <input type="submit" value="Submit">
</form>
@endsection