@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
<div class="login">
    <div class="login_header">
        <h1 class="login_header-logo">ログイン</h1>
    </div>
    <form class="form" action="/login" method="post">
        @csrf
        <div class="form_frame">
            <div class="form_group">
                <p class="form_title">メールアドレス</p>
                <div class="form_group-content">
                    <div class="form_group-text">
                        <input class="form_group-text_input" name="email" type="email" value="{{ old('email')}}">
                    </div>
                    <div class="form_error">
                        <!--エラーメッセージ-->
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
                        <!--エラーメッセージ-->
                    </div>
                </div>
            </div>
        </div>
        <div class="form_button">
            <button class="form_button-submit" type="submit">ログインする</button>
        </div>
    </form>
    <div class="register">
        <a class="register_button" href="/register">会員登録はこちら</a>
    </div>
</div>
@endsection