<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Item;
use App\Models\User;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 送付先住所変更画面で登録した住所が商品購入画面に反映されている
     */
    public function test_updated_address_is_reflected_on_purchase_page(): void
    {
        $user = User::factory()->create([
            'postal_code' => '111-1111',
            'address' => '変更前の住所',
            'building' => '変更前ビル',
        ]);
        $item = Item::factory()->create();

        // 住所を変更する
        $this->actingAs($user)
            ->put(route('purchase.address.update', $item->id), [
                'postal_code' => '123-4567',
                'address' => '変更後の住所',
                'building' => '変更後ビル',
            ]);

        // ユーザーの住所がDBに反映されていることを確認
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'postal_code' => '123-4567',
            'address' => '変更後の住所',
            'building' => '変更後ビル',
        ]);

        // 購入画面を開いて、変更後の住所が表示されていることを確認
        $response = $this->actingAs($user)
            ->get(route('items.purchase', $item->id));

        $response->assertStatus(200);
        $response->assertSee('123-4567');
        $response->assertSee('変更後の住所');
    }

    /**
     * 購入した商品に送付先住所が紐づいて登録される
     */
    public function test_order_is_stored_with_correct_address(): void
    {
        $user = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => 'テスト住所',
            'building' => 'テストビル',
        ]);
        $item = Item::factory()->create();

        // 住所を変更する
        $this->actingAs($user)
            ->put(route('purchase.address.update', $item->id), [
                'postal_code' => '987-6543',
                'address' => '購入時の住所',
                'building' => '購入時ビル',
            ]);

        // 商品を購入する
        $this->actingAs($user)
            ->post(route('purchase.store', $item->id), [
                'payment_method' => 'credit_card',
            ]);

        // 注文に住所が紐づいていることを確認
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'postal_code' => '987-6543',
            'address' => '購入時の住所',
            'building' => '購入時ビル',
        ]);
    }
}