@extends('layout.default')

@section('content')
    <script type="text/javascript">
        $(function(){
            function GetRequest() {

                var url = decodeURI(location.search); //获取url中"?"符后的字串
                var theRequest = new Object();
                if (url.indexOf("?") != -1) {
                    var str = url.substr(1);
                    strs = str.split("&");
                    for(var i = 0; i < strs.length; i ++) {
                        theRequest[strs[i].split("=")[0]]=(strs[i].split("=")[1]);
                    }
                }
                return theRequest;
            }


            var request=new Object();
            request=GetRequest();
            var brand=request['brand'];
            var series=request['series'];
            var car_type=request['type'];
            var emission_standard=request['emission_standard'];
            $("#brand option[value='"+brand+"']").attr('selected','selected');
            //alert(brand+''+series);
            if(brand!=undefined&&brand!=''){
                $("#type_only input[name='type']").attr('value','');
                $("#series").removeAttr('disabled');
                var a='{{rand()}}';
                $.get("{{url('select/brand')}}",{
                            //_token:token,
                            brand:brand,
                            series:series,
                            type:car_type,
                            emission_standard:emission_standard
                        },function(data){//填充options
                            //var info = JSON.parse(data);
                            var car_series=data;
                            //var types=data[1];
                            //data.each()

                            $("#type").attr('disabled','disabled');
                            $("#type").empty();
                            $("#type").append("<option value=''>选择车型</option>")
                            //更新下拉列表车系
                            $("#series").removeAttr('disabled');
                            $("#series").empty();
                            $("#series").append("<option value=''>选择车系</option>")
                            for(var i=0;i<car_series.length;i++){
                                $("#series option").last().after("<option value='"+car_series[i]['name']+"'>"+car_series[i]['name']+"</option>");
                            }
                            $("#series option[value='"+request['series']+"']").attr('selected','selected');
                        },
                        'json'
                );
            }

            if(series!=undefined&&series!=''){
                var a='{{rand()}}';
                $.get("{{url('select/series')}}",{
                            // _token:token,
                            brand:brand,
                            series:series,
                            //type:car_type,
                            emission_standard:emission_standard
                        },function(data){
                            //alert(data);
                            var types=data;
                            $("#type").removeAttr('disabled');
                            $("#type").empty();
                            $("#type").append("<option value=''>选择车型</option>")
                            //alert($("#series").find("option:selected").val());

                            for(var i=0;i<types.length;i++)
                            {
                                $("#type option").last().after("<option value='"+types[i]['name']+"'>"+types[i]['name']+"</option>");
                            }
                            $("#type option[value='"+request['type']+"']").attr('selected','selected');

                        },
                        'json'
                );
            }

            if(emission_standard==undefined){
                emission_standard=='';
            }
            $("input[value='"+emission_standard+"']").attr('checked','checked');


            $("#brand").change(function(){
                var sign=$("#brand").find('option:selected').val();
                //alert(sign);
                if(sign!=''){
                    var token=$("#token").val();
                    var brand=$("#brand").find("option:selected").val();
                    var series=$("#series").find("option:selected").val();
                    var car_type=$("#type").find("option:selected").val();
                    var emission_standard=$("input[name='emission_standard']:checked").val();
                    if(emission_standard==undefined){
                        emission_standard="";
                    }
                    //alert(emission_standard);
                    var a='{{rand()}}';
                    $.get("{{url('select/brand')}}",{
                                //_token:token,
                                brand:brand,
                                series:series,
                                type:car_type,
                                emission_standard:emission_standard
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
                    var brand=$("#brand").find("option:selected").val();
                    var series=$("#series").find("option:selected").val();
                    //var car_type=$("#type").find("option:selected").val()
                    var emission_standard=$("input[name='emission_standard']:checked").val();
                    if(emission_standard==undefined){
                        emission_standard="";
                    }
                    //alert(emission_standard);
                    var a='{{rand()}}';
                    $.get("{{url('select/series')}}",{
                                // _token:token,
                                brand:brand,
                                series:series,
                                //type:car_type,
                                emission_standard:emission_standard
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

        });
    </script>
    <?php use App\Car_type;?>
<a href="{{url('auth/login')}}" methods="get">登录后台</a>

    <form id="complex" method="get" action="{{url('select')}}">
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
        排放标准:<input type="radio" name="emission_standard" value="" checked="checked">无要求
        <input type="radio" name="emission_standard" value="1">国4
        <input type="radio" name="emission_standard" value="2">国5

        <input type="submit" value="submit">
    </form>
    <form id="type_only" method="get" action="{{url('select')}}">
        <h2>查找车型:</h2><hr/>
        <input type="text" name="type" value="{{request('type')}}">
        <input type="submit" value="查询">
    </form>
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
            </tr>
        @endforeach
    </table>

    <!--分页按钮 -->
    <div style="margin: 20px 20px">
    @if ($types->LastPage() > 1)

        <a href="{{ $types->appends(['brand'=>request('brand'),'series'=>request('series'),'type'=>request('type'),'emission_standard'=>request('emission_standard')])->Url(1) }}" class="item{{ (request('page') == 1) ? ' disabled' : '' }}">
            <button class="icon left arrow">首页</button>
        </a>
        <a href="{{ $types->appends(['brand'=>request('brand'),'series'=>request('series'),'type'=>request('type'),'emission_standard'=>request('emission_standard')])->Url((request('page')==1)?request('page'):((int)request('page')-1))}}" class="item{{ (request('page') == 1) ? ' disabled' : '' }}">
            <button class="icon left arrow">上一页</button>

        </a>
        <a href="{{ $types->appends(['brand'=>request('brand'),'series'=>request('series'),'type'=>request('type'),'emission_standard'=>request('emission_standard')])->Url((request('page')==$types->LastPage())?request('page'):((int)request('page')+1)) }}" class="item{{ (request('page') == 1) ? ' disabled' : '' }}">
            <button class="icon left arrow">下一页</button>

        </a>&nbsp;
        @if($types->LastPage()<=8)
          @for ($i = 1; $i <= $types->LastPage(); $i++)
                <a href="{{ $types->appends(['brand'=>request('brand'),'series'=>request('series'),'type'=>request('type'),'emission_standard'=>request('emission_standard')])->Url($i) }}" class="item{{ (request('page') == $i) ? ' active' : '' }}">
            {{ $i }}
                </a>
            @endfor
        @elseif(($types->LastPage()-request('page'))<7)
            ...&nbsp;
            @for ($i = $types->LastPage()-7; $i <= $types->LastPage(); $i++)
                <a href="{{ $types->appends(['brand'=>request('brand'),'series'=>request('series'),'type'=>request('type'),'emission_standard'=>request('emission_standard')])->Url($i) }}" class="item{{ (request('page') == $i) ? ' active' : '' }}">
                    {{ $i }}
                </a>
            @endfor
        @else
            @for ($i = request('page'); $i <= request('page')+7; $i++)
                <a href="{{ $types->appends(['brand'=>request('brand'),'series'=>request('series'),'type'=>request('type'),'emission_standard'=>request('emission_standard')])->Url($i) }}" class="item{{ (request('page') == $i) ? ' active' : '' }}">
                    {{ $i }}
                </a>
            @endfor
            ...&nbsp;
            @endif
                    <a href="{{ $types->appends(['brand'=>request('brand'),'series'=>request('series'),'type'=>request('type'),'emission_standard'=>request('emission_standard')])->Url($types->LastPage()) }}" class="item{{ (request('page') == $types->LastPage()) ? ' disabled' : '' }}">
            <button class="icon right arrow"> 末页</button>
        </a>

    @endif
    </div>
@endsection