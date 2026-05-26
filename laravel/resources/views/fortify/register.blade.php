@extends('layouts.app')

@section('content')

    <h1 class="page-title">会員登録</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- ユーザー名 --}}
        <div class="form-group">
            <label class="form-label" for="name">ユーザー名</label>
            <input class="form-input" type="text" id="name" name="name" value="{{ old('name') }}" autocomplete="name">
            @error('name')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- メールアドレス --}}
        <div class="form-group">
            <label class="form-label" for="email">メールアドレス</label>
            <input class="form-input" type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email">
            @error('email')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- パスワード --}}
        <div class="form-group">
            <label class="form-label" for="password">パスワード</label>
            <input class="form-input" type="password" id="password" name="password" autocomplete="new-password">
            @error('password')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- 確認用パスワード --}}
        <div class="form-group">
            <label class="form-label" for="password_confirmation">確認用パスワード</label>
            <input class="form-input" type="password" id="password_confirmation" name="password_confirmation"
                autocomplete="new-password">
            @error('password_confirmation')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-primary">登録する</button>

    </form>

    <a href="{{ route('login') }}" class="form-link">ログインはこちら</a>

@endsection