<?php

namespace Tests\Unit\Program;

use App\Http\Controllers\ProgramController;
use App\Http\Requests\Programs\UpdateProgramRequest;
use App\Models\Program;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class UpdateProgramTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /**
     * Test update model
     */
    public function test_update(): void
    {
        /**
         * @var ProgramController $controller
         */
        $controller = app(ProgramController::class);

        $program = Program::factory()->create();

        $this->assertInstanceOf(Program::class, $program);

        $newAttributes = [
            'title' => fake()->title(),
            'description' => fake()->realText(),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
        ];

        $request = UpdateProgramRequest::create("/api/companies/{$program->getKey()}", 'PATCH', $newAttributes);

        $request->setRouteResolver(function () use ($request) {
            $routes = Route::getRoutes();

            return $routes->match($request);
        });

        $updatedProgram = $controller->update(
            $request,
            $program->getKey(),
        );

        $this->assertInstanceOf(Program::class, $updatedProgram);

        $this->assertEquals($newAttributes, [
            'title' => $updatedProgram->title,
            'description' => $updatedProgram->description,
            'start_date' => $updatedProgram->start_date,
            'end_date' => $updatedProgram->end_date,
        ]);
    }

    /**
     * Test update model failed title
     */
    public function test_update_failed_title(): void
    {
        /**
         * @var ProgramController $controller
         */
        $controller = app(ProgramController::class);

        $program = Program::factory()->create();

        $this->assertInstanceOf(Program::class, $program);

        $newAttributes = [
            'description' => fake()->realText(),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
        ];

        $request = UpdateProgramRequest::create("/api/companies/{$program->getKey()}", 'PATCH', $newAttributes);

        $request->setRouteResolver(function () use ($request) {
            $routes = Route::getRoutes();

            return $routes->match($request);
        });

        $updatedProgram = $controller->update(
            $request,
            $program->getKey(),
        );

        $this->assertInstanceOf(Program::class, $updatedProgram);

        $this->assertEquals(
            array_merge([
                'title' => $program->title,
            ], $newAttributes),
            [
                'title' => $updatedProgram->title,
                'description' => $updatedProgram->description,
                'start_date' => $updatedProgram->start_date,
                'end_date' => $updatedProgram->end_date,
            ]
        );
    }

    /**
     * Test update model failed description
     */
    public function test_update_failed_description(): void
    {
        /**
         * @var ProgramController $controller
         */
        $controller = app(ProgramController::class);

        $program = Program::factory()->create();

        $this->assertInstanceOf(Program::class, $program);

        $newAttributes = [
            'title' => fake()->title(),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
        ];

        $request = UpdateProgramRequest::create("/api/companies/{$program->getKey()}", 'PATCH', $newAttributes);

        $request->setRouteResolver(function () use ($request) {
            $routes = Route::getRoutes();

            return $routes->match($request);
        });

        $updatedProgram = $controller->update(
            $request,
            $program->getKey(),
        );

        $this->assertInstanceOf(Program::class, $updatedProgram);

        $this->assertEquals(
            array_merge([
                'description' => $program->description,
            ], $newAttributes),
            [
                'title' => $updatedProgram->title,
                'description' => $updatedProgram->description,
                'start_date' => $updatedProgram->start_date,
                'end_date' => $updatedProgram->end_date,
            ]
        );
    }

    /**
     * Test update model failed start_date
     */
    public function test_update_failed_start_date(): void
    {
        /**
         * @var ProgramController $controller
         */
        $controller = app(ProgramController::class);

        $program = Program::factory()->create();

        $this->assertInstanceOf(Program::class, $program);

        $newAttributes = [
            'title' => fake()->title(),
            'description' => fake()->realText(),
            'end_date' => fake()->date(),
        ];

        $request = UpdateProgramRequest::create("/api/companies/{$program->getKey()}", 'PATCH', $newAttributes);

        $request->setRouteResolver(function () use ($request) {
            $routes = Route::getRoutes();

            return $routes->match($request);
        });

        $updatedProgram = $controller->update(
            $request,
            $program->getKey(),
        );

        $this->assertInstanceOf(Program::class, $updatedProgram);

        $this->assertEquals(
            array_merge([
                'start_date' => $program->start_date,
            ], $newAttributes),
            [
                'title' => $updatedProgram->title,
                'description' => $updatedProgram->description,
                'start_date' => $updatedProgram->start_date,
                'end_date' => $updatedProgram->end_date,
            ]
        );
    }

    /**
     * Test update model failed end_date
     */
    public function test_update_failed_end_date(): void
    {
        /**
         * @var ProgramController $controller
         */
        $controller = app(ProgramController::class);

        $program = Program::factory()->create();

        $this->assertInstanceOf(Program::class, $program);

        $newAttributes = [
            'title' => fake()->title(),
            'description' => fake()->realText(),
            'start_date' => fake()->date(),
        ];

        $request = UpdateProgramRequest::create("/api/companies/{$program->getKey()}", 'PATCH', $newAttributes);

        $request->setRouteResolver(function () use ($request) {
            $routes = Route::getRoutes();

            return $routes->match($request);
        });

        $updatedProgram = $controller->update(
            $request,
            $program->getKey(),
        );

        $this->assertInstanceOf(Program::class, $updatedProgram);

        $this->assertEquals(
            array_merge([
                'end_date' => $program->end_date,
            ], $newAttributes),
            [
                'title' => $updatedProgram->title,
                'description' => $updatedProgram->description,
                'start_date' => $updatedProgram->start_date,
                'end_date' => $updatedProgram->end_date,
            ]
        );
    }

    /**
     * Test update missing model
     */
    public function test_update_not_found(): void
    {
        $this->expectException(ModelNotFoundException::class);

        /**
         * @var ProgramController $controller
         */
        $controller = app(ProgramController::class);

        $newAttributes = [
            'title' => fake()->title(),
            'description' => fake()->realText(),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
        ];

        $fakeId = $this->faker->randomNumber();

        $request = UpdateProgramRequest::create("/api/companies/{$fakeId}", 'PATCH', $newAttributes);

        $request->setRouteResolver(function () use ($request) {
            $routes = Route::getRoutes();

            return $routes->match($request);
        });

        $controller->update(
            $request,
            $fakeId,
        );
    }

}
