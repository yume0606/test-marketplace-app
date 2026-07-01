<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ログアウトができる
     */
    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        // 事前にログインしておく
        $this->actingAs($user);

        $response = $this->post(route('logout'));

        // ログアウトされている(認証が外れている)ことを確認
        $this->assertGuest();
    }
}