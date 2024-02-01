<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testRegistrationScreenCanBeRendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function testNewUsersCanRegister(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
