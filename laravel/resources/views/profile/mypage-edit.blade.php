@extends('layouts.app_search')

@push('styles')
    <style>
        .content-wrapper {
            max-width: 520px;
        }
    </style>
@endpush

@section('content')

    @push('styles')
        <style>
            /* アバター */
            .avatar-section {
                display: flex;
                align-items: center;
                gap: 24px;
                margin-bottom: 40px;
            }

            .avatar-circle {
                width: 90px;
                height: 90px;
                border-radius: 50%;
                background-color: #cccccc;
                overflow: hidden;
                flex-shrink: 0;
            }

            .avatar-circle img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .btn-image-select {
                padding: 10px 20px;
                border: 1.5px solid #e84444;
                border-radius: 4px;
                background: #ffffff;
                color: #e84444;
                font-size: 14px;
                font-weight: 500;
                cursor: pointer;
            }

            .btn-image-select:hover {
                background-color: #fff0f0;
            }
        </style>
    @endpush

    <h1 class="page-title">プロフィール設定</h1>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- アバター --}}
        <div class="avatar-section">
            <div class="avatar-circle">
                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="アバター">
                @endif
            </div>
            <div>
                <input type="file" name="avatar" id="avatar" accept="image/*" style="display:none;">
                <button type="button" class="btn-image-select" onclick="document.getElementById('avatar').click()">
                    画像を選択する
                </button>
            </div>
        </div>

        {{-- ユーザー名 --}}
        <div class="form-group">
            <label class="form-label">ユーザー名</label>
            <input type="text" name="name" class="form-input" value="{{ old('name', Auth::user()->name) }}">
            @error('name')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- 郵便番号 --}}
        <div class="form-group">
            <label class="form-label">郵便番号</label>
            <input type="text" name="postal_code" class="form-input"
                value="{{ old('postal_code', Auth::user()->postal_code ?? '') }}">
            @error('postal_code')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- 住所 --}}
        <div class="form-group">
            <label class="form-label">住所</label>
            <input type="text" name="address" class="form-input" value="{{ old('address', Auth::user()->address ?? '') }}">
            @error('address')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        {{-- 建物名 --}}
        <div class="form-group">
            <label class="form-label">建物名</label>
            <input type="text" name="building" class="form-input"
                value="{{ old('building', Auth::user()->building ?? '') }}">
            @error('building')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-primary">更新する</button>
    </form>

@endsection