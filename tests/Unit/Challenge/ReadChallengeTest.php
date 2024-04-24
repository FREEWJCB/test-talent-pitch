<?php

namespace Tests\Unit\Challenge;

use App\Http\Controllers\ChallengeController;
use App\Models\Challenge;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadChallengeTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /**
     * Test find model
     */
    public function test_read(): void
    {
        /**
         * @var ChallengeController $controller
         */
        $controller = app(ChallengeController::class);

        $challenge = Challenge::factory()->create();

        $this->assertInstanceOf(Challenge::class, $challenge);

        $foundChallenge = $controller->read($challenge->getKey());

        $this->assertInstanceOf(Challenge::class, $foundChallenge);

        $this->assertTrue($challenge->is($foundChallenge));
    }

    /**
     * Test find missing model
     */
    public function test_read_404(): void
    {
        $this->expectException(ModelNotFoundException::class);

        /**
         * @var ChallengeController $controller
         */
        $controller = app(ChallengeController::class);

        $controller->read($this->faker->randomNumber());
    }
}