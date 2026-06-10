<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuyController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//商品一覧画面
Route::get('/', [ItemController::class, 'index'])->name('items.index');
//商品詳細画面
Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');
//プロフィール画面
Route::get('/mypage', [UserController::class, 'index'])->name('mypage');
//プロフィール編集画面
Route::get('/mypage/profile', [UserController::class, 'edit'])->name('profile.edit');
//プロフィール編集機能
Route::post('/mypage/profile', [UserController::class, 'update'])->name('profile.update');
//商品出品画面
Route::get('/sell', [SellController::class, 'create'])->name('items.create');
//商品出品機能
Route::post('/sell', [SellController::class, 'store'])->name('items.store');