<?php

namespace Tests\Feature\auth;

use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_home_view()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('welcome');
    }

    public function test_login_view()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function test_login()
    {
        $user = User::factory()->create();
        $credentials = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $response = $this->post('/login', $credentials);

        $response->assertStatus(302);
        $response->assertRedirect('/dashboard');
    }

    public function test_login_failed_wrong_email()
    {
        $this->get(route('login'));

        $user = User::factory()->create();
        $credentials = [
            'email' => $user->email . '2',
            'password' => 'password'
        ];

        $response = $this->post('/login', $credentials);

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function test_login_failed_wrong_password()
    {
        $this->get(route('login'));

        $user = User::factory()->create();
        $credentials = [
            'email' => $user->email,
            'password' => 'password2'
        ];

        $response = $this->post('/login', $credentials);

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function test_login_failed_null_email()
    {
        $this->get(route('login'));

        $credentials = [
            'password' => 'password'
        ];

        $response = $this->post('/login', $credentials);

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function test_login_failed_null_password()
    {
        $this->get(route('login'));

        $user = User::factory()->create();
        $credentials = [
            'email' => $user->email,
        ];

        $response = $this->post('/login', $credentials);

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }
}
