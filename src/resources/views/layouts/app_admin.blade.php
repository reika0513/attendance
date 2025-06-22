<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoachTech 勤怠管理アプリ</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/attendance">
                COACHTECH
            </a>
            <div class="header_button">
                <a class="button_stamp" href="/admin/attendance/list">勤怠一覧</a>
                <a class="button_list" href="/admin/staff/list">スタッフ一覧</a>
                <a class="button_application" href="/stamp_correction_request/list">申請一覧</a>
                <form class="logout_form" action="/logout" method="post">
                @csrf
                    <button class="button_application">ログアウト</button>
                </form>
            </div>
        </div>
    </header>
    
  <main>
    @yield('content')
  </main>
</body>
</html>