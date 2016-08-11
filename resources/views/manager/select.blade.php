@extends('layout.default')
@section('content')
    <a href="{{url('admin/manager')}}">返回</a>
    <form method="post" action="{{url('admin/manager/select')}}">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        品牌：<input type="text" name="brands" value="null">
        车系：<input type="text" name="car_series" value="null">
        车型：<input type="text" name="car_type" value="null">
        排放标准:<input type="radio" name="emission_standard" value="1">国4
        <input type="radio" name="emission_standard" value="2">国5
        <input type="submit" value="查询">
    </form>
        @if(isset($types))
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
                </tr>
                @foreach($types as $type)
                    <tr>
                        <td>
                            {{$type->brands}}
                        </td>
                        <td>
                            {{$type->car_series}}
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
                </tr>
                    @endforeach
            </table>
    @endif
@endsection