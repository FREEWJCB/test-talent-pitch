<?php

namespace Tests\Unit\User;

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadUserTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /**
     * Test find model
     */
    public function test_read(): void
    {
        /**
         * @var UserController $controller
         */
        $controller = app(UserController::class);

        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);

        $foundUser = $controller->read($user->getKey());

        $this->assertInstanceOf(User::class, $foundUser);

        $this->assertTrue($user->is($foundUser));
    }

    /**
     * Test find missing model
     */
    public function test_read_404(): void
    {
        $this->expectException(ModelNotFoundException::class);

        /**
         * @var UserController $controller
         */
        $controller = app(UserController::class);

        $controller->read($this->faker->numberBetween());
    }
}
