<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
}
/**Item.phpにこれを記載する
const CONDITIONS = [
    'good' => '良好',
    'fair' => 'まあまあ良好',
    'poor' => 'あまり良くない',
    'bad' => '良くない',
];