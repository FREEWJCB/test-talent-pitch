<?php

namespace Tests\Unit\Challenge;

use App\Http\Controllers\ChallengeController;
use App\Http\Requests\Challenges\CreateChallengeRequest;
use App\Models\Challenge;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateChallengeTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /**
     * Test create model
     */
    public function test_create(): void
    {
        /**
         * @var ChallengeController $controller
         */
        $controller = app(ChallengeController::class);

        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);

        $challenge = $controller->create(
            CreateChallengeRequest::create('/api/challenges', 'POST', [
                'title' => fake()->text(20),
                'description' => fake()->text(),
                'difficulty' => fake()->numberBetween(1, 10),
                'user_id' => $user->getKey()
            ]),
        );

        $this->assertInstanceOf(Challenge::class, $challenge);
    }

    /**
     * Test create with one program
     */
    public function test_create_with_one_program(): void
    {
        /**
         * @var ChallengeController $controller
         */
        $controller = app(ChallengeController::class);

        $user = User::factory()->create();
        $program = Program::factory()->create();

        $this->assertInstanceOf(User::class, $user);
        $this->assertInstanceOf(Program::class, $program);

        $challenge = $controller->create(
            CreateChallengeRequest::create('/api/challenges', 'POST', [
                'title' => fake()->text(20),
                'description' => fake()->text(),
                'difficulty' => fake()->numberBetween(1, 10),
                'user_id' => $user->getKey(),
                'programs' => [$program->getKey()]
            ]),
        );

        $this->assertInstanceOf(Challenge::class, $challenge);
    }

    /**
     * Test create with two programs
     */
    public function test_create_with_two_program(): void
    {
        /**
         * @var ChallengeController $controller
         */
        $controller = app(ChallengeController::class);

        $user = User::factory()->create();
        $programs = [Program::factory()->create(), Program::factory()->create()];

        $this->assertInstanceOf(User::class, $user);

        $challenge = $controller->create(
            CreateChallengeRequest::create('/api/challenges', 'POST', [
                'title' => fake()->text(20),
                'description' => fake()->text(),
                'difficulty' => fake()->numberBetween(1, 10),
                'user_id' => $user->getKey(),
                'programs' => [$programs[0]->getKey(), $programs[1]->getKey()]
            ]),
        );

        $this->assertInstanceOf(Challenge::class, $challenge);
    }

    /**
     * Test create model failed title
     */
    public function test_create_failed_title(): void
    {
        $this->expectException(QueryException::class);

        /**
         * @var ChallengeController $controller
         */
        $controller = app(ChallengeController::class);

        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);

        $controller->create(
            CreateChallengeRequest::create('/api/challenges', 'POST', [
                'description' => fake()->text(),
                'difficulty' => fake()->numberBetween(1, 10),
                'user_id' => $user->getKey()
            ]),
        );
    }

    /**
     * Test create model failed description
     */
    public function test_create_failed_description(): void
    {
        $this->expectException(QueryException::class);

        /**
         * @var ChallengeController $controller
         */
        $controller = app(ChallengeController::class);

        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);

        $controller->create(
            CreateChallengeRequest::create('/api/challenges', 'POST', [
                'title' => fake()->text(20),
                'difficulty' => fake()->numberBetween(1, 10),
                'user_id' => $user->getKey()
            ]),
        );
    }

    /**
     * Test create model failed difficulty
     */
    public function test_create_failed_difficulty(): void
    {
        $this->expectException(QueryException::class);

        /**
         * @var ChallengeController $controller
         */
        $controller = app(ChallengeController::class);

        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);

        $controller->create(
            CreateChallengeRequest::create('/api/challenges', 'POST', [
                'title' => fake()->text(20),
                'description' => fake()->text(),
                'user_id' => $user->getKey()
            ]),
        );
    }

    /**
     * Test create model failed program not exist
     */
    public function test_create_with_program_not_exist(): void
    {
        $this->expectException(QueryException::class);

        /**
         * @var ChallengeController $controller
         */
        $controller = app(ChallengeController::class);

        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);

        $controller->create(
            CreateChallengeRequest::create('/api/challenges', 'POST', [
                'title' => fake()->text(20),
                'description' => fake()->text(),
                'difficulty' => fake()->numberBetween(1, 10),
                'user_id' => $user->getKey(),
                'programs' => [fake()->numberBetween(1, 10)]
            ]),
        );
    }

    /**
     * Test create model failed not exist and exist
     */
    public function test_create_with_programs_not_exist_and_exist(): void
    {
        $this->expectException(QueryException::class);

        /**
         * @var ChallengeController $controller
         */
        $controller = app(ChallengeController::class);

        $user = User::factory()->create();
        $program = Program::factory()->create();
        $this->assertInstanceOf(User::class, $user);
        $this->assertInstanceOf(Program::class, $program);

        $controller->create(
            CreateChallengeRequest::create('/api/challenges', 'POST', [
                'title' => fake()->text(20),
                'description' => fake()->text(),
                'difficulty' => fake()->numberBetween(1, 10),
                'user_id' => $user->getKey(),
                'programs' => [$program->getKey(), fake()->numberBetween(2, 10)]
            ]),
        );
    }

}
