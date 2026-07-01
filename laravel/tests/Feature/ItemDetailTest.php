<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Item;
use App\Models\Like;
use App\Models\Order;
use App\Models\User;
use Tests\TestCase;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 必要な情報が表示される
     */
    public function test_item_detail_displays_required_information(): void
    {
        $seller = User::factory()->create();
        $commenter = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 1000,
            'description' => 'テスト商品の説明文です',
            'condition' => 'good',
        ]);

        // いいねを1件追加
        Like::factory()->create(['item_id' => $item->id]);

        // コメントを1件追加
        Comment::factory()->create([
            'item_id' => $item->id,
            'user_id' => $commenter->id,
            'body' => 'テストコメントです',
        ]);

        $response = $this->get(route('items.show', $item->id));

        $response->assertStatus(200);
        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('1,000');
        $response->assertSee('テスト商品の説明文です');
        $response->assertSee('良好'); // CONDITIONS['good']
        $response->assertSee('テストコメントです');
    }

    /**
     * 複数選択されたカテゴリが表示されているか
     */
    public function test_item_detail_displays_multiple_categories(): void
    {
        $item = Item::factory()->create();

        // カテゴリを2つ作って商品に紐付ける
        $category1 = Category::factory()->create(['name' => 'カテゴリA']);
        $category2 = Category::factory()->create(['name' => 'カテゴリB']);
        $item->categories()->attach([$category1->id, $category2->id]);

        $response = $this->get(route('items.show', $item->id));

        $response->assertStatus(200);
        $response->assertSee('カテゴリA');
        $response->assertSee('カテゴリB');
    }
}