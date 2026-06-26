@extends('layouts.app')

@push('styles')
    <style>
        .verify-guide-page {
            max-width: 480px;
            margin: 80px auto;
            text-align: center;
            padding: 0 20px;
        }

        .verify-guide-page p {
            font-size: 14px;
            color: #333333;
            line-height: 1.8;
            margin-bottom: 8px;
        }

        .success-message {
            color: #2e7d32;
            font-weight: 600;
            margin-top: 16px;
        }

        .btn-resend {
            display: inline-block;
            width: 100%;
            height: 48px;
            background-color: #e84444;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 24px;
            transition: background-color 0.2s;
        }

        .btn-resend:hover {
            background-color: #d03333;
        }
    </style>
@endpush

@section('content')
    <div class="verify-guide-page">
        <h1 class="page-title">メール認証へのご協力をお願いします</h1>

        <p>ご登録いただいたメールアドレス宛に認証用のメールを送信しました。</p>
        <p>メール本文内のリンクをクリックして、認証を完了してください。</p>

        @if (session('status') == 'verification-link-sent')
            <p class="success-message">
                認証メールを再送しました。
            </p>
        @endif

        <form action="{{ route('verification.send') }}" method="POST">
            @csrf
            <button type="submit" class="btn-resend">認証はこちらから</button>
        </form>
    </div>
@endsection