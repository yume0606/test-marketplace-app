<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>COACHTECH</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica Neue', Arial, 'Hiragino Kaku Gothic ProN', sans-serif;
            background-color: #ffffff;
            color: #333333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ヘッダー */
        .header {
            background-color: #000000;
            padding: 0 24px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }

        .header-logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            flex-shrink: 0;
        }

        .logo-img {
            height: 28px;
            width: auto;
        }

        .header-search {
            width: 500px;
            max-width: 480px;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            padding: 0 24px;
        }

        .header-search input {
            width: 100%;
            height: 36px;
            padding: 0 14px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            outline: none;
            background-color: #ffffff;
            color: #333;
        }

        .header-nav {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-left: auto;
        }

        .header-nav a {
            color: #ffffff;
            text-decoration: none;
            font-size: 14px;
            white-space: nowrap;
        }

        .header-nav a:hover {
            opacity: 0.8;
        }

        .btn-sell {
            padding: 8px 20px;
            border: 1.5px solid #ffffff;
            border-radius: 4px;
            color: #ffffff !important;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
        }

        /* メインコンテンツ */
        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            padding: 60px 16px;
        }

        .content-wrapper {
            width: 100%;
            max-width: 1100px;
        }

        /* ページタイトル */
        .page-title {
            font-size: 24px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 40px;
            color: #1a1a1a;
        }

        /* フォームグループ */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
            color: #333333;
        }

        .form-input {
            width: 100%;
            height: 48px;
            padding: 0 14px;
            border: 1.5px solid #cccccc;
            border-radius: 4px;
            font-size: 15px;
            color: #333333;
            background-color: #ffffff;
            outline: none;
            transition: border-color 0.2s ease;
        }

        .form-input:focus {
            border-color: #e84444;
        }

        .error-message {
            color: #e84444;
            font-size: 12px;
            margin-top: 4px;
        }

        /* ボタン */
        .btn-primary {
            display: block;
            width: 100%;
            height: 52px;
            background-color: #e84444;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
            margin-top: 40px;
        }

        .btn-primary:hover {
            background-color: #d03333;
        }

        .form-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #4a90d9;
            font-size: 14px;
            text-decoration: none;
        }

        .form-link:hover {
            text-decoration: underline;
        }
    </style>
    @stack('styles')
</head>

<body>

    <header class="header">
        <a href="/" class="header-logo">
            <img src="{{ asset('design/CoachTech.png') }}" alt="COACHTECH" class="logo-img">
        </a>

        <div class="header-search">
            <input type="text" placeholder="なにをお探しですか？">
        </div>

        <nav class="header-nav">
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                ログアウト
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
            <a href="{{ route('mypage') }}">マイページ</a>
            <a href="{{ route('items.create') }}" class="btn-sell">出品</a>
        </nav>
    </header>

    <main class="main-content">
        <div class="content-wrapper">
            @yield('content')
        </div>
    </main>

</body>

</html>