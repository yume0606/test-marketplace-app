@extends('layouts.app_search')

@push('styles')
    <style>
        /* タブ */
        .tab-nav {
            display: flex;
            gap: 32px;
            padding: 0 40px;
            border-bottom: 1.5px solid #dddddd;
            margin-bottom: 32px;
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

    {{-- タブ --}}
    <div class="tab-nav">
        <a href="{{ route('items.index') }}" class="tab-link {{ request('tab') !== 'mylist' ? 'active' : '' }}">
            おすすめ
        </a>
        <a href="{{ route('items.index', ['tab' => 'mylist']) }}"
            class="tab-link {{ request('tab') === 'mylist' ? 'active' : '' }}">
            マイリスト
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
                </div>
                <p class="item-name">{{ $item->name }}</p>
            </a>
        @empty
            <p>商品がありません</p>
        @endforelse
    </div>

@endsection