<?php

namespace Tests\Feature\api\user;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_index()
    {
        $user = User::factory()->create();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->getJson('/api/users');

        $response->assertStatus(200);
    }
    public function test_index_failed_unauthenticated()
    {
        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->getJson('/api/users');

        $response->assertStatus(401);
    }

    public function test_store()
    {
        $user = User::factory()->create();

        $credentials = [
            'name' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'email' => $this->faker->email(),
            'password' => 'password'
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/users', $credentials);

        $response->assertStatus(201);
    }
    public function test_store_failed_unauthenticated()
    {
        $credentials = [
            'name' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'email' => $this->faker->email(),
            'password' => 'password'
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->postJson('/api/users', $credentials);

        $response->assertStatus(401);
    }
    public function test_store_failed_duplicate_email()
    {
        $user = User::factory()->create();

        $credentials = [
            'name' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'email' => $user->email,
            'password' => 'password'
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/users', $credentials);

        $response->assertStatus(422);
    }
    public function test_store_failed_empty_name()
    {
        $user = User::factory()->create();

        $credentials = [
            'name' => '',
            'email' => $this->faker->email(),
            'password' => 'password'
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/users', $credentials);

        $response->assertStatus(422);
    }
    public function test_store_failed_empty_email()
    {
        $user = User::factory()->create();

        $credentials = [
            'name' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'email' => '',
            'password' => 'password'
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/users', $credentials);

        $response->assertStatus(422);
    }
    public function test_store_failed_empty_password()
    {
        $user = User::factory()->create();

        $credentials = [
            'name' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'email' => $this->faker->email(),
            'password' => ''
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/users', $credentials);

        $response->assertStatus(422);
    }
    public function test_store_failed_null_name()
    {
        $user = User::factory()->create();

        $credentials = [
            'email' => $this->faker->email(),
            'password' => 'password'
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/users', $credentials);

        $response->assertStatus(422);
    }
    public function test_store_failed_null_email()
    {
        $user = User::factory()->create();

        $credentials = [
            'name' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'password' => 'password'
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/users', $credentials);

        $response->assertStatus(422);
    }
    public function test_store_failed_null_password()
    {
        $user = User::factory()->create();

        $credentials = [
            'name' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'email' => $this->faker->email(),
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/users', $credentials);

        $response->assertStatus(422);
    }

    public function test_show()
    {
        $user = User::factory()->create();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->getJson('/api/users/' . $user->id);

        $response->assertStatus(200);
    }
    public function test_show_failed_not_found()
    {
        $user = User::factory()->create();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->getJson('/api/users/a');

        $response->assertStatus(404);
    }

    public function test_update()
    {
        $user = User::factory()->create();

        $credentials = [
            'name' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'email' => $this->faker->email(),
            'password' => 'password2'
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/users/' . $user->id, $credentials);

        $response->assertStatus(200);
    }
    public function test_update_failed_unauthenticated()
    {
        $user = User::factory()->create();

        $credentials = [
            'name' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'email' => $this->faker->email(),
            'password' => 'password'
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->putJson('/api/users/' . $user->id, $credentials);

        $response->assertStatus(401);
    }
    public function test_update_duplicate_email()
    {
        $user = User::factory()->create();

        $credentials = [
            'name' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'email' => $user->email,
            'password' => 'password'
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/users/' . $user->id, $credentials);

        $response->assertStatus(200);
    }
    public function test_update_failed_duplicate_email()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $credentials = [
            'name' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'email' => $user->email,
            'password' => 'password'
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/users/' . $user2->id, $credentials);

        $response->assertStatus(422);
    }
    public function test_update_failed_empty_name()
    {
        $user = User::factory()->create();

        $credentials = [
            'name' => '',
            'email' => $this->faker->email(),
            'password' => 'password'
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/users/' . $user->id, $credentials);

        $response->assertStatus(422);
    }
    public function test_update_failed_empty_email()
    {
        $user = User::factory()->create();

        $credentials = [
            'name' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'email' => '',
            'password' => 'password'
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/users/' . $user->id, $credentials);

        $response->assertStatus(422);
    }
    public function test_update_failed_empty_password()
    {
        $user = User::factory()->create();

        $credentials = [
            'name' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'email' => $this->faker->email(),
            'password' => ''
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/users/' . $user->id, $credentials);

        $response->assertStatus(422);
    }
    public function test_update_failed_null_name()
    {
        $user = User::factory()->create();

        $credentials = [
            'email' => $this->faker->email(),
            'password' => 'password'
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/users/' . $user->id, $credentials);

        $response->assertStatus(422);
    }
    public function test_update_failed_null_email()
    {
        $user = User::factory()->create();

        $credentials = [
            'name' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'password' => 'password'
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/users/' . $user->id, $credentials);

        $response->assertStatus(422);
    }
    public function test_update_failed_null_password()
    {
        $user = User::factory()->create();

        $credentials = [
            'name' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'email' => $this->faker->email(),
        ];

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/users/' . $user->id, $credentials);

        $response->assertStatus(422);
    }

    public function test_delete()
    {
        $user = User::factory()->create();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->deleteJson('/api/users/' . $user->id);

        $response->assertStatus(204);
    }
    public function test_delete_failed_not_found()
    {
        $user = User::factory()->create();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->deleteJson('/api/users/a');

        $response->assertStatus(404);
    }
}
