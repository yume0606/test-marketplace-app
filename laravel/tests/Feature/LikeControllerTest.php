<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Item;
use App\Models\Like;
use App\Models\Order;
use App\Models\User;
use Tests\TestCase;

class LikeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * いいねした商品だけが表示される
     */
    public function test_only_liked_items_are_displayed(): void
    {
        $user = User::factory()->create();

        // いいねした商品
        $likedItem = Item::factory()->create();
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);

        // いいねしていない商品
        $notLikedItem = Item::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('items.index', ['tab' => 'mylist']));

        $response->assertStatus(200);
        $response->assertViewHas('items', function ($items) use ($likedItem, $notLikedItem) {
            $ids = $items->pluck('id');
            return $ids->contains($likedItem->id) && !$ids->contains($notLikedItem->id);
        });
    }

    /**
     * 購入済み商品は「Sold」と表示される
     */
    public function test_sold_item_is_displayed_with_sold_label(): void
    {
        $user = User::factory()->create();

        // いいねした商品を購入済みにする
        $item = Item::factory()->create();
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        Order::factory()->create(['item_id' => $item->id]);

        $response = $this->actingAs($user)
            ->get(route('items.index', ['tab' => 'mylist']));

        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    /**
     * 未認証の場合は何も表示されない
     */
    public function test_guest_sees_no_items_in_mylist(): void
    {
        // 商品を作っておく
        Item::factory()->count(3)->create();

        $response = $this->get(route('items.index', ['tab' => 'mylist']));

        $response->assertStatus(200);
        $response->assertViewHas('items', function ($items) {
            return $items->count() === 0;
        });
    }
}