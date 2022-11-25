<?php

namespace Tests\Feature\api\auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_token_create()
    {
        $user = User::factory()->create();
        $credentials = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->postJson('/api/tokens/create', $credentials);

        $response->assertStatus(200);
    }

    public function test_token_create_failed_wrong_email()
    {
        $user = User::factory()->create();
        $credentials = [
            'email' => $user->email . '2',
            'password' => 'password'
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->postJson('/api/tokens/create', $credentials);

        $response->assertStatus(422);
    }

    public function test_token_create_failed_wrong_password()
    {
        $user = User::factory()->create();
        $credentials = [
            'email' => $user->email,
            'password' => 'password2'
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->postJson('/api/tokens/create', $credentials);

        $response->assertStatus(401);
    }

    public function test_token_create_failed_empty_email()
    {
        $credentials = [
            'email' => '',
            'password' => 'password'
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->postJson('/api/tokens/create', $credentials);

        $response->assertStatus(422);
    }

    public function test_token_create_failed_empty_password()
    {
        $user = User::factory()->create();
        $credentials = [
            'email' => $user->email,
            'password' => ''
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->postJson('/api/tokens/create', $credentials);

        $response->assertStatus(422);
    }

    public function test_token_create_failed_null_email()
    {
        $credentials = [
            'password' => 'password'
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->postJson('/api/tokens/create', $credentials);

        $response->assertStatus(422);
    }

    public function test_token_create_failed_null_password()
    {
        $user = User::factory()->create();
        $credentials = [
            'email' => $user->email,
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->postJson('/api/tokens/create', $credentials);

        $response->assertStatus(422);
    }

    public function test_token_create_failed_empty_email_and_password()
    {
        $credentials = [
            'email' => '',
            'password' => ''
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->postJson('/api/tokens/create', $credentials);

        $response->assertStatus(422);
    }

    public function test_token_create_failed_null_email_and_password()
    {
        $credentials = [];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->postJson('/api/tokens/create', $credentials);

        $response->assertStatus(422);
    }

    public function test_user()
    {
        $user = User::factory()->create();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->getJson('/api/users');

        $response->assertStatus(200);
    }

    public function test_user_failed()
    {
        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->getJson('/api/users');

        $response->assertStatus(401);
    }
}
