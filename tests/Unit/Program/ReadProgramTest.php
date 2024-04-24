<?php

namespace Tests\Unit\Program;

use App\Http\Controllers\ProgramController;
use App\Models\Program;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadProgramTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /**
     * Test find model
     */
    public function test_read(): void
    {
        /**
         * @var ProgramController $controller
         */
        $controller = app(ProgramController::class);

        $program = Program::factory()->create();

        $this->assertInstanceOf(Program::class, $program);

        $foundProgram = $controller->read($program->getKey());

        $this->assertInstanceOf(Program::class, $foundProgram);

        $this->assertTrue($program->is($foundProgram));
    }

    /**
     * Test find missing model
     */
    public function test_read_404(): void
    {
        $this->expectException(ModelNotFoundException::class);

        /**
         * @var ProgramController $controller
         */
        $controller = app(ProgramController::class);

        $controller->read($this->faker->randomNumber());
    }
}