@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="detail">
    <div class="detail_title">
        <h1 class="title">勤怠詳細</h1>
    </div>
    <form class="detail_form" action="">
        <div class="detail_content">
            <div class="detail_name">
                <p>名前</p>
                <p>田中 太郎</p>
            </div>
            <div class="detail_date">
                <p>日付</p>
                <p>2023<span>年</span></p>
                <p>09<span>月</span>13<span>日</span></p>
            </div>
            <div class="detail_attendance">
                <p>出勤・退勤</p>
                <input type="text">
                <p>～</p>
                <input type="text">
            </div>
            <div class="detail_rest">
                <p>休憩</p>
                <p>12:00
                    <span>～</span>
                    13:00
                </p>
            </div>
            <div class="detail_rest-input">
                <p>休憩2
                </p>
                <input type="text">
                <p>～</p>
                <input type="text" name="" id="">
            </div>
            <div class="detail_remarks">
                <p>備考</p>
                <textarea name="" id=""></textarea>
            </div>
        </div>
    </form>
</div>

@endsection