<?php

namespace Tests\Feature\Api;

use App\Enums\PriorityLevel;
use App\Models\Priority;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PriorityApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    public function test_can_list_all_priorities(): void
    {
        Priority::factory()->create(['name' => PriorityLevel::Low]);
        Priority::factory()->create(['name' => PriorityLevel::Medium]);

        $response = $this->getJson(route('priorities.index'));

        $response->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name'],
                ],
            ]);
    }
}
