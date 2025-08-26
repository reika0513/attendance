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
                <th class="table_content">日付</th>
                <th class="table_content">出勤</th>
                <th class="table_content">退勤</th>
                <th class="table_content">休憩</th>
                <th class="table_content">合計</th>
                <th class="table_content">詳細</th>
            </tr>
            
            <tr class="table_title">
                @foreach
                <th class="table_content">{{$date}}</th>
                @endforeach
                @foreach
                <td class="table_content">{{$works->punch_in}}</td>
                <td class="table_content">{{$works->punch_out}}</td>
                @endforeach
                <td class="table_content">1:00</td>
                <td class="table_content">8:00</td>
                <td class="table_content">
                    <a href="" class="table_content-detail">詳細</a>
                </td>
            </tr>
            
        </table>
    </div>
</div>
@endsection