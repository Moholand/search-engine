<?php

namespace Tests\Feature;

use App\Traits\Test\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase, ProductFactory;

    /** @test */
    public function guestUserCanSuccessfullyRegister()
    {
        $requestData = [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->json('POST', 'api/register', $requestData);

        $response->assertOk()
            ->assertJson([
                'status' => true,
                'message' => 'Checkout successfully register.'
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
        ]);
    }

    /** @test */
    public function guestUserMustConfirmPassword()
    {
        $requestData = [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'wrong_password',
        ];

        $response = $this->json('POST', 'api/register', $requestData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);

        $this->assertDatabaseMissing('users', [
            'email' => 'john@example.com',
        ]);
    }
}
