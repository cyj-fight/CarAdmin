@extends('layout.default')

@section('content')
    欢迎回来{{\Illuminate\Support\Facades\Auth::user()->name}}
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="{{url('auth/logout')}}">退出</a><hr/>
    <a href="{{url('admin/manager/create')}}">新建</a><br/><br/>

    <form method="post" action="{{url('admin/manager/select')}}">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        品牌：<input type="text" name="brand" value="null">
        车系：<input type="text" name="series" value="null">
        车型：<input type="text" name="type" value="null">
        排放标准:<input type="radio" name="emission_standard" value="1">国4
        <input type="radio" name="emission_standard" value="2">国5
        <input type="submit" value="查询">
    </form>

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
        @foreach($types as $type)
                    <tr>
                        <td>
                            {{$type->getBrand($type->type)}}
                        </td>
                        <td>
                            {{$type->getSeries($type->type)}}
                        </td>
                        <td>
                            {{$type->getType($type->type)}}
                        </td>
                        <td>
                            {{$type->seat_num}}
                        </td>
                        <td>
                            {{$type->made_at}}
                        </td>
                        <td>
                            {{$type->emission_standard}}
                        </td>
                        <td>
                            <a href="{{url('admin/manager/'.$type->id.'/edit')}}"><button>编辑</button></a>
                        </td>
                        <td>
                            <form method="post" action="{{url('admin/manager/'.$type->id)}}">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="submit" name="delete" value="删除">
                            </form>
                        </td>
                    </tr>
        @endforeach
    </table>
@endsection