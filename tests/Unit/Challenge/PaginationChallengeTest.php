<?php

namespace Tests\Unit\Challenge;

use App\Http\Controllers\ChallengeController;
use App\Models\Challenge;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaginationChallengeTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /**
     * Test empty pagination
     */
    public function test_empty_pagination(): void
    {
        /**
         * @var ChallengeController $controller
         */
        $controller = app(ChallengeController::class);

        $pagination = $controller->index();

        $this->assertInstanceOf(LengthAwarePaginator::class, $pagination);

        $this->assertEquals(0, $pagination->total());
    }

    /**
     * Test pagination
     */
    public function test_pagination(): void
    {
        $count = $this->faker->numberBetween(1, 10);

        $challenges = Challenge::factory()->count($count)->create();

        $this->assertCount($count, $challenges);

        /**
         * @var ChallengeController $controller
         */
        $controller = app(ChallengeController::class);

        $pagination = $controller->index();

        $this->assertInstanceOf(LengthAwarePaginator::class, $pagination);

        $this->assertEquals($count, $pagination->total());
    }
}
