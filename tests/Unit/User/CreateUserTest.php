<?php

namespace Tests\Unit\User;

use App\Http\Controllers\UserController;
use App\Http\Requests\Users\CreateUserRequest;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /**
     * Test create model
     */
    public function test_create(): void
    {
        /**
         * @var UserController $controller
         */
        $controller = app(UserController::class);

        $user = $controller->create(
            CreateUserRequest::create('/api/users', 'POST', [
                'name' => $this->faker->name,
                'email' => $this->faker->email,
                'image_path' => $this->faker->imageUrl(),
            ]),
        );

        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * Test create with one program
     */
    public function test_create_with_one_program(): void
    {
        /**
         * @var UserController $controller
         */
        $controller = app(UserController::class);

        $program = Program::factory()->create();

        $this->assertInstanceOf(Program::class, $program);

        $user = $controller->create(
            CreateUserRequest::create('/api/challenges', 'POST', [
                'name' => $this->faker->name,
                'email' => $this->faker->email,
                'image_path' => $this->faker->imageUrl(),
                'programs' => [$program->getKey()]
            ]),
        );

        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * Test create model failed name
     */
    public function test_create_failed_name(): void
    {
        $this->expectException(QueryException::class);

        /**
         * @var UserController $controller
         */
        $controller = app(UserController::class);

        $controller->create(
            CreateUserRequest::create('/api/users', 'POST', [
                'email' => $this->faker->email,
                'image_path' => $this->faker->imageUrl(),
            ]),
        );
    }

    /**
     * Test create model failed email
     */
    public function test_create_failed_email(): void
    {
        $this->expectException(QueryException::class);

        /**
         * @var UserController $controller
         */
        $controller = app(UserController::class);

        $controller->create(
            CreateUserRequest::create('/api/users', 'POST', [
                'name' => $this->faker->name,
                'image_path' => $this->faker->imageUrl(),
            ]),
        );
    }

    /**
     * Test create model failed image_path
     */
    public function test_create_failed_image_path(): void
    {
        /**
         * @var UserController $controller
         */
        $controller = app(UserController::class);

        $user = $controller->create(
            CreateUserRequest::create('/api/users', 'POST', [
                'name' => $this->faker->name,
                'email' => $this->faker->email,
            ]),
        );

        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * Test create model failed program not exist
     */
    public function test_create_with_program_not_exist(): void
    {
        $this->expectException(QueryException::class);

        /**
         * @var UserController $controller
         */
        $controller = app(UserController::class);

        $controller->create(
            CreateUserRequest::create('/api/companies', 'POST', [
                'name' => $this->faker->name,
                'email' => $this->faker->email,
                'image_path' => $this->faker->imageUrl(),
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
         * @var UserController $controller
         */
        $controller = app(UserController::class);

        $program = Program::factory()->create();
        $this->assertInstanceOf(Program::class, $program);

        $controller->create(
            CreateUserRequest::create('/api/companies', 'POST', [
                'name' => $this->faker->name,
                'email' => $this->faker->email,
                'image_path' => $this->faker->imageUrl(),
                'programs' => [$program->getKey(), fake()->numberBetween(2, 10)]
            ]),
        );
    }
}