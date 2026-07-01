<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * プロフィール画像、ユーザー名、出品した商品一覧、購入した商品一覧が正しく表示される
     */
    public function test_user_profile_displays_required_information(): void
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'profile_image' => 'profile_image/test.jpg',
            'postal_code' => '123-4567',
            'address' => 'テスト住所',
            'building' => 'テストビル',
        ]);

        // 出品した商品を2件作成
        $soldItem1 = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品1',
        ]);
        $soldItem2 = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品2',
        ]);

        // 購入した商品を1件作成
        $purchasedItem = Item::factory()->create(['name' => '購入商品1']);
        Order::factory()->create([
            'user_id' => $user->id,
            'item_id' => $purchasedItem->id,
        ]);

        // 出品商品一覧を確認
        $response = $this->actingAs($user)
            ->get(route('mypage'));

        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('profile_image/test.jpg');
        $response->assertViewHas('items', function ($items) use ($soldItem1, $soldItem2) {
            $ids = $items->pluck('id');
            return $ids->contains($soldItem1->id) && $ids->contains($soldItem2->id);
        });

        // 購入商品一覧を確認
        $response = $this->actingAs($user)
            ->get(route('mypage', ['tab' => 'buy']));

        $response->assertStatus(200);
        $response->assertViewHas('items', function ($items) use ($purchasedItem) {
            return $items->pluck('id')->contains($purchasedItem->id);
        });
    }
}