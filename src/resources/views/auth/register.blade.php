@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
<div class="register">
    <div class="register_header">
        <h1 class="register_header-logo">会員登録</h1>
    </div>
    <form class="form" action="/register" method="post">
        @csrf
        <div class="form_frame">
            <div class="form_group">
                <p class="form_title">名前</p>
                <div class="form_group-content">
                    <div class="form_group-text">
                        <input class="form_group-text_input" name="name" type="text" value="{{ old('name')}}">
                    </div>
                    <div class="form_error">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
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
                        <input class="form_group-text_input" name="password" type="password">
                    </div>
                    <div class="form_error">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form_group">
                <p class="form_title">パスワード確認</p>
                <div class="form_group-content">
                    <div class="form_group-text">
                        <input class="form_group-text_input" name="password_confirmation" type="password">
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
            <button class="form_button-submit" type="submit">登録する</button>
        </div>
    </form>
    <div class="login">
        <a class="login_button" href="/login">ログインはこちら</a>
    </div>
</div>

@endsection