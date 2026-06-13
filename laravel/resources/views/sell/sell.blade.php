@extends('layouts.app_search')

@push('styles')
    <style>
        .create-wrapper {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 16px 60px;
        }

        .page-title {
            font-size: 22px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 32px;
            color: #1a1a1a;
        }

        /* セクション */
        .section-block {
            margin-bottom: 32px;
        }

        .section-heading {
            font-size: 15px;
            font-weight: 700;
            color: #1a1a1a;
            padding-bottom: 8px;
            border-bottom: 1px solid #dddddd;
            margin-bottom: 20px;
        }

        .field-label {
            font-size: 14px;
            font-weight: 500;
            color: #333333;
            margin-bottom: 8px;
        }

        /* 画像アップロード */
        .image-upload-box {
            width: 100%;
            height: 160px;
            border: 2px dashed #cccccc;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .image-upload-box:hover { border-color: #e84444; }

        .image-upload-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        .btn-image-select {
            padding: 8px 20px;
            border: 1.5px solid #e84444;
            border-radius: 20px;
            background: #ffffff;
            color: #e84444;
            font-size: 13px;
            cursor: pointer;
        }

        /* カテゴリータグ */
        .category-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .category-tag input[type="checkbox"] { display: none; }

        .category-tag label {
            display: inline-block;
            padding: 6px 16px;
            border: 1.5px solid #cccccc;
            border-radius: 20px;
            font-size: 13px;
            color: #333333;
            cursor: pointer;
            transition: all 0.15s;
            user-select: none;
        }

        .category-tag input:checked + label {
            background-color: #e84444;
            border-color: #e84444;
            color: #ffffff;
        }

        /* セレクト */
        .form-select {
            width: 100%;
            height: 44px;
            padding: 0 14px;
            border: 1.5px solid #cccccc;
            border-radius: 4px;
            font-size: 14px;
            color: #333333;
            background-color: #ffffff;
            outline: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23666' stroke-width='1.5' fill='none'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            cursor: pointer;
        }

        .form-select:focus { border-color: #e84444; }

        /* テキスト系 */
        .form-input {
            width: 100%;
            height: 44px;
            padding: 0 14px;
            border: 1.5px solid #cccccc;
            border-radius: 4px;
            font-size: 14px;
            color: #333333;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-input:focus { border-color: #e84444; }

        .form-textarea {
            width: 100%;
            height: 120px;
            padding: 12px 14px;
            border: 1.5px solid #cccccc;
            border-radius: 4px;
            font-size: 14px;
            color: #333333;
            outline: none;
            resize: vertical;
            font-family: inherit;
            transition: border-color 0.2s;
        }

        .form-textarea:focus { border-color: #e84444; }

        /* 価格入力 */
        .price-input-wrap {
            position: relative;
        }

        .price-input-wrap span {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            color: #333333;
        }

        .price-input-wrap .form-input {
            padding-left: 28px;
        }

        .error-message {
            color: #e84444;
            font-size: 12px;
            margin-top: 4px;
        }

        .field-group { margin-bottom: 20px; }

        /* 出品ボタン */
        .btn-submit {
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

        .btn-submit:hover { background-color: #d03333; }
    </style>
@endpush

@section('content')

    <div class="create-wrapper">

        <h1 class="page-title">商品の出品</h1>

        <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

            {{-- 商品画像 --}}
            <div class="section-block">
                <p class="field-label">商品画像</p>
                <div class="image-upload-box" onclick="document.getElementById('image-input').click()">
                    <img id="preview-img" src="" alt="プレビュー">
                    <button type="button" class="btn-image-select" id="upload-btn">画像を選択する</button>
                </div>
                <input type="file" id="image-input" name="image" accept="image/*" style="display:none;">
                @error('image')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            {{-- 商品の詳細 --}}
            <div class="section-block">
                <p class="section-heading">商品の詳細</p>

                {{-- カテゴリー --}}
                <div class="field-group">
                    <p class="field-label">カテゴリー</p>
                    <div class="category-tags">
                        @foreach($categories as $category)
                            <div class="category-tag">
                                <input type="checkbox" name="categories[]"
                                       id="cat-{{ $category->id }}"
                                       value="{{ $category->id }}"
                                       {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                <label for="cat-{{ $category->id }}">{{ $category->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('categories')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 商品の状態 --}}
                <div class="field-group">
                    <p class="field-label">商品の状態</p>
                    <select name="condition" class="form-select">
                        <option value="">選択してください</option>
                        <option value="good" {{ old('condition') === 'good' ? 'selected' : '' }}>良好</option>
                        <option value="fair" {{ old('condition') === 'fair' ? 'selected' : '' }}>目立った傷や汚れなし</option>
                        <option value="poor" {{ old('condition') === 'poor' ? 'selected' : '' }}>やや傷や汚れあり</option>
                        <option value="bad" {{ old('condition') === 'bad' ? 'selected' : '' }}>状態が悪い</option>
                    </select>
                    @error('condition')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- 商品名と説明 --}}
            <div class="section-block">
                <p class="section-heading">商品名と説明</p>

                <div class="field-group">
                    <p class="field-label">商品名</p>
                    <input type="text" name="name" class="form-input"
                           value="{{ old('name') }}">
                    @error('name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field-group">
                    <p class="field-label">ブランド名</p>
                    <input type="text" name="brand" class="form-input"
                           value="{{ old('brand') }}">
                </div>

                <div class="field-group">
                    <p class="field-label">商品の説明</p>
                    <textarea name="description" class="form-textarea">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field-group">
                    <p class="field-label">販売価格</p>
                    <div class="price-input-wrap">
                        <span>¥</span>
                        <input type="number" name="price" class="form-input"
                               value="{{ old('price') }}" min="0">
                    </div>
                    @error('price')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn-submit">出品する</button>

        </form>
    </div>

    {{-- 画像プレビュー --}}
    <script>
        document.getElementById('image-input').addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = (e) => {
                const preview = document.getElementById('preview-img');
                const btn = document.getElementById('upload-btn');
                preview.src = e.target.result;
                preview.style.display = 'block';
                btn.style.display = 'none';
            };
            reader.readAsDataURL(file);
        });
    </script>

@endsection