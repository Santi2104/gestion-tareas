<?php

namespace Tests\Feature\Api;

use App\Enums\PriorityLevel;
use App\Models\Priority;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PriorityApiTest extends TestCase
{
    use RefreshDatabase;

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
