@extends('layouts.app_search')

@push('styles')
    <style>
        .purchase-layout {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 40px;
            padding: 40px 40px;
            max-width: 1100px;
            margin: 0 auto;
            align-items: start;
        }

        /* 左カラム */
        /* 商品サマリー */
        .item-summary {
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 24px;
        }

        .item-thumb {
            width: 150px;
            height: 150px;
            background-color: #d9d9d9;
            border-radius: 4px;
            overflow: hidden;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            color: #888888;
        }

        .item-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item-summary-info {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .item-summary-name {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .item-summary-price {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .divider {
            border: none;
            border-top: 1px solid #dddddd;
            margin: 8px 0 24px;
        }

        /* セクション */
        .section-label {
            font-size: 15px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }

        /* 支払い方法セレクト */
        .payment-select {
            width: 240px;
            height: 40px;
            padding: 0 12px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            font-size: 14px;
            color: #333333;
            background-color: #ffffff;
            outline: none;
            cursor: pointer;
        }

        .payment-select:focus {
            border-color: #e84444;
        }

        /* 配送先 */
        .delivery-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .delivery-address {
            font-size: 14px;
            color: #333333;
            line-height: 1.8;
            padding-left: 8px;
        }

        .link-change {
            color: #4a90d9;
            font-size: 14px;
            text-decoration: none;
        }

        .link-change:hover {
            text-decoration: underline;
        }

        /* 右カラム：サマリーボックス */
        .purchase-summary {
            border: 1.5px solid #333333;
            border-radius: 4px;
            overflow: hidden;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 24px;
            font-size: 15px;
            color: #333333;
            border-bottom: 1px solid #333333;
        }

        .summary-row:last-child {
            border-bottom: none;
        }

        .summary-row .label {
            font-weight: 500;
        }

        .summary-row .value {
            font-weight: 600;
        }

        .btn-purchase {
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
            margin-top: 16px;
            transition: background-color 0.2s;
        }

        .btn-purchase:hover {
            background-color: #d03333;
        }
    </style>
@endpush

@section('content')

    <form action="{{ route('purchase.store', $item->id) }}" method="POST">
        @csrf

        <div class="purchase-layout">

            {{-- 左カラム --}}
            <div>

                {{-- 商品サマリー --}}
                <div class="item-summary">
                    <div class="item-thumb">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                        @else
                            商品画像
                        @endif
                    </div>
                    <div class="item-summary-info">
                        <p class="item-summary-name">{{ $item->name }}</p>
                        <p class="item-summary-price">¥ {{ number_format($item->price) }}</p>
                    </div>
                </div>

                <hr class="divider">

                {{-- 支払い方法 --}}
                <div style="margin-bottom: 32px;">
                    <p class="section-label">支払い方法</p>
                    <select name="payment_method" class="payment-select" id="payment-select">
                        <option value="convenience" {{ old('payment_method') === 'convenience' ? 'selected' : '' }}>
                            コンビニ払い
                        </option>
                        <option value="card" {{ old('payment_method') === 'card' ? 'selected' : '' }}>
                            カード支払い
                        </option>
                    </select>
                    @error('payment_method')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="divider">

                {{-- 配送先 --}}
                <div style="margin-bottom: 32px;">
                    <div class="delivery-header">
                        <p class="section-label" style="margin-bottom:0;">配送先</p>
                        <a href="{{ route('purchase.address.edit', $item->id) }}" class="link-change">変更する</a>
                    </div>
                    <div class="delivery-address">
                        <p>〒 {{ Auth::user()->postal_code ?? 'XXX-YYYY' }}</p>
                        <p>{{ (Auth::user()->address ?? '') . (Auth::user()->building ?? '') ?: 'ここには住所と建物が入ります' }}</p>
                    </div>
                </div>

                <hr class="divider">

            </div>

            {{-- 右カラム --}}
            <div>
                <div class="purchase-summary">
                    <div class="summary-row">
                        <span class="label">商品代金</span>
                        <span class="value">¥ {{ number_format($item->price) }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="label">支払い方法</span>
                        <span class="value" id="summary-payment">コンビニ払い</span>
                    </div>
                </div>

                <button type="submit" class="btn-purchase">購入する</button>
            </div>

        </div>

    </form>

    {{-- 支払い方法の連動 --}}
    <script>
        const select = document.getElementById('payment-select');
        const summaryPayment = document.getElementById('summary-payment');
        const labels = { convenience: 'コンビニ払い', card: 'カード支払い' };

        select.addEventListener('change', () => {
            summaryPayment.textContent = labels[select.value] ?? select.value;
        });
    </script>

@endsection