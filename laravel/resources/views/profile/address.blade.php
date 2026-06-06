@extends('layouts.app_search')

@section('content')

    <h1 class="page-title">住所の変更</h1>

    <form action="{{ route('purchase.address.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">郵便番号</label>
            <input type="text" name="postal_code" class="form-input"
                value="{{ old('postal_code', Auth::user()->postal_code ?? '') }}">
            @error('postal_code')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">住所</label>
            <input type="text" name="address" class="form-input" value="{{ old('address', Auth::user()->address ?? '') }}">
            @error('address')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

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