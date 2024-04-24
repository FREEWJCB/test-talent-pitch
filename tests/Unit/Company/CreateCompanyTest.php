<?php

namespace Tests\Unit\Company;

use App\Http\Controllers\CompanyController;
use App\Http\Requests\Companies\CreateCompanyRequest;
use App\Models\Company;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCompanyTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /**
     * Test create model
     */
    public function test_create(): void
    {
        /**
         * @var CompanyController $controller
         */
        $controller = app(CompanyController::class);

        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);

        $company = $controller->create(
            CreateCompanyRequest::create('/api/companies', 'POST', [
                'name' => fake()->name,
                'image_path' => fake()->imageUrl(),
                'location' => fake()->country(),
                'industry' => fake()->company(),
                'user_id' => $user->getKey(),
            ]),
        );

        $this->assertInstanceOf(Company::class, $company);
    }

    /**
     * Test create with one program
     */
    public function test_create_with_one_program(): void
    {
        /**
         * @var CompanyController $controller
         */
        $controller = app(CompanyController::class);

        $user = User::factory()->create();
        $program = Program::factory()->create();

        $this->assertInstanceOf(User::class, $user);
        $this->assertInstanceOf(Program::class, $program);

        $company = $controller->create(
            CreateCompanyRequest::create('/api/challenges', 'POST', [
                'name' => fake()->name,
                'image_path' => fake()->imageUrl(),
                'location' => fake()->country(),
                'industry' => fake()->company(),
                'user_id' => $user->getKey(),
                'programs' => [$program->getKey()]
            ]),
        );

        $this->assertInstanceOf(Company::class, $company);
    }

    /**
     * Test create model failed name
     */
    public function test_create_failed_name(): void
    {
        $this->expectException(QueryException::class);

        /**
         * @var CompanyController $controller
         */
        $controller = app(CompanyController::class);

        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);

        $controller->create(
            CreateCompanyRequest::create('/api/companies', 'POST', [
                'image_path' => fake()->imageUrl(),
                'location' => fake()->country(),
                'industry' => fake()->company(),
                'user_id' => $user->getKey(),
            ]),
        );
    }

    /**
     * Test create model failed image_path
     */
    public function test_create_failed_image_path(): void
    {
        /**
         * @var CompanyController $controller
         */
        $controller = app(CompanyController::class);

        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);

        $company = $controller->create(
            CreateCompanyRequest::create('/api/companies', 'POST', [
                'name' => fake()->name,
                'location' => fake()->country(),
                'industry' => fake()->company(),
                'user_id' => $user->getKey(),
            ]),
        );

        $this->assertInstanceOf(Company::class, $company);
    }

    /**
     * Test create model failed location
     */
    public function test_create_failed_location(): void
    {
        $this->expectException(QueryException::class);

        /**
         * @var CompanyController $controller
         */
        $controller = app(CompanyController::class);

        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);

        $controller->create(
            CreateCompanyRequest::create('/api/companies', 'POST', [
                'name' => fake()->name,
                'image_path' => fake()->imageUrl(),
                'industry' => fake()->company(),
                'user_id' => $user->getKey(),
            ])
        );
    }

    /**
     * Test create model failed industry
     */
    public function test_create_failed_industry(): void
    {
        $this->expectException(QueryException::class);

        /**
         * @var CompanyController $controller
         */
        $controller = app(CompanyController::class);

        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);

        $controller->create(
            CreateCompanyRequest::create('/api/companies', 'POST', [
                'name' => fake()->name,
                'image_path' => fake()->imageUrl(),
                'location' => fake()->country(),
                'user_id' => $user->getKey(),
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
         * @var CompanyController $controller
         */
        $controller = app(CompanyController::class);

        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);

        $controller->create(
            CreateCompanyRequest::create('/api/companies', 'POST', [
                'name' => fake()->name,
                'image_path' => fake()->imageUrl(),
                'location' => fake()->country(),
                'industry' => fake()->company(),
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
         * @var CompanyController $controller
         */
        $controller = app(CompanyController::class);

        $user = User::factory()->create();
        $program = Program::factory()->create();
        $this->assertInstanceOf(User::class, $user);
        $this->assertInstanceOf(Program::class, $program);

        $controller->create(
            CreateCompanyRequest::create('/api/companies', 'POST', [
                'name' => fake()->name,
                'image_path' => fake()->imageUrl(),
                'location' => fake()->country(),
                'industry' => fake()->company(),
                'user_id' => $user->getKey(),
                'programs' => [$program->getKey(), fake()->numberBetween(2, 10)]
            ]),
        );
    }
}
