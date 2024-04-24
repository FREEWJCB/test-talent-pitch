<?php

namespace Tests\Unit\User;

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /**
     * Test delete model
     */
    public function test_delete(): void
    {
        /**
         * @var UserController $controller
         */
        $controller = app(UserController::class);

        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);

        /**
         * @var JsonResponse $deleteResult
         */
        $deleteResult = $controller->delete($user->getKey());

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
         * @var UserController $controller
         */
        $controller = app(UserController::class);

        $controller->delete($this->faker->randomNumber());
    }

}