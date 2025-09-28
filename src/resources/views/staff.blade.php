@extends('layouts.app_admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/staff.css') }}">
@endsection

@section('content')
<div class="list">
    <div class="detail_title">
        <h1 class="title">スタッフ一覧</h1>
    </div>
    <div class="list_staff">
        <table class="list_staff-table">
            <tr class="table_title">
                <th class="table_title-detail">名前</th>
                <th class="table_title-detail">メールアドレス</th>
                <th class="table_title-detail">月次勤怠</th>
            </tr>

        @foreach ($users as $user)
        <tr class="table_content">
            <td class="table_content-detail">{{$user->name}}</td>
            <td class="table_content-detail">{{$user->email}}</td>
            <td class="table_content-detail">
                <a href="/admin/attendance/staff/{{$user->id}}" class="table_content_detail-link">詳細</a>
            </td>
        </tr>
        @endforeach
        </table>
    </div>
</div>

@endsection