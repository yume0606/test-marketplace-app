<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Item;
use App\Models\User;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 「購入する」ボタンを押すと購入が完了する
     */
    public function test_user_can_purchase_an_item(): void
    {
        $user = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => 'テスト住所',
            'building' => 'テストビル',
        ]);
        $item = Item::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('purchase.store', $item->id), [
                'payment_method' => 'credit_card',
            ]);

        // DBに注文が保存されていることを確認
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'credit_card',
        ]);

        // 商品一覧にリダイレクトされることを確認
        $response->assertRedirect(route('items.index'));
    }

    /**
     * 購入した商品は商品一覧画面にて「Sold」と表示される
     */
    public function test_purchased_item_is_displayed_with_sold_label(): void
    {
        $buyer = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => 'テスト住所',
            'building' => 'テストビル',
        ]);
        $item = Item::factory()->create();

        // 購入する
        $this->actingAs($buyer)
            ->post(route('purchase.store', $item->id), [
                'payment_method' => 'credit_card',
            ]);

        // 商品一覧を表示する
        $response = $this->get(route('items.index'));

        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    /**
     * 「プロフィール/購入した商品一覧」に追加されている
     */
    public function test_purchased_item_is_displayed_in_profile(): void
    {
        $buyer = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => 'テスト住所',
            'building' => 'テストビル',
        ]);
        $item = Item::factory()->create(['name' => 'テスト商品']);

        // 購入する
        $this->actingAs($buyer)
            ->post(route('purchase.store', $item->id), [
                'payment_method' => 'credit_card',
            ]);

        // プロフィールの購入済み商品一覧を確認
        $response = $this->actingAs($buyer)
            ->get(route('mypage', ['tab' => 'buy']));

        $response->assertStatus(200);
        $response->assertViewHas('items', function ($items) use ($item) {
            return $items->pluck('id')->contains($item->id);
        });
    }
}