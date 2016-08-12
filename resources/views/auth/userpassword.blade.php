@extends('layout.default')
@section('content')
    <form method="POST" action="{{url('admin/password/email')}}">
        {!! csrf_field() !!}
        <div>
            <button type="submit">
                点击此处重置密码
            </button>
        </div>
    </form>
@endsection