<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoachTech 勤怠アプリ</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/auth/admin_login.css') }}">
</head>

<body>
<header class="header">
    <div class="header__inner">
        <a class="header__logo" href="/admin/attendance/list">
            COACHTECH
        </a>
</header>
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
</body>
