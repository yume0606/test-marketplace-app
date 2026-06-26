<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 名前が入力されていない場合、バリデーションメッセージが表示される
     */
    public function test_name_is_required(): void
    {
        $response = $this->post(route('register'), [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors([
            'name' => 'お名前を入力してください',
        ]);
    }

    /**
     * メールアドレスが入力されていない場合、バリデーションメッセージが表示される
     */
    public function test_email_is_required(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'テストユーザー',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
    }

    /**
     * パスワードが入力されていない場合、バリデーションメッセージが表示される
     */
    public function test_password_is_required(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);
    }

    /**
     * パスワードが7文字以下の場合、バリデーションメッセージが表示される
     */
    public function test_password_must_be_at_least_8_characters(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => '1234567',
            'password_confirmation' => '1234567',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードは8文字以上で入力してください',
        ]);
    }

    /**
     * パスワードが確認用パスワードと一致しない場合、バリデーションメッセージが表示される
     */
    public function test_password_confirmation_must_match(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'differentpassword',
        ]);

        $response->assertSessionHasErrors([
            'password_confirmation' => 'パスワードと一致しません',
        ]);
    }

    /**
     * 全ての項目が入力されている場合、会員情報が登録され、プロフィール設定画面に遷移される
     */
    public function test_user_can_register_with_valid_data(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // ユーザーがDBに登録されていることを確認
        $this->assertDatabaseHas('users', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
        ]);

        // プロフィール設定画面にリダイレクトされていることを確認
        $response->assertRedirect(route('profile.edit'));
    }
}