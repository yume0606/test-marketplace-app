<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use PhpParser\Node\Expr\Cast\Void_;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $items = [
            [
                'name' => '腕時計',
                'brand' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'price' => 15000,
                'condition' => 'good',
                'image' => 'items/腕時計.jpg',
                'categories' => ['家電', 'メンズ', 'ファッション', 'アクセサリー'],
            ],
            [
                'name' => 'HDD',
                'brand' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'price' => 5000,
                'condition' => 'fair',
                'image' => 'items/HDD.jpg',
                'categories' => ['インテリア', '家電', 'ゲーム'],
            ],
            [
                'name' => '玉ねぎ3束',
                'brand' => 'なし',
                'description' => '新鮮な玉ねぎ3束のセット',
                'price' => 300,
                'condition' => 'poor',
                'image' => 'items/玉ねぎ3束.jpg',
                'categories' => ['キッチン'],
            ],
            [
                'name' => '革靴',
                'brand' => '',
                'description' => 'クラシックなデザインの革靴',
                'price' => 4000,
                'condition' => 'bad',
                'image' => 'items/革靴.jpg',
                'categories' => ['メンズ', 'ファッション'],
            ],
            [
                'name' => 'ノートPC',
                'brand' => '',
                'description' => '高性能なノートパソコン',
                'price' => 45000,
                'condition' => 'good',
                'image' => 'items/ノートPC.jpg',
                'categories' => ['家電', 'ゲーム',],
            ],
            [
                'name' => 'マイク',
                'brand' => 'なし',
                'description' => '高音質のレコーディング用マイク',
                'price' => 8000,
                'condition' => 'good',
                'image' => 'items/マイク.jpg',
                'categories' => ['家電', 'ゲーム', 'おもちゃ'],
            ],
            [
                'name' => 'ショルダーバッグ',
                'brand' => '',
                'description' => 'おしゃれなショルダーバッグ',
                'price' => 3500,
                'condition' => 'poor',
                'image' => 'items/ショルダーバッグ.jpg',
                'categories' => ['ファッション', 'レディース',],
            ],
            [
                'name' => 'タンブラー',
                'brand' => 'なし',
                'description' => '使いやすいタンブラー',
                'price' => 500,
                'condition' => 'bad',
                'image' => 'items/タンブラー.jpg',
                'categories' => ['キッチン'],
            ],
            [
                'name' => 'コーヒーミル',
                'brand' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'price' => 4000,
                'condition' => 'good',
                'image' => 'items/コーヒーミル.jpg',
                'categories' => ['キッチン', 'インテリア', 'ハンドメイド'],
            ],
            [
                'name' => 'メイクセット',
                'brand' => '',
                'description' => '便利なメイクアップセット',
                'price' => 4000,
                'condition' => 'fair',
                'image' => 'items/メイクセット.jpg',
                'categories' => ['レディース', 'コスメ', 'アクセサリー'],
            ],
        ];
        foreach ($items as $data) {
            $categoryIds = Category::whereIn('name', $data['categories'])->pluck('id')->toArray();

            $item = Item::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'brand' => $data['brand'],
                'description' => $data['description'],
                'price' => $data['price'],
                'condition' => $data['condition'],
                'image' => $data['image'],
            ]);

            $item->categories()->attach($categoryIds);
        }
    }
}