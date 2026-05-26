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
            font-family: 'Helvetica Neue', Arial, 'Hiragino Kaku Gothic ProN', 'Hiragino Sans', Meiryo, sans-serif;
            background-color: #ffffff;
            color: #333333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ヘッダー */
        .header {
            background-color: #1a1a1a;
            padding: 0 24px;
            height: 56px;
            display: flex;
            align-items: center;
        }

        .header-logo {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .logo-icon {
            width: 32px;
            height: 32px;
        }

        .logo-text {
            color: #ffffff;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 0.05em;
        }

        /* メインコンテンツ */
        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 60px 16px;
        }

        .content-wrapper {
            width: 100%;
            max-width: 580px;
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
            transition: border-color 0.2s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: #e84444;
        }

        /* エラーメッセージ */
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

        /* リンク */
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
            <!-- CT アイコン SVG -->
            <svg class="logo-icon" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="32" height="32" rx="3" fill="#e84444" />
                <text x="50%" y="50%" dominant-baseline="central" text-anchor="middle" fill="white" font-size="13"
                    font-weight="900" font-family="Arial, sans-serif" letter-spacing="-0.5">CT</text>
            </svg>
            <span class="logo-text">COACHTECH</span>
        </a>
    </header>

    <main class="main-content">
        <div class="content-wrapper">
            @yield('content')
        </div>
    </main>

</body>

</html>