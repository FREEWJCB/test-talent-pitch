<?php

namespace Tests\Unit\Program;

use App\Http\Controllers\ProgramController;
use App\Models\Program;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class DeleteProgramTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /**
     * Test delete model
     */
    public function test_delete(): void
    {
        /**
         * @var ProgramController $controller
         */
        $controller = app(ProgramController::class);

        $program = Program::factory()->create();

        $this->assertInstanceOf(Program::class, $program);

        /**
         * @var JsonResponse $deleteResult
         */
        $deleteResult = $controller->delete($program->getKey());

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
         * @var ProgramController $controller
         */
        $controller = app(ProgramController::class);

        $controller->delete($this->faker->randomNumber());
    }
}
