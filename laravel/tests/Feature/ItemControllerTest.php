<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use Tests\TestCase;

class ItemControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 全商品を取得できる
     */
    public function test_all_items_are_displayed(): void
    {
        Item::factory()->count(3)->create();

        $response = $this->get(route('items.index'));

        $response->assertStatus(200);
        $response->assertViewHas('items', function ($items) {
            return $items->count() === 3;
        });
    }

    /**
     * 購入済み商品は「Sold」と表示される
     */
    public function test_sold_item_is_displayed_with_sold_label(): void
    {
        $item = Item::factory()->create();
        Order::factory()->create(['item_id' => $item->id]);

        $response = $this->get(route('items.index'));

        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    /**
     * 自分が出品した商品は表示されない
     */
    public function test_own_items_are_not_displayed(): void
    {
        $user = User::factory()->create();

        // 自分の商品
        $ownItem = Item::factory()->create(['user_id' => $user->id]);
        // 他人の商品
        $otherItem = Item::factory()->create();

        $response = $this->actingAs($user)->get(route('items.index'));

        $response->assertStatus(200);
        $response->assertViewHas('items', function ($items) use ($ownItem, $otherItem) {
            // 自分の商品が含まれていないこと
            $ids = $items->pluck('id');
            return !$ids->contains($ownItem->id) && $ids->contains($otherItem->id);
        });
    }
}