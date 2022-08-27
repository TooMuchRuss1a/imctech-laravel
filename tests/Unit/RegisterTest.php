<?php

namespace Tests\Unit;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function testRegister()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $user = User::factory()->make();
        $this->call('POST', '/register', [
            'email' => $user->email,
            'name' => $user->name,
            'password' => $user->password,
            'password_confirmation' => $user->password,
            'agroup' => $user->agroup,
            'vk' => 'https://vk.com/id631723734'
        ])->assertRedirect('/email/verify');

        $user = User::where(['email' => $user->email])->first();
        $this->assertNotNull($user);
        $this->assertNotNull($user->socials);
        $user->socials()->delete();
        $user->delete();
    }
}
