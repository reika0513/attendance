@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/list.css') }}">
@endsection

@section('content')
<div class="list">
    <div class="list_title"></div>
    <h1 class="title">勤怠一覧</h1>
    <div class="list_month">
        <p class="last_month">← 前月</p>
        <p class="month">2025/08</p>
        <p class="next_month">翌月 →</p>
    </div>
    <div class="list_day">
        <table class="list_day-table">
            <tr class="table_title">
                <th class="table_title-detail">日付</th>
                <th class="table_title-detail">出勤</th>
                <th class="table_title-detail">退勤</th>
                <th class="table_title-detail">休憩</th>
                <th class="table_title-detail">合計</th>
                <th class="table_title-detail">詳細</th>
            </tr>
                @foreach ($works as $work)
                <tr class="table_content">
                <td class="table_content-detail"></td>
                <td class="table_content-detail">{{$work->punch_in}}</td>
                <td class="table_content-detail">{{$work->punch_out}}</td>
                </tr>
                @endforeach
                @foreach ($rests as $rest)
                <tr class="table_content">
                <td class="table_content-detail">{{$rest->rest_in}}</td>
                <td class="table_content-detail"></td>
                <td class="table_content-detail">
                    <a href="" class="table_content_detail-link">詳細</a>
                </td>
                </tr>
                @endforeach               
                
        </table>
    </div>
</div>
@endsection