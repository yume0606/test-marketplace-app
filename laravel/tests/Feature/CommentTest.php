<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Item;
use App\Models\User;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ログイン済みのユーザーはコメントを送信できる
     */
    public function test_authenticated_user_can_post_comment(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('comments.store', $item->id), [
                'body' => 'テストコメントです',
            ]);

        // DBにコメントが保存されていることを確認
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'body' => 'テストコメントです',
        ]);

        // 商品詳細ページにリダイレクトされることを確認
        $response->assertRedirect(route('items.show', $item->id));
    }

    /**
     * ログイン前のユーザーはコメントを送信できない
     */
    public function test_guest_cannot_post_comment(): void
    {
        $item = Item::factory()->create();

        $response = $this->post(route('comments.store', $item->id), [
            'body' => 'テストコメントです',
        ]);

        // DBにコメントが保存されていないことを確認
        $this->assertDatabaseMissing('comments', [
            'body' => 'テストコメントです',
        ]);

        // ログインページにリダイレクトされることを確認
        $response->assertRedirect(route('login'));
    }

    /**
     * コメントが入力されていない場合、バリデーションメッセージが表示される
     */
    public function test_comment_body_is_required(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('comments.store', $item->id), [
                'body' => '',
            ]);

        $response->assertSessionHasErrors([
            'body' => 'コメントを入力してください',
        ]);
    }

    /**
     * コメントが255字以上の場合、バリデーションメッセージが表示される
     */
    public function test_comment_body_cannot_exceed_255_characters(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('comments.store', $item->id), [
                'body' => str_repeat('あ', 256),
            ]);

        $response->assertSessionHasErrors([
            'body' => 'コメントは255文字以内で入力してください',
        ]);
    }
}