<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    const CONDITIONS = [
        'good' => '良好',
        'fair' => '目立った傷や汚れなし',
        'poor' => 'やや傷や汚れあり',
        'bad' => '状態が悪い',
    ];

    protected $fillable = [
        'user_id',
        //'category_id',
        'condition',
        'name',
        'brand',
        'description',
        'price',
        'image'
    ];
    //出品者
    public function user()
    {
        return $this->belongsTo
        (User::class);
    }
    //カテゴリー（多対多）
    public function categories()
    {
        return $this->belongsToMany
        (Category::class, 'item_categories');
    }
    //注文
    public function order()
    {
        return $this->hasOne
        (Order::class);
    }
    //いいね
    public function like()
    {
        return $this->hasMany
        (Like::class);
    }
    //コメント
    public function comments()
    {
        return $this->hasMany
        (Comment::class);
    }
}