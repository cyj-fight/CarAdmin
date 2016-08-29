@extends('layout.default')
@section('content')
    <script type="text/javascript">
        $(function(){
            var count=0;
            for(var i=5;i<100;i++){
                for(var j=1;j<1001;j++){
                    var brand='品牌'+i;
                    var series=brand+'车系'+parseInt(Math.random()*500000+1);
                    var type=series+'车型'+parseInt(Math.random()*500000+1);
                    var seat_num=parseInt(Math.random()*10)%5+5;
                    var made_at=new Date();
                    made_at=made_at.getTime();
                    var emission_standard=parseInt(Math.random()*10)%2+1;
                    $.get('{{url('insert')}}',
                            {
                                brand:brand,
                                series:series,
                                type:type,
                                seat_num:seat_num,
                                made_at:made_at,
                                emission_standard:emission_standard
                            });
                    count++;
                    $("#aaa").append("第"+count+"条记录添加成功,"+brand+"  "+series+"  "+type+"<br/>");
                }
            }

        });
    </script>
<form method="post" action="{{url('/new')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    Brand:<input type="text" name=" brand"><br/>
    Series:<input type="text" name="series"><br/>
    Type:<input type="text" name="type"><br/>
    Set-Num:<input type="number" name="seat_num"><br/>
    Made-At:<input type="date" name="made_at"><br/>
    Emission-Standard:<input type="radio" name="emission_standard" value="1">国4
    <input type="radio" name="emission_standard" value="2">国5<br/>
    <input type="submit" value="Submit">
</form>
    <div id="aaa"></div>
@endsection