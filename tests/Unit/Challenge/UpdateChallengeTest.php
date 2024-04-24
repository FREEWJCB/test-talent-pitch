<?php

namespace Tests\Unit\Challenge;

use App\Http\Controllers\ChallengeController;
use App\Http\Requests\Challenges\UpdateChallengeRequest;
use App\Models\Challenge;
use App\Models\Program;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class UpdateChallengeTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /**
     * Test update model
     */
    public function test_update(): void
    {
        /**
         * @var ChallengeController $controller
         */
        $controller = app(ChallengeController::class);

        $challenge = Challenge::factory()->create();

        $this->assertInstanceOf(Challenge::class, $challenge);

        $newAttributes = [
            'title' => fake()->text(20),
            'description' => fake()->text(),
            'difficulty' => fake()->numberBetween(1, 10),
        ];

        $request = UpdateChallengeRequest::create("/api/challenges/{$challenge->getKey()}", 'PATCH', $newAttributes);

        $request->setRouteResolver(function () use ($request) {
            $routes = Route::getRoutes();

            return $routes->match($request);
        });

        $updatedChallenge = $controller->update(
            $request,
            $challenge->getKey(),
        );

        $this->assertInstanceOf(Challenge::class, $updatedChallenge);

        $this->assertEquals($newAttributes, [
            'title' => $updatedChallenge->title,
            'description' => $updatedChallenge->description,
            'difficulty' => $updatedChallenge->difficulty,
        ]);
    }

    /**
     * Test update one program
     */
    public function test_update_with_one_program(): void
    {
        /**
         * @var ChallengeController $controller
         */
        $controller = app(ChallengeController::class);

        $challenge = Challenge::factory()->create();
        $program = Program::factory()->create();

        $this->assertInstanceOf(Challenge::class, $challenge);
        $this->assertInstanceOf(Program::class, $program);

        $newAttributes = [
            'title' => fake()->text(20),
            'description' => fake()->text(),
            'difficulty' => fake()->numberBetween(1, 10),
        ];
        $attributes = [
            'title' => $newAttributes['title'],
            'description' => $newAttributes['description'],
            'difficulty' => $newAttributes['difficulty'],
            'programs' => [$program->getKey()],
        ];

        $request = UpdateChallengeRequest::create("/api/challenges/{$challenge->getKey()}", 'PATCH', $attributes);

        $request->setRouteResolver(function () use ($request) {
            $routes = Route::getRoutes();

            return $routes->match($request);
        });

        $updatedChallenge = $controller->update(
            $request,
            $challenge->getKey(),
        );

        $this->assertInstanceOf(Challenge::class, $updatedChallenge);

        $this->assertEquals($newAttributes, [
            'title' => $updatedChallenge->title,
            'description' => $updatedChallenge->description,
            'difficulty' => $updatedChallenge->difficulty,
        ]);
    }

    /**
     * Test update with two programs
     */
    public function test_update_with_two_programs(): void
    {
        /**
         * @var ChallengeController $controller
         */
        $controller = app(ChallengeController::class);

        $challenge = Challenge::factory()->create();
        $programs = [Program::factory()->create(), Program::factory()->create()];

        $this->assertInstanceOf(Challenge::class, $challenge);
        $this->assertInstanceOf(Program::class, $programs[0]);
        $this->assertInstanceOf(Program::class, $programs[1]);

        $newAttributes = [
            'title' => fake()->text(20),
            'description' => fake()->text(),
            'difficulty' => fake()->numberBetween(1, 10),
        ];
        $attributes = [
            'title' => $newAttributes['title'],
            'description' => $newAttributes['description'],
            'difficulty' => $newAttributes['difficulty'],
            'programs' => [$programs[0]->getKey(), $programs[1]->getKey()],
        ];

        $request = UpdateChallengeRequest::create("/api/challenges/{$challenge->getKey()}", 'PATCH', $attributes);

        $request->setRouteResolver(function () use ($request) {
            $routes = Route::getRoutes();

            return $routes->match($request);
        });

        $updatedChallenge = $controller->update(
            $request,
            $challenge->getKey(),
        );

        $this->assertInstanceOf(Challenge::class, $updatedChallenge);

        $this->assertEquals($newAttributes, [
            'title' => $updatedChallenge->title,
            'description' => $updatedChallenge->description,
            'difficulty' => $updatedChallenge->difficulty,
        ]);
    }

    /**
     * Test update model failed title
     */
    public function test_update_failed_title(): void
    {
        /**
         * @var ChallengeController $controller
         */
        $controller = app(ChallengeController::class);

        $challenge = Challenge::factory()->create();

        $this->assertInstanceOf(Challenge::class, $challenge);

        $newAttributes = [
            'description' => fake()->text(),
            'difficulty' => fake()->numberBetween(1, 10),
        ];

        $request = UpdateChallengeRequest::create("/api/challenges/{$challenge->getKey()}", 'PATCH', $newAttributes);

        $request->setRouteResolver(function () use ($request) {
            $routes = Route::getRoutes();

            return $routes->match($request);
        });

        $updatedChallenge = $controller->update(
            $request,
            $challenge->getKey(),
        );

        $this->assertInstanceOf(Challenge::class, $updatedChallenge);

        $this->assertEquals(
            array_merge([
                'title' => $challenge->title,
            ], $newAttributes),
            [
                'title' => $updatedChallenge->title,
                'description' => $updatedChallenge->description,
                'difficulty' => $updatedChallenge->difficulty,
            ]
        );
    }

    /**
     * Test update model failed description
     */
    public function test_update_failed_description(): void
    {
        /**
         * @var ChallengeController $controller
         */
        $controller = app(ChallengeController::class);

        $challenge = Challenge::factory()->create();

        $this->assertInstanceOf(Challenge::class, $challenge);

        $newAttributes = [
            'title' => fake()->text(20),
            'difficulty' => fake()->numberBetween(1, 10),
        ];

        $request = UpdateChallengeRequest::create("/api/challenges/{$challenge->getKey()}", 'PATCH', $newAttributes);

        $request->setRouteResolver(function () use ($request) {
            $routes = Route::getRoutes();

            return $routes->match($request);
        });

        $updatedChallenge = $controller->update(
            $request,
            $challenge->getKey(),
        );

        $this->assertInstanceOf(Challenge::class, $updatedChallenge);

        $this->assertEquals(
            array_merge([
                'description' => $challenge->description,
            ], $newAttributes),
            [
                'title' => $updatedChallenge->title,
                'description' => $updatedChallenge->description,
                'difficulty' => $updatedChallenge->difficulty,
            ]
        );
    }

    /**
     * Test update model failed difficulty
     */
    public function test_update_failed_difficulty(): void
    {
        /**
         * @var ChallengeController $controller
         */
        $controller = app(ChallengeController::class);

        $challenge = Challenge::factory()->create();

        $this->assertInstanceOf(Challenge::class, $challenge);

        $newAttributes = [
            'title' => fake()->text(20),
            'description' => fake()->text(),
        ];

        $request = UpdateChallengeRequest::create("/api/challenges/{$challenge->getKey()}", 'PATCH', $newAttributes);

        $request->setRouteResolver(function () use ($request) {
            $routes = Route::getRoutes();

            return $routes->match($request);
        });

        $updatedChallenge = $controller->update(
            $request,
            $challenge->getKey(),
        );

        $this->assertInstanceOf(Challenge::class, $updatedChallenge);

        $this->assertEquals(
            array_merge([
                'difficulty' => $challenge->difficulty,
            ], $newAttributes),
            [
                'title' => $updatedChallenge->title,
                'description' => $updatedChallenge->description,
                'difficulty' => $updatedChallenge->difficulty,
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
         * @var ChallengeController $controller
         */
        $controller = app(ChallengeController::class);

        $newAttributes = [
            'title' => fake()->text(20),
            'description' => fake()->text(),
            'difficulty' => fake()->numberBetween(1, 10),
        ];

        $fakeId = $this->faker->randomNumber();

        $request = UpdateChallengeRequest::create("/api/challenges/{$fakeId}", 'PATCH', $newAttributes);

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