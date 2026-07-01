<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Item;
use App\Models\User;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * コンビニ払いを選択すると正しく反映される
     */
    public function test_convenience_store_payment_is_stored_correctly(): void
    {
        $user = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => 'テスト住所',
            'building' => 'テストビル',
        ]);
        $item = Item::factory()->create();

        $this->actingAs($user)
            ->post(route('purchase.store', $item->id), [
                'payment_method' => 'convenience_store',
            ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'convenience_store',
        ]);
    }

    /**
     * カード支払いを選択すると正しく反映される
     */
    public function test_credit_card_payment_is_stored_correctly(): void
    {
        $user = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => 'テスト住所',
            'building' => 'テストビル',
        ]);
        $item = Item::factory()->create();

        $this->actingAs($user)
            ->post(route('purchase.store', $item->id), [
                'payment_method' => 'credit_card',
            ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'credit_card',
        ]);
    }

    /**
     * 支払い方法が選択されていない場合、バリデーションメッセージが表示される
     */
    public function test_payment_method_is_required(): void
    {
        $user = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => 'テスト住所',
            'building' => 'テストビル',
        ]);
        $item = Item::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('purchase.store', $item->id), [
                'payment_method' => '',
            ]);

        $response->assertSessionHasErrors([
            'payment_method' => '支払い方法を選択してください',
        ]);
    }
}