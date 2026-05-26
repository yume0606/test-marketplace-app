@extends('layouts.app')

@section('content')

    <h1 class="page-title">ログイン</h1>

    {{-- セッションエラー --}}
    @if (session('status'))
        <p class="error-message" style="text-align:center; margin-bottom: 16px;">
            {{ session('status') }}
        </p>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

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
            <input class="form-input" type="password" id="password" name="password" autocomplete="current-password">
            @error('password')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-primary">ログインする</button>

    </form>

    <a href="{{ route('register') }}" class="form-link">会員登録はこちら</a>

@endsection