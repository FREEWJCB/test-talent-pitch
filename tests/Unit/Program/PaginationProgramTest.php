<?php

namespace Tests\Unit\Program;

use App\Http\Controllers\ProgramController;
use App\Models\Program;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaginationProgramTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /**
     * Test empty pagination
     */
    public function test_empty_pagination(): void
    {
        /**
         * @var ProgramController $controller
         */
        $controller = app(ProgramController::class);

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

        $programs = Program::factory()->count($count)->create();

        $this->assertCount($count, $programs);

        /**
         * @var ProgramController $controller
         */
        $controller = app(ProgramController::class);

        $pagination = $controller->index();

        $this->assertInstanceOf(LengthAwarePaginator::class, $pagination);

        $this->assertEquals($count, $pagination->total());
    }
}