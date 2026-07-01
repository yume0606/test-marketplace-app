<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Item;
use App\Models\Like;
use App\Models\User;
use Tests\TestCase;

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 「商品名」で部分一致検索ができる
     */
    public function test_items_can_be_searched_by_keyword(): void
    {
        // 検索にヒットする商品
        $matchItem = Item::factory()->create(['name' => 'テスト商品']);
        // 検索にヒットしない商品
        $notMatchItem = Item::factory()->create(['name' => '全然関係ない商品']);

        $response = $this->get(route('items.index', ['keyword' => 'テスト']));

        $response->assertStatus(200);
        $response->assertViewHas('items', function ($items) use ($matchItem, $notMatchItem) {
            $ids = $items->pluck('id');
            return $ids->contains($matchItem->id) && !$ids->contains($notMatchItem->id);
        });
    }

    /**
     * 検索状態がマイリストでも保持されている
     */
    public function test_search_keyword_is_preserved_in_mylist(): void
    {
        $user = User::factory()->create();

        // いいねした商品(検索にヒットする)
        $matchItem = Item::factory()->create(['name' => 'テスト商品']);
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $matchItem->id,
        ]);

        // いいねした商品(検索にヒットしない)
        $notMatchItem = Item::factory()->create(['name' => '全然関係ない商品']);
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $notMatchItem->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('items.index', [
                'tab' => 'mylist',
                'keyword' => 'テスト',
            ]));

        $response->assertStatus(200);
        // キーワードがビューに渡されていることを確認
        $response->assertViewHas('keyword', 'テスト');
        // マイリスト内でも部分一致検索が効いていることを確認
        $response->assertViewHas('items', function ($items) use ($matchItem, $notMatchItem) {
            $ids = $items->pluck('id');
            return $ids->contains($matchItem->id) && !$ids->contains($notMatchItem->id);
        });
    }
}