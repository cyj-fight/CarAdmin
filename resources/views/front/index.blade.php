@extends('layout.default')

@section('content')
<a href="{{url('auth/login')}}" methods="get">登录后台</a>
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
                        {{$type->brand}}
                    </td>
                    <td>
                        {{$type->series}}
                    </td>
                    <td>
                        {{$type->type}}
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
                </tr>
    @endforeach
</table>
@endsection