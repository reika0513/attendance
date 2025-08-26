@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/application.css') }}">
@endsection

@section('content')
<div class="application">
<h1 class="title">申請一覧</h1>

<div class="application_content">
    <div class="content_header">
        <p class="header-wait">承認待ち</p>
        <p class="header-finish">承認済み</p>
    </div>
</div>
</div>

@endsection