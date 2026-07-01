<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class UserProfileEditTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 変更項目が初期値として過去設定されていること
     */
    public function test_profile_edit_form_displays_current_values(): void
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'profile_image' => 'profile_image/test.jpg',
            'postal_code' => '123-4567',
            'address' => 'テスト住所',
            'building' => 'テストビル',
        ]);

        $response = $this->actingAs($user)
            ->get(route('profile.edit'));

        $response->assertStatus(200);
        // ユーザー名が初期値として表示されていることを確認
        $response->assertSee('テストユーザー');
        // プロフィール画像が初期値として表示されていることを確認
        $response->assertSee('profile_image/test.jpg');
        // 郵便番号が初期値として表示されていることを確認
        $response->assertSee('123-4567');
        // 住所が初期値として表示されていることを確認
        $response->assertSee('テスト住所');
        // 建物名が初期値として表示されていることを確認
        $response->assertSee('テストビル');
    }

    /**
     * プロフィール情報を更新できる
     */
    public function test_user_can_update_profile(): void
    {
        $user = User::factory()->create([
            'name' => '変更前ユーザー',
            'postal_code' => '111-1111',
            'address' => '変更前住所',
            'building' => '変更前ビル',
        ]);

        $response = $this->actingAs($user)
            ->put(route('profile.update'), [
                'name' => '変更後ユーザー',
                'postal_code' => '987-6543',
                'address' => '変更後住所',
                'building' => '変更後ビル',
            ]);

        // DBに変更後の情報が保存されていることを確認
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => '変更後ユーザー',
            'postal_code' => '987-6543',
            'address' => '変更後住所',
            'building' => '変更後ビル',
        ]);

        // マイページにリダイレクトされることを確認
        $response->assertRedirect(route('mypage'));
    }
}