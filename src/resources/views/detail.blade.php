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
                <p class="detail_content-title">名前</p>
                <p class="detail_name-text">田中 太郎</p>
            </div>

            <div class="detail_date">
                <p class="detail_content-title">日付</p>
                <p class="detail_date-text">2023<span>年</span></p>
                <p class="detail_date-text">09<span>月</span>13<span>日</span></p>
            </div>

            <div class="detail_attendance">
                <p class="detail_content-title">出勤・退勤</p>
                <input type="time" class="detail_attendance-text" value="{{ $work && $work->work_in ? $work->work_in->format('H:i') : '' }}">
                <p class="detail_attendance-text">～</p>
                <input type="time" class="detail_attendance-text" value="{{ $work && $work->work_out ? $work->work_out->format('H:i') : '' }}">
            </div>

            <div class="detail_rest">
                <div>
                <p class="detail_content-title">休憩</p>
                </div>
                @foreach($rests as $index => $rest)
                <div class="detail_rest-item">
                <input type="time" class="detail_rest-text" value="{{ optional($rest->rest_in)->format('H:i') }}">
                <p class="detail_rest-text">～</p>
                <input type="time" class="detail_rest-text" value="{{ optional($rest->rest_out)->format('H:i') }}">
                </div>
                @endforeach
            </div>

            <div class="detail_rest-input">
                <p class="detail_content-title">休憩2</p>
                <input type="time" class="detail_rest-input-text">
                <p class="detail_rest-input-text">～</p>
                <input type="time" class="detail_rest-input-text">
            </div>

            <div class="detail_remarks">
                <p class="detail_content-title">備考</p>
                <textarea name="" id="" class="detail_remarks-text" rows="3" cols="35"></textarea>
            </div>
            <button class="form_button">修正</button>
        </div>
        
    </form>
</div>

@endsection