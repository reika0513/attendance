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
        <div class="date">
            <p class="date_icon">2023年6月1日(木)</p>
        </div>
        <div class="clock">
            <p class="clock_icon">8:00</p>
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
@endsection