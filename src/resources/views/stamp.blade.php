@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/stamp.css') }}">
@endsection

@section('content')
<div class="stamp">
    <div class="stamp_form">
        <div class="status">
            <p class="status_icon" id="status">{{$status}}</p>
        </div>
        <div class="clock">
            <p class="clock_date" id="clock-date"></p>
            <p class="clock_time" id="clock-time"></p>
        </div>
        <div class="stamp_button">
            @if ($status=='出勤中')
            <div class="stamp_button-first">
            <form action="{{ route('timestamp/rest_in') }}" method="POST">
            @csrf
            @method('POST')
            <button type="submit" class="stamp_button-break">休憩入</button>
            </form>

            <form action="{{ route('timestamp/punch_out') }}" method="POST">
            @csrf
            @method('POST')
                <button type="submit" class="stamp_button-leaving">退勤</button>
            </form>
            </div>

            @elseif ($status=='休憩中')
            <div class="stamp_button-second">
            <form action="{{ route('timestamp/rest_out') }}" method="POST">
            @csrf
            @method('POST')
            <button type="submit" class="stamp_button-break-back">休憩戻</button>
            </form>
            </div>

            @else
            <div class="stamp_button-third">
            <form action="{{ route('timestamp/punch_in') }}" method="POST">
            @csrf
            @method('POST')
                <button type="submit" class="stamp_button-attendance" name="punch_in">出勤</button>
            </form>
            @endif
        </div>

        @if (session('message'))
            <div class="message">
                <div class="message_content">
                    {{ session('message') }}
                </div>
            </div>
        @endif
    </div>
</div>

<script type="text/javascript">

    function showDate() {
        var nowDate = new Date();
        var Year = nowDate.getFullYear();
        var month  = nowDate.getMonth()+1;
        var week = nowDate.getDay();
        var day = nowDate.getDate();
        var week_ja= new Array("日","月","火","水","木","金","土");
        var week_ja=week_ja[week];
        var msg = Year + "年" + month + "月" + day + "日(" + week_ja +")";
        document.getElementById("clock-date").innerHTML = msg;
    }
    setInterval('showDate()',1000);
</script>

<script type="text/javascript">
    function showClock() {
        var nowTime = new Date();
        var nowHour = nowTime.getHours();
        var nowMin  = nowTime.getMinutes();

        if(nowHour < 10) { nowHour = "0" + nowHour; }
        if(nowMin < 10) { nowMin = "0" + nowMin; }

        var msg = nowHour + ":" + nowMin;
        document.getElementById("clock-time").innerHTML = msg;
    }
    setInterval('showClock()',1000);
</script>

<script type="text/javascript">
    if($oldTimestamp == $newTimestampDay){
        console.log('出勤中');
    }
    document.getElementById("status").innerHTML = msg;
</script>
@endsection