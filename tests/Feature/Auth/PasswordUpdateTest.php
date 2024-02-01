<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class PasswordUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testPasswordCanBeUpdated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->put('/password', [
                'current_password' => 'password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ])
        ;

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile')
        ;

        self::assertTrue(Hash::check('new-password', $user->refresh()->password));
    }

    public function testCorrectPasswordMustBeProvidedToUpdatePassword(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->put('/password', [
                'current_password' => 'wrong-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ])
        ;

        $response
            ->assertSessionHasErrorsIn('updatePassword', 'current_password')
            ->assertRedirect('/profile');
    }
}
