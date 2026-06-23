@extends('layouts.app_search')

@push('styles')
    <style>
        .content-wrapper {
            max-width: 1100px;
        }

        .item-page {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 40px 80px;
        }

        /* 2カラムグリッド：左=画像、右=情報+説明以下すべて */
        .item-top {
            display: grid;
            grid-template-columns: 340px 1fr;
            gap: 48px;
            align-items: start;
        }

        /* 左：商品画像 */
        .item-image-box {
            width: 100%;
            aspect-ratio: 1 / 1;
            background-color: #d9d9d9;
            border-radius: 4px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #888888;
            font-size: 14px;
        }

        .item-image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* 右カラム全体 */
        .item-right-col {
            display: flex;
            flex-direction: column;
            gap: 40px;
            min-width: 0;
        }

        /* 右上：商品情報 */
        .item-info {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .item-name {
            font-size: 22px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 2px;
        }

        .item-brand {
            font-size: 13px;
            color: #888888;
        }

        .item-price {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
            white-space: nowrap;
        }

        .item-price span {
            font-size: 14px;
            font-weight: 400;
            color: #555555;
            margin-left: 4px;
        }

        /* いいね・コメント数 */
        .item-stats {
            display: flex;
            gap: 24px;
            align-items: center;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            font-size: 13px;
            color: #555555;
            cursor: pointer;
        }

        .stat-icon img {
            width: 28px;
            height: 28px;
        }

        .stat-icon img.liked {
            filter: invert(28%) sepia(80%) saturate(2476%) hue-rotate(346deg) brightness(95%) contrast(91%);
        }

        /* 購入ボタン */
        .btn-buy {
            display: block;
            width: 100%;
            height: 48px;
            background-color: #e84444;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            line-height: 48px;
            text-decoration: none;
            transition: background-color 0.2s;
        }

        .btn-buy:hover {
            background-color: #d03333;
        }

        /* 右下：説明・情報・コメント */
        .item-lower {
            display: flex;
            flex-direction: column;
            gap: 40px;
        }

        .divider {
            border: none;
            border-top: 1px solid #eeeeee;
            margin: 0;
        }

        /* セクションタイトル */
        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 16px;
        }

        /* 商品説明 */
        .item-description {
            font-size: 14px;
            color: #333333;
            line-height: 1.8;
            white-space: pre-line;
        }

        /* 商品情報テーブル */
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table tr {
            border-bottom: 1px solid #eeeeee;
        }

        .info-table td {
            padding: 12px 0;
            font-size: 14px;
            color: #333333;
        }

        .info-table td:first-child {
            width: 140px;
            font-weight: 600;
        }

        /* カテゴリータグ */
        .category-tags {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .tag {
            padding: 4px 14px;
            border: 1px solid #cccccc;
            border-radius: 20px;
            font-size: 13px;
            color: #333333;
        }

        /* コメント一覧 */
        .comment-list {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .comment-item {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .comment-user {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 600;
        }

        .comment-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #cccccc;
            overflow: hidden;
            flex-shrink: 0;
        }

        .comment-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .comment-body {
            background-color: #f2f2f2;
            border-radius: 4px;
            padding: 12px 16px;
            font-size: 14px;
            color: #333333;
            line-height: 1.6;
        }

        /* コメント投稿 */
        .comment-textarea {
            width: 100%;
            height: 120px;
            padding: 12px 14px;
            border: 1.5px solid #cccccc;
            border-radius: 4px;
            font-size: 14px;
            color: #333333;
            resize: vertical;
            outline: none;
            font-family: inherit;
            transition: border-color 0.2s;
            box-sizing: border-box;
        }

        .comment-textarea:focus {
            border-color: #e84444;
        }

        .btn-comment {
            display: block;
            width: 100%;
            height: 48px;
            background-color: #e84444;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 12px;
            transition: background-color 0.2s;
        }

        .btn-comment:hover {
            background-color: #d03333;
        }
    </style>
@endpush

@section('content')

    <div class="item-page">

        <div class="item-top">

            {{-- 左：画像のみ --}}
            <div class="item-image-box">
                @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                @else
                    商品画像
                @endif
            </div>

            {{-- 右：商品情報 + 説明以下すべて --}}
            <div class="item-right-col">

                {{-- 商品情報（上部） --}}
                <div class="item-info">
                    <div>
                        <p class="item-name">{{ $item->name }}</p>
                        <p class="item-brand">{{ $item->brand ?? '' }}</p>
                    </div>

                    <p class="item-price">¥{{ number_format($item->price) }}<span>(税込)</span></p>

                    {{-- いいね・コメント数 --}}
                    <div class="item-stats">
                        <div class="stat-item" id="like-button" data-item-id="{{ $item->id }}">
                            <span class="stat-icon">
                                <img src="{{ asset('design/heart.png') }}" alt="heart" id="heart-icon"
                                    class="{{ $item->like->contains('user_id', auth()->id()) ? 'liked' : '' }}">
                            </span>
                            <span id="like-count">{{ $item->like->count() }}</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-icon">
                                <img src="{{ asset('design/comment_mark.png') }}" alt="comment">
                            </span>
                            <span>{{ $item->comments->count() }}</span>
                        </div>
                    </div>

                    <a href="{{ route('items.purchase', $item->id) }}" class="btn-buy">購入手続きへ</a>
                </div>

                {{-- 説明・情報・コメント（右カラム下に続く） --}}
                <div class="item-lower">

                    <hr class="divider">

                    {{-- 商品説明 --}}
                    <div>
                        <p class="section-title">商品説明</p>
                        <p class="item-description">{{ $item->description }}</p>
                    </div>

                    <hr class="divider">

                    {{-- 商品の情報 --}}
                    <div>
                        <p class="section-title">商品の情報</p>
                        <table class="info-table">
                            <tr>
                                <td>カテゴリー</td>
                                <td>
                                    <div class="category-tags">
                                        @foreach($item->categories as $category)
                                            <span class="tag">{{ $category->name }}</span>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>商品の状態</td>
                                <td>{{ \App\Models\Item::CONDITIONS[$item->condition] ?? $item->condition }}</td>
                            </tr>
                        </table>
                    </div>

                    <hr class="divider">

                    {{-- コメント一覧 --}}
                    <div>
                        <p class="section-title">コメント({{ $item->comments->count() }})</p>
                        <div class="comment-list">
                            @foreach($item->comments as $comment)
                                <div class="comment-item">
                                    <div class="comment-user">
                                        <div class="comment-avatar">
                                            @if($comment->user->avatar)
                                                <img src="{{ asset('storage/' . $comment->user->avatar) }}"
                                                    alt="{{ $comment->user->name }}">
                                            @endif
                                        </div>
                                        {{ $comment->user->name }}
                                    </div>
                                    <p class="comment-body">{{ $comment->body }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <hr class="divider">

                    {{-- コメント投稿 --}}
                    <div>
                        <p class="section-title">商品へのコメント</p>
                        <form action="{{ route('comments.store', $item->id) }}" method="POST">
                            @csrf
                            <textarea name="body" class="comment-textarea" placeholder="コメントを入力してください"></textarea>
                            @error('body')
                                <p style="color:#e84444; font-size:12px; margin-top:4px;">{{ $message }}</p>
                            @enderror
                            <button type="submit" class="btn-comment">コメントを送信する</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('like-button').addEventListener('click', function () {
            const itemId = this.dataset.itemId;
            const icon = document.getElementById('heart-icon');
            const countEl = document.getElementById('like-count');

            fetch(`/items/${itemId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            })
                .then(response => {
                    if (response.status === 401) {
                        window.location.href = "{{ route('login') }}";
                        return;
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data) return;
                    countEl.textContent = data.count;
                    icon.classList.toggle('liked', data.liked);
                });
        });
    </script>
@endsection