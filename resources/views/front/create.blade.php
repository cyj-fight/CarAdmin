<html>
<head>
    <meta charset="utf-8" content="text/html">
    <title>
        test
    </title>
</head>
<body>
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
</body>
</html>