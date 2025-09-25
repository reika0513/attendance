@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/application_wait.css') }}">
@endsection

@section('content')
<div class="application">
    <h1 class="title">申請一覧</h1>

    <div class="application_content">
        <div class="content_header">
            <a href="/stamp_correction_request/list_wait" class="header-wait">承認待ち</a>
            <a href="/stamp_correction_request/list_finish" class="header-finish">承認済み</a>
        </div>

        <div class="application_wait">
            <table class="application_wait-table">
                <tr class="table_title">
                    <th class="table_content">状態</th>
                    <th class="table_content">名前</th>
                    <th class="table_content">対象日時</th>
                    <th class="table_content">申請理由</th>
                    <th class="table_content">申請日時</th>
                    <th class="table_content">詳細</th>
                </tr>
                
                @foreach ($corrections as $correction)
                <tr class="table_title">
                    <th class="table_content">承認待ち</th>
                    <td class="table_content">{{$user->name}}</td>
                    <td class="table_content">{{$correction->punch_in->format('Y/m/d') }}</td>
                    <td class="table_content">{{$correction->remark}}</td>
                    <td class="table_content">{{$correction->created_at->format('Y/m/d') }}</td>
                    <td class="table_content">
                        <a href="" class="table_content-detail">詳細</a>
                    </td>
                </tr>
                @endforeach
                
            </table>
        </div>
    </div>
</div>
@endsection