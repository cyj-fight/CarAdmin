@extends('layout.default')

@section('content')
    这是用户界面主页
    {{$user->name}}欢迎回来&nbsp;&nbsp;&nbsp;&nbsp;<a href={{url("auth/logout")}}>退出</a>
    <hr/>
    @if($types->count()>0)
        <a href="{{url('admin/user/create')}}">新建</a>
        <table border="1" style="border-color: #5e5e5e;border-style: inset">
            <tr>
                <td>
                    品牌
                </td>
                <td>
                    车系
                </td>
                <td>
                    车型
                </td>
                <td>
                    座位数
                </td>
                <td>
                    出场日期
                </td>
                <td>
                    排放标准
                </td>
                <td colspan="2">
                    操作
                </td>
            </tr>
            @foreach($user->hasManyTypes as $type)
            <tr>
                <td>
                   {{$type->belongsToSeries->belongsToBrand->brands}}
                </td>
                <td>
                    {{$type->belongsToSeries->car_series}}
                </td>
                <td>
                    {{$type->car_type}}
                </td>
                <td>
                    {{$type->set_num}}
                </td>
                <td>
                    {{$type->made_at}}
                </td>
                <td>
                    {{$type->emission_standard}}
                </td>
                <td>
                    <a href="{{url('admin/user/'.$type->id.'/edit')}}">编辑</a>
                </td>
                <td>
                    删除
                </td>
            </tr>
            @endforeach
        </table>
    @else
        <div>你还没添加任何车型记录，快
        <a href="{{url("admin/user/create")}}">添加</a>吧
        </div>
    @endif
@endsection
