@extends('layout.default')

@section('content')
    这是用户界面主页
    {{$user->name}}欢迎回来&nbsp;&nbsp;&nbsp;&nbsp;<a href={{url("auth/logout")}}>退出</a>
    @if($typeid->count()>0)
        @foreach($typeid as $type)
            {{$type->car_type}}}<br/>
        @endforeach
    @else
        <div>你还没添加任何车型记录，快
        <a href="admin/user/create">添加</a>吧
        </div>
    @endif
@endsection
