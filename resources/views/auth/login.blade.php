@extends('layout.default')

@section('content')
    @if(count($errors)>0)
            <div class="alert alert-danger">
                @foreach($errors as $error)
                    {{$error}}
                @endforeach
            </div>
    @endif
<form method="post" action="{{url('auth/login')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    用户名:<input type="text" name="email"><br/>
    密码:<input type="password" name="password"><br/>
    <input type="submit" value="登录">
    <a href="{{url('auth/register')}}" methods="get">注册</a>
</form>
@endsection