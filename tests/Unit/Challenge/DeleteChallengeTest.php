<?php

namespace Tests\Unit\Challenge;

use App\Http\Controllers\ChallengeController;
use App\Models\Challenge;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class DeleteChallengeTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /**
     * Test delete model
     */
    public function test_delete(): void
    {
        /**
         * @var ChallengeController $controller
         */
        $controller = app(ChallengeController::class);

        $challenge = Challenge::factory()->create();

        $this->assertInstanceOf(Challenge::class, $challenge);

        /**
         * @var JsonResponse $deleteResult
         */
        $deleteResult = $controller->delete($challenge->getKey());

        $this->assertInstanceOf(JsonResponse::class, $deleteResult);

        $this->assertTrue($deleteResult->getData(true)['success']);
    }

    /**
     * Test delete missing model
     */
    public function test_delete_404(): void
    {
        $this->expectException(ModelNotFoundException::class);

        /**
         * @var ChallengeController $controller
         */
        $controller = app(ChallengeController::class);

        $controller->delete($this->faker->randomNumber());
    }
}
