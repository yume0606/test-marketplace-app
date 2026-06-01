<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    const CONDITIONS = [
        'good' => '良好',
        'fair' => 'まあまあ良好',
        'poor' => 'あまり良くない',
        'bad' => '良くない',
    ];

    protected $fillable = [
        'user_id',
        'category_id',
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
    public function category()
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
    public function comment()
    {
        return $this->hasMany
        (Comment::class);
    }
}