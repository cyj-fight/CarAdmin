@extends('layout.default')

@section('content')
    <script type="text/javascript">
        $(function () {
            //品牌改变
            $("#brand").change(function(){
                var sign=$("#brand").find('option:selected').val();
                //alert(sign);
                if(sign!=''){
                    var token=$("#token").val();
                    var brand=$("#brand").find("option:selected").val();
                    var series=$("#series").find("option:selected").val();
                    var car_type=$("#type").find("option:selected").val()
                    var emission_standard=$("input[name='emission_standard']:checked").val();
                    if(emission_standard==undefined){
                        emission_standard="";
                    }
                    //alert(emission_standard);
                    var a='{{rand()}}';
                    $.get("{{url('admin/manager/select/brand')}}",{
                                //_token:token,
                                brand:brand,
                                series:series,
                                type:car_type,
                                emission_standard:emission_standard,
                                a:a
                            },function(data){//填充options
                                //var info = JSON.parse(data);
                                var series=data;
                                //var types=data[1];
                                //data.each()

                                $("#type").attr('disabled','disabled');
                                $("#type").empty();
                                $("#type").append("<option value=''>选择车型</option>")
                                //更新下拉列表车系
                                $("#series").removeAttr('disabled');
                                $("#series").empty();
                                $("#series").append("<option value=''>选择车系</option>")
                                for(var i=0;i<series.length;i++){
                                    $("#series option").last().after("<option value='"+series[i]['name']+"'>"+series[i]['name']+"</option>");
                                }

                                //更新车型
                                //$("#type").empty();
                                //$("#type").append("<option value=''>请选择</option>")
                                //for(var i=0;i<types.length;i++){
                                //    $("#type option").last().after("<option valur='"+types[i]['name']+"'>"+types[i]['name']+"</option>");
                                //}

                                //更新搜索结果
                            },
                            'json'
                    );
                }else {
                    $("#type").attr('disabled','disabled');
                    $("#type").empty();
                    $("#type").append("<option value=''>选择车型</option>")

                    $("#series").attr('disabled','disabled');
                    $("#series").empty();
                    $("#series").append("<option value=''>选择车系</option>")
                }

            });

            $("#series").change(function(){
                var sign=$("#series").find("option:selected").val();
                if(sign!=''){
                    var token=$("#token").val();
                    var brand=$("#brand").find("option:selected").val();
                    var series=$("#series").find("option:selected").val();
                    var car_type=$("#type").find("option:selected").val()
                    var emission_standard=$("input[name='emission_standard']:checked").val();
                    if(emission_standard==undefined){
                        emission_standard="";
                    }
                    //alert(emission_standard);
                    var a='{{rand()}}';
                    $.get("{{url('admin/manager/select/series')}}",{
                       // _token:token,
                        brand:brand,
                        series:series,
                        type:car_type,
                        emission_standard:emission_standard,
                        a:a
                    },function(data){
                        //alert(data);
                        var types=data;
                        $("#type").empty();
                        $("#type").append("<option value=''>选择车型</option>")
                        //alert($("#series").find("option:selected").val());

                            $("#type").removeAttr('disabled');
                            for(var i=0;i<types.length;i++)
                            {
                                $("#type option").last().after("<option value='"+types[i]['name']+"'>"+types[i]['name']+"</option>");
                            }

                            },
                            'json'
                    );
                    }else {
                        $("#type").attr('disabled','disabled');
                        $("#type").empty();
                        $("#type").append("<option value=''>选择车型</option>")
                    }
            });

            $("#complex button").click(function()
            {
                var brand=$("#brand").find("option:selected").val();
                var series=$("#series").find("option:selected").val();
                var car_type=$("#type").find("option:selected").val()
                var emission_standard=$("input[name='emission_standard']:checked").val();
                if(emission_standard==undefined)
                {
                    emission_standard="";
                }
                //alert(emission_standard);
                var a='{{rand()}}';
                $.get("{{url('admin/manager/select')}}",
                {
                    brand:brand,
                    series:series,
                    type:car_type,
                    emission_standard:emission_standard,
                    a:a
                },
                        function(data)
                        {
                            var types=data;
                            $("tr[id='type_row']").remove();
                            for(var i=0;i<data.length;i++)
                            {
                                var parent_id=types[i]['parent_id'];
                                $.get("{{url('admin/manager/select/getparents')}}",
                                        "id=parent_id",function(data){
                                            alert(data);
                                            $("tr[id='title_row']").after(
                                                    "<tr id='type_row'>"
                                                    +"<td>{{Car_type::getBrand("+types[i]['parent_id']+")->name}}</td>"
                                                    +"<td>{{Car_type::getSeries("+types[i]['parent_id']+")->name}}</td>"
                                                    +"<td>"
                                                    +types[i]['name']
                                                    +"</td><td>"
                                                    +types[i]['seat_num']
                                                    +"</td><td>"
                                                    +types[i]['made_at']
                                                    +"</td><td>"
                                                    +types[i]['emission_standard']
                                                    +"</td><td>"
                                                    +"<a href='http://www.caradmin.com/admin/manager/"+types[i]['id']+"/edit'><button>编辑</button></a>"
                                                    +"</td><td>"
                                                    +"<form method='post' action='http://www.caradmin.com/admin/manager/"+types[i]['id']+"'>"
                                                    +"<input type='hidden' name='_token' value='{{csrf_token()}}'>"
                                                    +"<input type='hidden' name='_method' value='DELETE'>"
                                                    +"<input type='submit' name='delete' value='删除'>"
                                                    +"</form>"
                                                    +"</td></tr>"
                                            );
                                        });

                            }
                        },
                        'json'
                );

            });

            }
        );
    </script>
    <?php use App\Car_type;?>
    欢迎回来{{\Illuminate\Support\Facades\Auth::user()->name}}
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="{{url('auth/logout')}}">退出</a><hr/>
    <a href="{{url('admin/manager/create')}}">新建</a><br/><br/>

    <div id="complex">
        <h2>筛选：</h2><hr/>
        品牌：<select id="brand" name="brand" style="width: 100px;height: 20px">
            <option value="">选择品牌</option>
            @foreach($brands as $brand)
                <option id="{{$brand->name}}" value="{{$brand->name}}">{{$brand->name}}</option>
                @endforeach
        </select>
        车系：<select id="series" name="series" disabled="disabled" style="width: 100px;height: 20px">
            <option value="">选择车系</option>
        </select>
        车型：<select id="type"  name="type" disabled="disabled" style="width: 100px;height: 20px">
            <option value="">选择车型</option>
        </select>
        排放标准:<input type="radio" name="emission_standard" value="1">国4
        <input type="radio" name="emission_standard" value="2">国5
        <button>查询</button>
    </div>
    <div id="type_only">
        <h2>查找车型:</h2><hr/>
        <input type="text" name="type" value="">
        <input type="submit" value="查询">
    </div>

    <table border="1" style="border-color: #5e5e5e;border-style: inset">
        <tr id="title_row">
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
                    <tr id="type_row">
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