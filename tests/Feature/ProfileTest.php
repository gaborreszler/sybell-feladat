<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function testProfilePageIsDisplayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profile')
        ;

        $response->assertOk();
    }

    public function testProfileInformationCanBeUpdated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ])
        ;

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile')
        ;

        $user->refresh();

        self::assertSame('Test User', $user->name);
        self::assertSame('test@example.com', $user->email);
        self::assertNull($user->email_verified_at);
    }

    public function testEmailVerificationStatusIsUnchangedWhenTheEmailAddressIsUnchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => $user->email,
            ])
        ;

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile')
        ;

        self::assertNotNull($user->refresh()->email_verified_at);
    }

    public function testUserCanDeleteTheirAccount(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ])
        ;

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/')
        ;

        $this->assertGuest();
        self::assertNull($user->fresh());
    }

    public function testCorrectPasswordMustBeProvidedToDeleteAccount(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ])
        ;

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('/profile')
        ;

        self::assertNotNull($user->fresh());
    }
}
