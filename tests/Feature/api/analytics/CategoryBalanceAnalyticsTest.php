<?php

namespace Tests\Feature\api\analytics;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;

class CategoryBalanceAnalyticsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_invoke()
    {
        $user = User::factory()->create();

        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->actingAs($user)
            ->getJson('/api/analytics/out-category-balance');

        $response->assertStatus(200);
    }
    public function test_index_failed_unauthenticated()
    {
        $response = $this
            ->withHeaders($this->getApiHeaders())
            ->getJson('/api/analytics/out-category-balance');

        $response->assertStatus(401);
    }
}
