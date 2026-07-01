<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\User;
use Tests\TestCase;

class SellTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 商品出品画面にて必要な情報が保存できること
     */
    public function test_user_can_create_item_with_required_information(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $category1 = Category::factory()->create(['name' => 'カテゴリA']);
        $category2 = Category::factory()->create(['name' => 'カテゴリB']);

        $response = $this->actingAs($user)
            ->post(route('items.store'), [
                'name' => 'テスト商品',
                'brand' => 'テストブランド',
                'description' => 'テスト商品の説明文です',
                'price' => 1000,
                'condition' => 'good',
                'categories' => [$category1->id, $category2->id],
                'image' => UploadedFile::fake()->image('test.jpg'),
            ]);

        // DBに商品が保存されていることを確認
        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => 'テスト商品の説明文です',
            'price' => 1000,
            'condition' => 'good',
        ]);

        // カテゴリが紐づいていることを確認
        $item = $user->items()->first();
        $categoryIds = $item->categories->pluck('id');
        $this->assertTrue($categoryIds->contains($category1->id));
        $this->assertTrue($categoryIds->contains($category2->id));

        // 商品一覧にリダイレクトされることを確認
        $response->assertRedirect(route('items.index'));
    }
}