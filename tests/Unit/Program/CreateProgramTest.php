<?php

namespace Tests\Unit\Program;

use App\Enums\ProgramEntityType;
use App\Http\Controllers\ProgramController;
use App\Http\Requests\Programs\CreateProgramRequest;
use App\Models\Challenge;
use App\Models\Company;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateProgramTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /**
     * Test create model
     */
    public function test_create(): void
    {
        /**
         * @var ProgramController $controller
         */
        $controller = app(ProgramController::class);

        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);

        $program = $controller->create(
            CreateProgramRequest::create('/api/companies', 'POST', [
                'title' => fake()->title(),
                'description' => fake()->realText(),
                'start_date' => fake()->date(),
                'end_date' => fake()->date(),
                'user_id' => $user->getKey(),
            ]),
        );

        $this->assertInstanceOf(Program::class, $program);
    }

    /**
     * Test create model with participants
     */
    public function test_create_with_participants(): void
    {
        /**
         * @var ProgramController $controller
         */
        $controller = app(ProgramController::class);

        $user = User::factory()->create();
        $company = Company::factory()->create();
        $challenge = Challenge::factory()->create();
        $userParticipants = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);
        $this->assertInstanceOf(User::class, $userParticipants);
        $this->assertInstanceOf(Challenge::class, $challenge);
        $this->assertInstanceOf(Company::class, $company);

        $program = $controller->create(
            CreateProgramRequest::create('/api/companies', 'POST', [
                'title' => fake()->title(),
                'description' => fake()->realText(),
                'start_date' => fake()->date(),
                'end_date' => fake()->date(),
                'user_id' => $user->getKey(),
                'entities' =>[
                    [
                        'id' => $userParticipants->getKey(),
                        'type' => ProgramEntityType::USERS,
                    ],
                    [
                        'id' => $company->getKey(),
                        'type' => ProgramEntityType::COMPANIES,
                    ],
                    [
                        'id' => $challenge->getKey(),
                        'type' => ProgramEntityType::CHALLENGES,
                    ],
                ]
            ]),
        );

        $this->assertInstanceOf(Program::class, $program);
    }

    /**
     * Test create model failed title
     */
    public function test_create_failed_title(): void
    {
        $this->expectException(QueryException::class);

        /**
         * @var ProgramController $controller
         */
        $controller = app(ProgramController::class);

        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);

        $controller->create(
            CreateProgramRequest::create('/api/companies', 'POST', [
                'description' => fake()->realText(),
                'start_date' => fake()->date(),
                'end_date' => fake()->date(),
                'user_id' => $user->getKey(),
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
         * @var ProgramController $controller
         */
        $controller = app(ProgramController::class);

        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);

        $program = $controller->create(
            CreateProgramRequest::create('/api/companies', 'POST', [
                'title' => fake()->title(),
                'start_date' => fake()->date(),
                'end_date' => fake()->date(),
                'user_id' => $user->getKey(),
            ]),
        );

        $this->assertInstanceOf(Program::class, $program);
    }

    /**
     * Test create model failed start_date
     */
    public function test_create_failed_start_date(): void
    {
        $this->expectException(QueryException::class);

        /**
         * @var ProgramController $controller
         */
        $controller = app(ProgramController::class);

        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);

        $controller->create(
            CreateProgramRequest::create('/api/companies', 'POST', [
                'title' => fake()->title(),
                'description' => fake()->realText(),
                'end_date' => fake()->date(),
                'user_id' => $user->getKey(),
            ]),
        );
    }

    /**
     * Test create model failed end_date
     */
    public function test_create_failed_end_date(): void
    {
        $this->expectException(QueryException::class);

        /**
         * @var ProgramController $controller
         */
        $controller = app(ProgramController::class);

        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);

        $controller->create(
            CreateProgramRequest::create('/api/companies', 'POST', [
                'title' => fake()->title(),
                'description' => fake()->realText(),
                'start_date' => fake()->date(),
                'user_id' => $user->getKey(),
            ]),
        );
    }

    /**
     * Test create model with not exist
     */
    public function test_create_with_not_exist(): void
    {
        $this->expectException(QueryException::class);

        /**
         * @var ProgramController $controller
         */
        $controller = app(ProgramController::class);

        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);

        $controller->create(
            CreateProgramRequest::create('/api/companies', 'POST', [
                'title' => fake()->title(),
                'description' => fake()->realText(),
                'start_date' => fake()->date(),
                'user_id' => $user->getKey(),
                'entities' =>[
                    [
                        'id' => fake()->numberBetween(2, 10),
                        'type' => ProgramEntityType::USERS,
                    ],
                    [
                        'id' => fake()->numberBetween(2, 10),
                        'type' => ProgramEntityType::COMPANIES,
                    ],
                    [
                        'id' => fake()->numberBetween(2, 10),
                        'type' => ProgramEntityType::CHALLENGES,
                    ],
                ]
            ]),
        );
    }

    /**
     * Test create model with not exist and exist
     */
    public function test_create_with_not_exist_and_exist(): void
    {
        $this->expectException(QueryException::class);

        /**
         * @var ProgramController $controller
         */
        $controller = app(ProgramController::class);

        $user = User::factory()->create();
        $challenge = Challenge::factory()->create();

        $this->assertInstanceOf(User::class, $user);
        $this->assertInstanceOf(Challenge::class, $challenge);

        $controller->create(
            CreateProgramRequest::create('/api/companies', 'POST', [
                'title' => fake()->title(),
                'description' => fake()->realText(),
                'start_date' => fake()->date(),
                'user_id' => $user->getKey(),
                'entities' =>[
                    [
                        'id' => fake()->numberBetween(2, 10),
                        'type' => ProgramEntityType::USERS,
                    ],
                    [
                        'id' => fake()->numberBetween(2, 10),
                        'type' => ProgramEntityType::COMPANIES,
                    ],
                    [
                        'id' => $challenge->getKey(),
                        'type' => ProgramEntityType::CHALLENGES,
                    ],
                ]
            ]),
        );
    }
}