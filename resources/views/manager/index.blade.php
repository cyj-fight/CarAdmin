@extends('layout.default')

@section('content')
    欢迎回来{{\Illuminate\Support\Facades\Auth::user()->name}}
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
                            修改
                        </td>
                        <td>
                            删除
                        </td>
                    </tr>
                @endforeach
            @endforeach
        @endforeach
    </table>
@endsection