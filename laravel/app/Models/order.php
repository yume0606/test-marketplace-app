<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    //コンビニ払いかカード払いかの選択をする
    const PAYMENT_METHOD = [
        'convenience_store' => 'コンビニ払い',
        'credit_card' => 'カード支払い',
    ];
    protected $fillable = [
        'user_id',
        'item_id',
        'payment_method',
        'postal_code',
        'address',
        'building',
        'purchased_at',
    ];
    //購入者
    public function buyer()
    {
        return $this->belongsTo
        (User::class, 'user_id');
    }
    //購入された商品
    public function item()
    {
        return $this->belongsTo
        (Item::class);
    }
}
