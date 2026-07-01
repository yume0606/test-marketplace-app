<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Item;
use App\Models\Like;
use App\Models\User;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * いいねを押すといいねした商品として登録され、いいね数が増加する
     */
    public function test_user_can_like_an_item(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)
            ->post(route('items.like', $item->id));

        // DBにいいねが登録されていることを確認
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // いいね数が1になっていることを確認
        $this->assertEquals(1, $item->like()->count());
    }

    /**
     * いいね済みのアイコンはheart_pink.pngが表示される
     */
    public function test_liked_item_shows_filled_heart(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // 事前にいいねしておく
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('items.show', $item->id));

        $response->assertStatus(200);
        $response->assertSee('heart_pink.png');
    }

    /**
     * 再度いいねを押すといいねが解除され、いいね数が減少する
     */
    public function test_user_can_unlike_an_item(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // 事前にいいねしておく
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // もう一度いいねボタンを押す(解除)
        $this->actingAs($user)
            ->post(route('items.like', $item->id));

        // DBからいいねが削除されていることを確認
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // いいね数が0になっていることを確認
        $this->assertEquals(0, $item->like()->count());
    }
}