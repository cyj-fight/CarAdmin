@extends('layout.default')

@section('content')
    欢迎回来{{\Illuminate\Support\Facades\Auth::user()->name}}
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="{{url('auth/logout')}}">退出</a><hr/>
    <a href="{{url('admin/manager/create')}}">新建</a><br/><br/>
    <div>
        <form method="post" action="{{url('admin/manager/select')}}">
            <select name="brands">
                @foreach($brands as $brand)
                    <option value="{{$brand->brands}}">{{$brand->brands}}</option>
                @endforeach
            </select>
        </form>
    </div>
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
        @foreach($brands as $brand)
            @foreach($brand->hasManySeries as $series)
                @foreach($series->hasManyTypes as $type)
                    <tr>
                        <td>
                            {{$brand->brands}}
                        </td>
                        <td>
                            {{$series->car_series}}
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
            @endforeach
        @endforeach
    </table>
@endsection