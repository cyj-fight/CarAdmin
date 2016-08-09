@extends('layout.default')

@section('content')
    @if(count($errors)>0)
        <div class="alert alert-danger">
            @foreach($errors as $error)
                {{$error}}
                @endforeach
        </div>
        @endif
    <form method="post" action="{{url('auth/register')}}">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="user_group" value="2">
        用户名：<br/><input type="text" name="name"><br/>
        性别：<br/><input type="radio" name="sex" value="1">男
        <input type="radio" name="sex" value="2">女<br/>
        邮箱：<br/><input type="text" name="email"><br/>
        密码：<br/><input type="password" name="password"><br/>
        确认密码：<br/><input type="password" name="password_confirmation"><br/>
        <input type="submit" value="注册">
    </form>
    @endsection