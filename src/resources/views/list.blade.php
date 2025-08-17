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
                <th>日付</th>
                <th>出勤</th>
                <th>退勤</th>
                <th>休憩</th>
                <th>合計</th>
                <th>詳細</th>
            </tr>
            <tr class="table_content">
                <th>06/01(木)</th>
                <td>09:00</td>
                <td>18:00</td>
                <td>1:00</td>
                <td>8:00</td>
                <td>
                    <a href="">詳細</a>
                </td>
            </tr>
        </table>
    </div>
</div>
@endsection