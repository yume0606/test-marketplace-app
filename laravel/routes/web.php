<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuyController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\UserController;

// 商品一覧画面
Route::get('/', [ItemController::class, 'index'])->name('items.index');

// 商品詳細画面
Route::get('/item/{item}', [ItemController::class, 'show'])->name('items.show');

// ここから下はログインが必要な機能
Route::middleware('auth')->group(function () {
    // 商品コメント機能
    Route::post('/item/{item}/comment', [CommentController::class, 'store'])->name('comments.store');

    // 商品購入画面
    Route::get('/purchase/{item}', [BuyController::class, 'buy_index'])->name('items.purchase');
    // 商品購入機能
    Route::post('/purchase/{item}', [BuyController::class, 'store'])->name('purchase.store');

    // 送付先住所変更画面
    Route::get('/purchase/address/{item}', [UserController::class, 'address_edit'])->name('purchase.address.edit');
    //送付先住所変更機能
    Route::put('/purchase/address/{item}', [UserController::class, 'address_update'])->name('purchase.address.update');

    // プロフィール画面
    Route::get('/mypage', [UserController::class, 'index'])->name('mypage');
    // プロフィール編集画面
    Route::get('/mypage/profile', [UserController::class, 'edit'])->name('profile.edit');
    // プロフィール編集機能
    Route::put('/mypage/profile', [UserController::class, 'update'])->name('profile.update');

    // 商品出品画面
    Route::get('/sell', [SellController::class, 'create'])->name('items.create');
    // 商品出品機能
    Route::post('/sell', [SellController::class, 'store'])->name('items.store');

    //いいね機能
    Route::post('/items/{item}/like', [LikeController::class, 'create'])->name('items.like');

});