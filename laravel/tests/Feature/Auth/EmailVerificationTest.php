<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use App\Models\User;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 会員登録後、認証メールが送信される
     */
    public function test_verification_email_is_sent_after_registration(): void
    {
        Notification::fake();

        $this->post(route('register'), [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::where('email', 'test@example.com')->first();

        // 認証メールが送信されたことを確認
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    /**
     * メール認証誘導画面で「認証はこちらから」ボタンを押下すると認証メールが再送信される
     */
    public function test_verification_email_is_resent_when_button_is_clicked(): void
    {
        Notification::fake();

        // 未認証ユーザーを作成
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)
            ->post(route('verification.send'));

        // 認証メールが再送信されたことを確認
        Notification::assertSentTo($user, VerifyEmail::class);

        // 同じページに戻ることを確認
        $response->assertRedirect();
        $this->assertEquals(
            'verification-link-sent',
            session('status')
        );
    }

    /**
     * メール認証を完了するとプロフィール設定画面に遷移する
     */
    public function test_user_is_redirected_to_profile_edit_after_verification(): void
    {
        Event::fake();

        // 未認証ユーザーを作成
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        // 認証リンクを生成してアクセス
        $verificationUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        // Verifiedイベントが発火したことを確認
        Event::assertDispatched(Verified::class);

        // プロフィール設定画面にリダイレクトされることを確認
        $response->assertRedirect(route('profile.edit') . '?verified=1');
    }
}