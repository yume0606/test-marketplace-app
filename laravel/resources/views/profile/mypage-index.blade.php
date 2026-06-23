@extends('layouts.app_search')

@push('styles')
    <style>
        /* プロフィールヘッダー */
        .profile-header {
            display: flex;
            align-items: center;
            gap: 32px;
            padding: 40px 40px 32px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .profile-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background-color: #cccccc;
            overflow: hidden;
            flex-shrink: 0;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-name {
            font-size: 22px;
            font-weight: 700;
            color: #1a1a1a;
            flex: 1;
        }

        .btn-edit-profile {
            padding: 10px 24px;
            border: 1.5px solid #e84444;
            border-radius: 4px;
            background: #ffffff;
            color: #e84444;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-edit-profile:hover {
            background-color: #fff0f0;
        }

        /* タブ */
        .tab-nav {
            display: flex;
            gap: 32px;
            padding: 0 40px;
            border-bottom: 1.5px solid #dddddd;
            margin-bottom: 32px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .tab-link {
            padding: 16px 0;
            font-size: 15px;
            color: #999999;
            text-decoration: none;
            border-bottom: 2px solid transparent;
            margin-bottom: -1.5px;
        }

        .tab-link.active {
            color: #e84444;
            border-bottom-color: #e84444;
            font-weight: 600;
        }

        .tab-link:hover {
            color: #333333;
        }

        /* 商品グリッド */
        .item-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            padding: 0 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .item-card {
            text-decoration: none;
            color: #333333;
        }

        .item-image {
            width: 100%;
            aspect-ratio: 1 / 1;
            background-color: #d9d9d9;
            border-radius: 4px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #888888;
            margin-bottom: 8px;
            position: relative;
        }

        .sold-label {
            position: absolute;
            top: 8px;
            left: 8px;
            background-color: red;
            color: #fff;
            font-size: 12px;
            font-weight: bold;
            padding: 4px 10px;
            border-radius: 4px;
        }

        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item-name {
            font-size: 14px;
            color: #1a1a1a;
        }
    </style>
@endpush

@section('content')

    {{-- プロフィールヘッダー --}}
    <div class="profile-header">
        <div class="profile-avatar">
            @if(Auth::user()->profile_image)
                <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="アバター">
            @endif
        </div>
        <p class="profile-name">{{ Auth::user()->name }}</p>
        <a href="{{ route('profile.edit') }}" class="btn-edit-profile">プロフィールを編集</a>
    </div>

    {{-- タブ --}}
    <div class="tab-nav">
        <a href="{{ route('mypage', ['tab' => 'sell']) }}"
            class="tab-link {{ request('tab', 'sell') === 'sell' ? 'active' : '' }}">
            出品した商品
        </a>
        <a href="{{ route('mypage', ['tab' => 'buy']) }}" class="tab-link {{ request('tab') === 'buy' ? 'active' : '' }}">
            購入した商品
        </a>
    </div>

    {{-- 商品グリッド --}}
    <div class="item-grid">
        @forelse($items as $item)
            <a href="{{ route('items.show', $item->id) }}" class="item-card">
                <div class="item-image">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                    @else
                        商品画像
                    @endif
                    @if($item->order)
                        <span class="sold-label">Sold</span>
                    @endif
                </div>
                <p class="item-name">{{ $item->name }}</p>
            </a>
        @empty
            <p style="color:#888; font-size:14px;">商品がありません</p>
        @endforelse
    </div>

@endsection