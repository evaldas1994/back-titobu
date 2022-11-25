<?php

namespace Tests\Feature\api\category;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Arr;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private function getData(): array
    {
        return [
            'name' => fake()->words(2, true),
            'balance' => fake()->randomFloat(2,100,300),
            'type' => Arr::random(Category::getTypes()),
        ];
    }

    public function test_index()
    {
        $user = User::factory()->create();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->getJson('/api/categories');

        $response->assertStatus(200);
    }
    public function test_index_failed_unauthenticated()
    {
        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->getJson('/api/categories');

        $response->assertStatus(401);
    }

    public function test_store()
    {
        $user = User::factory()->create();
        $data = $this->getData();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/categories', $data);

        $response->assertStatus(201);
    }
    public function test_store_0_balance()
    {
        $user = User::factory()->create();
        $data = $this->getData();
        $data['balance'] = 0;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/categories', $data);

        $response->assertStatus(201);
    }
    public function test_store_failed_unauthenticated()
    {
        $data = $this->getData();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->postJson('/api/categories', $data);

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
            ->postJson('/api/categories', $data);

        $response->assertStatus(422);
    }
    public function test_store_failed_empty_balance_type_in()
    {
        $user = User::factory()->create();
        $data = $this->getData();
        $data['balance'] = '';
        $data['type'] = Category::TYPE_IN;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/categories', $data);

        $response->assertStatus(422);
    }
    public function test_store_failed_empty_balance_type_out()
    {
        $user = User::factory()->create();
        $data = $this->getData();
        $data['balance'] = '';
        $data['type'] = Category::TYPE_OUT;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/categories', $data);

        $response->assertStatus(422);
    }
    public function test_store_failed_empty_type()
    {
        $user = User::factory()->create();
        $data = $this->getData();
        $data['type'] = '';

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/categories', $data);

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
            ->postJson('/api/categories', $data);

        $response->assertStatus(422);
    }
    public function test_store_failed_null_balance_type_in()
    {
        $user = User::factory()->create();

        $data = $this->getData();
        $data['balance'] = null;
        $data['type'] = Category::TYPE_IN;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/categories', $data);

        $response->assertStatus(422);
    }
    public function test_store_failed_null_balance_type_out()
    {
        $user = User::factory()->create();

        $data = $this->getData();
        $data['balance'] = null;
        $data['type'] = Category::TYPE_OUT;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/categories', $data);

        $response->assertStatus(422);
    }
    public function test_store_failed_null_type()
    {
        $user = User::factory()->create();

        $data = $this->getData();
        $data['type'] = null;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/categories', $data);

        $response->assertStatus(422);
    }
    public function test_store_failed_exists_type()
    {
        $user = User::factory()->create();
        $data = $this->getData();
        $data['type'] = 'abc';

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->postJson('/api/categories', $data);

        $response->assertStatus(422);
    }

    public function test_show()
    {
        $user = User::factory()->create();
        Account::factory(10)->create(['user_id' => $user->id]);
        $category = Category::factory()->create(['user_id' => $user->id]);

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->getJson('/api/categories/' . $category->id);

        $response->assertStatus(200);
    }
    public function test_show_failed_unauthenticated()
    {
        $user = User::factory()->create();
        Account::factory(10)->create(['user_id' => $user->id]);
        $category = Category::factory()->create(['user_id' => $user->id]);

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->getJson('/api/categories/' . $category->id);

        $response->assertStatus(401);
    }
    public function test_show_failed_not_found()
    {
        $user = User::factory()->create();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->getJson('/api/categories/a');

        $response->assertStatus(404);
    }

    public function test_update()
    {
        $user = User::factory()->create();
        Account::factory(10)->create(['user_id' => $user->id]);
        $category = Category::factory()->create(['user_id' => $user->id]);

        $data = $this->getData();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/categories/' . $category->id, $data);

        $response->assertStatus(200);
    }
    public function test_update_0_balance()
    {
        $user = User::factory()->create();
        Account::factory(10)->create(['user_id' => $user->id]);
        $category = Category::factory()->create(['user_id' => $user->id]);

        $data = $this->getData();
        $data['balance'] = 0;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/categories/' . $category->id, $data);

        $response->assertStatus(200);
    }
    public function test_update_failed_unauthenticated()
    {
        $user = User::factory()->create();
        Account::factory(10)->create(['user_id' => $user->id]);
        $category = Category::factory()->create(['user_id' => $user->id]);

        $data = $this->getData();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->putJson('/api/categories/' . $category->id, $data);

        $response->assertStatus(401);
    }
    public function test_update_failed_empty_name()
    {
        $user = User::factory()->create();
        Account::factory(10)->create(['user_id' => $user->id]);
        $category = Category::factory()->create(['user_id' => $user->id]);

        $data = $this->getData();
        $data['name'] = '';

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/categories/' . $category->id, $data);

        $response->assertStatus(422);
    }
    public function test_update_failed_empty_balance_type_in()
    {
        $user = User::factory()->create();
        Account::factory(10)->create(['user_id' => $user->id]);
        $category = Category::factory()->create(['user_id' => $user->id]);

        $data = $this->getData();
        $data['balance'] = '';
        $data['type'] = Category::TYPE_IN;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/categories/' . $category->id, $data);

        $response->assertStatus(422);
    }
    public function test_update_failed_empty_balance_type_out()
    {
        $user = User::factory()->create();
        Account::factory(10)->create(['user_id' => $user->id]);
        $category = Category::factory()->create(['user_id' => $user->id]);

        $data = $this->getData();
        $data['balance'] = '';
        $data['type'] = Category::TYPE_OUT;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/categories/' . $category->id, $data);

        $response->assertStatus(422);
    }
    public function test_update_failed_empty_type()
    {
        $user = User::factory()->create();
        Account::factory(10)->create(['user_id' => $user->id]);
        $category = Category::factory()->create(['user_id' => $user->id]);

        $data = $this->getData();
        $data['type'] = '';

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/categories/' . $category->id, $data);

        $response->assertStatus(422);
    }
    public function test_update_failed_null_name()
    {
        $user = User::factory()->create();
        Account::factory(10)->create(['user_id' => $user->id]);
        $category = Category::factory()->create(['user_id' => $user->id]);

        $data = $this->getData();
        $data['name'] = null;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/categories/' . $category->id, $data);

        $response->assertStatus(422);
    }
    public function test_update_failed_null_balance_type_in()
    {
        $user = User::factory()->create();
        Account::factory(10)->create(['user_id' => $user->id]);
        $category = Category::factory()->create(['user_id' => $user->id]);

        $data = $this->getData();
        $data['balance'] = null;
        $data['type'] = Category::TYPE_IN;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/categories/' . $category->id, $data);

        $response->assertStatus(422);
    }
    public function test_update_failed_null_balance_type_out()
    {
        $user = User::factory()->create();
        Account::factory(10)->create(['user_id' => $user->id]);
        $category = Category::factory()->create(['user_id' => $user->id]);

        $data = $this->getData();
        $data['balance'] = null;
        $data['type'] = Category::TYPE_OUT;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/categories/' . $category->id, $data);

        $response->assertStatus(422);
    }
    public function test_update_failed_null_type()
    {
        $user = User::factory()->create();
        Account::factory(10)->create(['user_id' => $user->id]);
        $category = Category::factory()->create(['user_id' => $user->id]);

        $data = $this->getData();
        $data['type'] = null;

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/categories/' . $category->id, $data);

        $response->assertStatus(422);
    }
    public function test_update_failed_exists_type()
    {
        $user = User::factory()->create();
        Account::factory(10)->create(['user_id' => $user->id]);
        $category = Category::factory()->create(['user_id' => $user->id]);

        $data = $this->getData();
        $data['type'] = 'abc';

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->putJson('/api/categories/' . $category->id, $data);

        $response->assertStatus(422);
    }

    public function test_delete()
    {
        $user = User::factory()->create();
        Account::factory(10)->create(['user_id' => $user->id]);
        $category = Category::factory()->create(['user_id' => $user->id]);

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->deleteJson('/api/categories/' . $category->id);

        $response->assertStatus(204);
    }
    public function test_delete_failed_unauthenticated()
    {
        $user = User::factory()->create();
        Account::factory(10)->create(['user_id' => $user->id]);
        $category = Category::factory()->create(['user_id' => $user->id]);

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->deleteJson('/api/categories/' . $category->id);

        $response->assertStatus(401);
    }
    public function test_delete_failed_not_found()
    {
        $user = User::factory()->create();
        Account::factory(10)->create(['user_id' => $user->id]);
        $category = Category::factory()->create(['user_id' => $user->id]);

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->deleteJson('/api/categories/a');

        $response->assertStatus(404);
    }
}
