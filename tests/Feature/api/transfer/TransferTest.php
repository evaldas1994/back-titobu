<?php

namespace Tests\Feature\api\transfer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Category;
use App\Models\Transfer;
use App\Models\Account;
use App\Models\User;
use Tests\TestCase;

class TransferTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private function getData(): array
    {
        $user = User::factory()->create();
        $account = Account::factory()->create(['user_id' => $user->id]);
        $category = Category::factory()->create(['user_id' => $user->id]);

        return [
            'name' => $this->faker->word,
            'amount' => $this->faker->randomFloat(2, 0.01, 1000000),
            'category_id' => $category->id,
            'account_id' => $account->id
        ];
    }

    public function test_index()
    {
        $user = User::factory()->create();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->getJson('/api/transfers');

        $response->assertStatus(200);
    }
    public function test_index_failed_unauthenticated()
    {
        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->getJson('/api/transfers');

        $response->assertStatus(401);
    }

    public function test_store()
    {
        $user = User::factory()->create();

        $data = $this->getData();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/transfers', $data);

        $response->assertStatus(201);
    }
    public function test_store_failed_unauthenticated()
    {
        $user = User::factory()->create();

        $data = $this->getData();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->postJson('/api/transfers', $data);

        $response->assertStatus(401);
    }
    public function test_store_failed_empty_name()
    {
        $user = User::factory()->create();

        $data = $this->getData();
        $data['name'] = '';

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/transfers', $data);

        $response->assertStatus(422);
    }
    public function test_store_failed_empty_amount()
    {
        $user = User::factory()->create();

        $data = $this->getData();
        $data['amount'] = '';

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/transfers', $data);

        $response->assertStatus(422);
    }
    public function test_store_failed_empty_category_id()
    {
        $user = User::factory()->create();

        $data = $this->getData();
        $data['category_id'] = '';

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/transfers', $data);

        $response->assertStatus(422);
    }
    public function test_store_failed_empty_account_id()
    {
        $user = User::factory()->create();

        $data = $this->getData();
        $data['account_id'] = '';

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/transfers', $data);

        $response->assertStatus(422);
    }
    public function test_store_failed_null_name()
    {
        $user = User::factory()->create();

        $data = $this->getData();
        $data['name'] = null;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/transfers', $data);

        $response->assertStatus(422);
    }
    public function test_store_failed_null_amount()
    {
        $user = User::factory()->create();

        $data = $this->getData();
        $data['amount'] = null;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/transfers', $data);

        $response->assertStatus(422);
    }
    public function test_store_failed_null_category_id()
    {
        $user = User::factory()->create();

        $data = $this->getData();
        $data['category_id'] = null;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/transfers', $data);

        $response->assertStatus(422);
    }
    public function test_store_failed_null_account_id()
    {
        $user = User::factory()->create();

        $data = $this->getData();
        $data['account_id'] = null;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/transfers', $data);

        $response->assertStatus(422);
    }
    public function test_store_failed_0_amount()
    {
        $user = User::factory()->create();

        $data = $this->getData();
        $data['amount'] = 0;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/transfers', $data);

        $response->assertStatus(422);
    }
    public function test_store_failed_exists_category_id()
    {
        $user = User::factory()->create();

        $data = $this->getData();
        $data['category_id'] = 2;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/transfers', $data);

        $response->assertStatus(422);
    }
    public function test_store_failed_exists_account_id()
    {
        $user = User::factory()->create();

        $data = $this->getData();
        $data['account_id'] = 2;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/transfers', $data);

        $response->assertStatus(422);
    }

    public function test_show()
    {
        $user = User::factory()->create();
        $data = $this->getData();
        $transfer = Transfer::factory()->create();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->getJson('/api/transfers/' . $transfer->id);

        $response->assertStatus(200);
    }
    public function test_show_failed_unauthenticated()
    {
        $user = User::factory()->create();
        $data = $this->getData();
        $transfer = Transfer::factory()->create();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->getJson('/api/transfers/' . $transfer->id);

        $response->assertStatus(401);
    }
    public function test_show_failed_not_found()
    {
        $user = User::factory()->create();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->getJson('/api/transfers/a');

        $response->assertStatus(404);
    }

    public function test_update()
    {
        $user = User::factory()->create();
        $data = $this->getData();
        $transfer = Transfer::factory()->create();

        $data = $this->getData();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/transfers/' . $transfer->id, $data);

        $response->assertStatus(200);
    }
    public function test_update_failed_unauthenticated()
    {
        $user = User::factory()->create();
        $data = $this->getData();
        $transfer = Transfer::factory()->create();

        $data = $this->getData();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->putJson('/api/transfers/' . $transfer->id, $data);

        $response->assertStatus(401);
    }
    public function test_update_failed_empty_name()
    {
        $user = User::factory()->create();
        $data = $this->getData();
        $transfer = Transfer::factory()->create();

        $data = $this->getData();
        $data['name'] = '';

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/transfers/' . $transfer->id, $data);

        $response->assertStatus(422);
    }
    public function test_update_failed_empty_amount()
    {
        $user = User::factory()->create();
        $data = $this->getData();
        $transfer = Transfer::factory()->create();

        $data = $this->getData();
        $data['amount'] = '';

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/transfers/' . $transfer->id, $data);

        $response->assertStatus(422);
    }
    public function test_update_failed_empty_category_id()
    {
        $user = User::factory()->create();
        $data = $this->getData();
        $transfer = Transfer::factory()->create();

        $data = $this->getData();
        $data['category_id'] = '';

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/transfers/' . $transfer->id, $data);

        $response->assertStatus(422);
    }
    public function test_update_failed_empty_account_id()
    {
        $user = User::factory()->create();
        $data = $this->getData();
        $transfer = Transfer::factory()->create();

        $data = $this->getData();
        $data['account_id'] = '';

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/transfers/' . $transfer->id, $data);

        $response->assertStatus(422);
    }
    public function test_update_failed_null_name()
    {
        $user = User::factory()->create();
        $data = $this->getData();
        $transfer = Transfer::factory()->create();

        $data = $this->getData();
        $data['name'] = null;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/transfers/' . $transfer->id, $data);

        $response->assertStatus(422);
    }
    public function test_update_failed_null_amount()
    {
        $user = User::factory()->create();
        $data = $this->getData();
        $transfer = Transfer::factory()->create();

        $data = $this->getData();
        $data['amount'] = null;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/transfers/' . $transfer->id, $data);

        $response->assertStatus(422);
    }
    public function test_update_failed_null_category_id()
    {
        $user = User::factory()->create();
        $data = $this->getData();
        $transfer = Transfer::factory()->create();

        $data = $this->getData();
        $data['category_id'] = null;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/transfers/' . $transfer->id, $data);

        $response->assertStatus(422);
    }
    public function test_update_failed_null_account_id()
    {
        $user = User::factory()->create();
        $data = $this->getData();
        $transfer = Transfer::factory()->create();

        $data = $this->getData();
        $data['account_id'] = null;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/transfers/' . $transfer->id, $data);

        $response->assertStatus(422);
    }
    public function test_update_failed_0_amount()
    {
        $user = User::factory()->create();
        $data = $this->getData();
        $transfer = Transfer::factory()->create();

        $data = $this->getData();
        $data['amount'] = 0;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/transfers/' . $transfer->id, $data);

        $response->assertStatus(422);
    }
    public function test_update_failed_exists_category_id()
    {
        $user = User::factory()->create();
        $data = $this->getData();
        $transfer = Transfer::factory()->create();

        $data = $this->getData();
        $data['category_id'] = 2;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/transfers/' . $transfer->id, $data);

        $response->assertStatus(422);
    }
    public function test_update_failed_exists_account_id()
    {
        $user = User::factory()->create();
        $data = $this->getData();
        $transfer = Transfer::factory()->create();

        $data = $this->getData();
        $data['account_id'] = 2;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/transfers/' . $transfer->id, $data);

        $response->assertStatus(422);
    }

    public function test_delete()
    {
        $user = User::factory()->create();
        $data = $this->getData();
        $transfer = Transfer::factory()->create();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->deleteJson('/api/transfers/' . $transfer->id);

        $response->assertStatus(204);
    }
    public function test_delete_failed_unauthenticated()
    {
        $user = User::factory()->create();
        $data = $this->getData();
        $transfer = Transfer::factory()->create();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->deleteJson('/api/transfers/' . $transfer->id);

        $response->assertStatus(401);
    }
    public function test_delete_failed_not_found()
    {
        $user = User::factory()->create();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->deleteJson('/api/transfers/a');

        $response->assertStatus(404);
    }
}
