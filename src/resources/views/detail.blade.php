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
                <input type="text">
            </div>
            <div class="detail_date">
                <p>日付</p>
                <input type="text"><span>年</span>
                <input type="text">
            </div>
            <div class="detail_attendance">
                <p>出勤・退勤</p>
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
                <input type="textarea">
            </div>
        </div>
    </form>
</div>

@endsection