@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/stamp.css') }}">
@endsection

@section('content')
<div class="stamp">
    <div class="stamp_form"><!-- or formタグ -->
        <div class="status">
            <p class="status_icon">出勤</p>
        </div>
        <div class="clock">
            <p class="clock_date" id="clock-date"></p>
            <p class="clock_time" id="clock-time"></p>
        </div>
        <div class="stamp_button">
            <!-- if関数?　それぞれ表示を変える -->
            <button class="stamp_button-attendance">出勤</button>
            <button class="stamp_button-break">休憩入</button>
            <button class="stamp_button-break-back">休憩戻</button>
            <button class="stamp_button-leaving">退勤</button>
        </div>
    </div>
</div>

<script type="text/javascript">
    function twoDigit(num) {
      var ret;
      if( num < 10 ) {ret = "0" + num; }
      else {ret = num;} 
      return ret;
    }

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
    function twoDigit(num) {
      var ret;
      if( num < 10 ) {ret = "0" + num; }
      else {ret = num;} 
      return ret;
    }

    function showClock() {
        var nowTime = new Date();
        var nowHour = nowTime.getHours();
        var nowMin  = nowTime.getMinutes();
        var msg = nowHour + ":" + nowMin;
        document.getElementById("clock-time").innerHTML = msg;
    }
    setInterval('showClock()',1000);
</script>
@endsection