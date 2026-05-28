<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
}
/**これのカードかコンビニ払いかの選択をするItem.php
const CONDITIONS = [
    'good' => '良好',
    'fair' => 'まあまあ良好',
    'poor' => 'あまり良くない',
    'bad'  => '良くない',
];