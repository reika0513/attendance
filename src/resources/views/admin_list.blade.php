@extends('layouts.app_admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_list.css') }}">
@endsection

@section('content')
<div class="list">
    <div class="detail_title">
        <h1 class="title">{{$ja_dates}}の勤怠一覧</h1>
    </div>
    <div class="list_month">
        <a href="" class="last_month">← 前日</a>
        <p class="month">{{$dates}}</p>
        <a href="" class="next_month">翌日 →</a>
    </div>
    <div class="list_day">
        <table class="list_day-table">
            <tr class="table_title">
                <th class="table_title-detail">名前</th>
                <th class="table_title-detail">出勤</th>
                <th class="table_title-detail">退勤</th>
                <th class="table_title-detail">休憩</th>
                <th class="table_title-detail">合計</th>
                <th class="table_title-detail">詳細</th>
            </tr>
        @foreach ($works as $work)
        <tr class="table_content">
            <td class="table_content-detail">{{$work->user->name}}</td>
            <td class="table_content-detail">{{$work->punch_in->format('H:i')}}</td>
            <td class="table_content-detail">{{optional($work->punch_out)->format('H:i')}}</td>
            <td class="table_content-detail">{{ $rests[$work->id] ?? '00:00' }}</td>
            <td class="table_content-detail">{{ $totals[$work->id] ?? '00:00' }}</td>
            <td class="table_content-detail">
                <a href="/admin/attendance/{{$work->id}}" class="table_content_detail-link">詳細</a>
            </td>
        </tr>
        @endforeach               
                
        </table>
    </div>
</div>
@endsection