<?php

namespace Tests\Feature\api\account;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private function getData($user = null): array
    {
        $user = $user ?? new User();

        return [
            'name' => $this->faker->word,
            'user_id' => $user->id,
            'balance' => $this->faker->randomFloat(2, 0.01, 1000000)
        ];
    }

    public function test_index()
    {
        $user = User::factory()->create();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->getJson('/api/accounts');

        $response->assertStatus(200);
    }
    public function test_index_failed_unauthenticated()
    {
        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->getJson('/api/accounts');

        $response->assertStatus(401);
    }

    public function test_store()
    {
        $user = User::factory()->create();
        $data = $this->getData($user);

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/accounts', $data);

        $response->assertStatus(201);
    }
    public function test_store_0_balance()
    {
        $user = User::factory()->create();

        $data = $this->getData($user);
        $data['balance'] = 0;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/accounts', $data);

        $response->assertStatus(201);
    }
    public function test_store_empty_user_id()
    {
        $user = User::factory()->create();

        $data = $this->getData($user);
        $data['user_id'] = '';

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/accounts', $data);

        $response->assertStatus(201);
    }
    public function test_store_null_user_id()
    {
        $user = User::factory()->create();

        $data = $this->getData($user);
        $data['user_id'] = null;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/accounts', $data);

        $response->assertStatus(201);
    }
    public function test_store_failed_unauthenticated()
    {
        $user = User::factory()->create();

        $data = $this->getData($user);

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->postJson('/api/accounts', $data);

        $response->assertStatus(401);
    }
    public function test_store_failed_empty_name()
    {
        $user = User::factory()->create();
        $data = $this->getData($user);
        $data['name'] = '';

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/accounts', $data);

        $response->assertStatus(422);
    }
    public function test_store_failed_empty_balance()
    {
        $user = User::factory()->create();

        $data = $this->getData($user);
        $data['balance'] = '';

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/accounts', $data);

        $response->assertStatus(422);
    }
    public function test_store_failed_null_name()
    {
        $user = User::factory()->create();

        $data = $this->getData($user);
        $data['name'] = null;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/accounts', $data);

        $response->assertStatus(422);
    }
    public function test_store_failed_null_balance()
    {
        $user = User::factory()->create();

        $data = $this->getData($user);
        $data['balance'] = null;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/accounts', $data);

        $response->assertStatus(422);
    }

    public function test_show()
    {
        $user = User::factory()->create();
        $account = Account::factory()->create();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->getJson('/api/accounts/' . $account->id);

        $response->assertStatus(200);
    }
    public function test_show_failed_unauthenticated()
    {
        $user = User::factory()->create();
        $account = Account::factory()->create();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->getJson('/api/accounts/' . $account->id);

        $response->assertStatus(401);
    }
    public function test_show_failed_not_found()
    {
        $user = User::factory()->create();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->getJson('/api/accounts/a');

        $response->assertStatus(404);
    }

    public function test_update()
    {
        $user = User::factory()->create();
        $account = Account::factory()->create();

        $data = $this->getData($user);

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/accounts/' . $account->id, $data);

        $response->assertStatus(200);
    }
    public function test_update_0_balance()
    {
        $user = User::factory()->create();
        $account = Account::factory()->create();

        $data = $this->getData($user);
        $data['balance'] = 0;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/accounts/' . $account->id, $data);

        $response->assertStatus(200);
    }
    public function test_update_empty_user_id()
    {
        $user = User::factory()->create();
        $account = Account::factory()->create();

        $data = $this->getData($user);
        $data['user_id'] = '';

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/accounts/' . $account->id, $data);

        $response->assertStatus(200);
    }
    public function test_update_null_user_id()
    {
        $user = User::factory()->create();
        $account = Account::factory()->create();

        $data = $this->getData($user);
        $data['user_id'] = null;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/accounts/' . $account->id, $data);

        $response->assertStatus(200);
    }
    public function test_update_failed_unauthenticated()
    {
        $user = User::factory()->create();
        $account = Account::factory()->create();

        $data = $this->getData($user);

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->putJson('/api/accounts/' . $account->id, $data);

        $response->assertStatus(401);
    }
    public function test_update_failed_empty_name()
    {
        $user = User::factory()->create();
        $account = Account::factory()->create();

        $data = $this->getData($user);
        $data['name'] = '';

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/accounts/' . $account->id, $data);

        $response->assertStatus(422);
    }
    public function test_update_failed_empty_balance()
    {
        $user = User::factory()->create();
        $account = Account::factory()->create();

        $data = $this->getData($user);
        $data['balance'] = '';

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/accounts/' . $account->id, $data);

        $response->assertStatus(422);
    }
    public function test_update_failed_null_name()
    {
        $user = User::factory()->create();
        $account = Account::factory()->create();

        $data = $this->getData($user);
        $data['name'] = null;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/accounts/' . $account->id, $data);

        $response->assertStatus(422);
    }
    public function test_update_failed_null_balance()
    {
        $user = User::factory()->create();
        $account = Account::factory()->create();

        $data = $this->getData($user);
        $data['balance'] = null;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/accounts/' . $account->id, $data);

        $response->assertStatus(422);
    }

    public function test_delete()
    {
        $user = User::factory()->create();
        $account = Account::factory()->create();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->deleteJson('/api/accounts/' . $account->id);

        $response->assertStatus(204);
    }
    public function test_delete_failed_unauthenticated()
    {
        $user = User::factory()->create();
        $account = Account::factory()->create();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->deleteJson('/api/accounts/' . $account->id);

        $response->assertStatus(401);
    }
    public function test_delete_failed_not_found()
    {
        $user = User::factory()->create();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->deleteJson('/api/accounts/a');

        $response->assertStatus(404);
    }
}
