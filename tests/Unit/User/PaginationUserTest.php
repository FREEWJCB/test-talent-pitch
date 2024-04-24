<?php

namespace Tests\Unit\User;

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaginationUserTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /**
     * Test empty pagination
     */
    public function test_empty_pagination(): void
    {
        /**
         * @var UserController $controller
         */
        $controller = app(UserController::class);

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

        $users = User::factory()->count($count)->create();

        $this->assertCount($count, $users);

        /**
         * @var UserController $controller
         */
        $controller = app(UserController::class);

        $pagination = $controller->index();

        $this->assertInstanceOf(LengthAwarePaginator::class, $pagination);

        $this->assertEquals($count, $pagination->total());
    }
}
