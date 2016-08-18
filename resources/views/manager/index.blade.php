@extends('layout.default')

@section('content')
    <script type="text/javascript">
        $(document).ready(function (){
            $("#brand").change(function(){
                $.post('{{url('admin/manager/select')}}',{
                    _token:$("#token").text(),
                    brand:$("#brand option:selected").text(),
                    series:$("#series option:selected").text(),
                    type:$('#type option:selected').text()
                }, function ($brand) {
                    $('option#'+$brand).selected("selected")
                });
            });
        });
    </script>
    <?php use App\Car_type;?>
    欢迎回来{{\Illuminate\Support\Facades\Auth::user()->name}}
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="{{url('auth/logout')}}">退出</a><hr/>
    <a href="{{url('admin/manager/create')}}">新建</a><br/><br/>

    <form method="post" action="{{url('admin/manager/select')}}">
        <input type="hidden" id="token" name="_token" value="{{csrf_token()}}">
        品牌：<select id="brand">
            <option value=""></option>
            @foreach($brands as $brand)
                <option id="{{$brand->name}}" value="{{$brand->name}}">{{$brand->name}}</option>
                @endforeach
        </select>
        <input type="text" name="brand" value="">
        车系：<select id="series">
            <option value=""></option>
            @foreach($series as $serie)
                <option value="{{$serie->name}}">{{$serie->name}}</option>
            @endforeach
        </select>
        <input type="text" name="series" value="">
        车型：<select id="type">
            <option value=""></option>
            @foreach($types as $type)
                <option value="{{$type->name}}">{{$type->name}}</option>
            @endforeach
        </select>
        <input type="text" name="type" value="">
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
                            {{Car_type::getBrand($type->parent_id)->name}}
                        </td>
                        <td>
                            {{Car_type::getSeries($type->parent_id)->name}}
                        </td>
                        <td>
                            {{$type->name}}
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