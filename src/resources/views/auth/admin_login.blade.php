@extends('layouts.app_admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/admin_login.css') }}">
@endsection

@section('content')
<div class="admin_login">
    <div class="login_header">
        <h1 class="login_header-logo">管理者ログイン</h1>
    </div>
    <form class="form" action="/admin/login" method="post">
        @csrf
        <div class="form_frame">
            <div class="form_group">
                <p class="form_title">メールアドレス</p>
                <div class="form_group-content">
                    <div class="form_group-text">
                        <input class="form_group-text_input" name="email" type="email" value="{{ old('email')}}">
                    </div>
                    <div class="form_error">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form_group">
                <p class="form_title">パスワード</p>
                <div class="form_group-content">
                    <div class="form_group-text">
                        <input class="form_group-text_input" name="password" type="text">
                    </div>
                    <div class="form_error">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="form_button">
            <button class="form_button-submit" type="submit">管理者ログインする</button>
        </div>
    </form>
</div>
@endsection