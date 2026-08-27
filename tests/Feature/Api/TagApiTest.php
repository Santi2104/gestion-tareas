<?php

namespace Tests\Feature\Api;

use App\Enums\TagName;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    public function test_can_list_all_tags(): void
    {
        Tag::factory()->create(['name' => TagName::Dev]);
        Tag::factory()->create(['name' => TagName::Qa]);

        $response = $this->getJson(route('tags.index'));

        $response->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name'],
                ],
            ]);
    }
}
