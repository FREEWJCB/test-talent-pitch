<?php

namespace Tests\Unit\Company;

use App\Http\Controllers\CompanyController;
use App\Http\Requests\Companies\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\Program;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class UpdateCompanyTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /**
     * Test update model
     */
    public function test_update(): void
    {
        /**
         * @var CompanyController $controller
         */
        $controller = app(CompanyController::class);

        $company = Company::factory()->create();

        $this->assertInstanceOf(Company::class, $company);

        $newAttributes = [
            'name' => fake()->name,
            'image_path' => fake()->imageUrl(),
            'location' => fake()->country(),
            'industry' => fake()->company(),
        ];

        $request = UpdateCompanyRequest::create("/api/companies/{$company->getKey()}", 'PATCH', $newAttributes);

        $request->setRouteResolver(function () use ($request) {
            $routes = Route::getRoutes();

            return $routes->match($request);
        });

        $updatedCompany = $controller->update(
            $request,
            $company->getKey(),
        );

        $this->assertInstanceOf(Company::class, $updatedCompany);

        $this->assertEquals($newAttributes, [
            'name' => $updatedCompany->name,
            'image_path' => $updatedCompany->image_path,
            'location' => $updatedCompany->location,
            'industry' => $updatedCompany->industry,
        ]);
    }
    /**
     * Test update model with one program
     */
    public function test_update_with_one_program(): void
    {
        /**
         * @var CompanyController $controller
         */
        $controller = app(CompanyController::class);

        $company = Company::factory()->create();
        $program = Program::factory()->create();

        $this->assertInstanceOf(Company::class, $company);
        $this->assertInstanceOf(Program::class, $program);

        $newAttributes = [
            'name' => fake()->name,
            'image_path' => fake()->imageUrl(),
            'location' => fake()->country(),
            'industry' => fake()->company(),
        ];
        $attributes = [
            'name' => $newAttributes['name'],
            'image_path' => $newAttributes['image_path'],
            'location' => $newAttributes['location'],
            'industry' => $newAttributes['industry'],
            'programs' => [$program->getKey()],
        ];

        $request = UpdateCompanyRequest::create("/api/companies/{$company->getKey()}", 'PATCH', $attributes);

        $request->setRouteResolver(function () use ($request) {
            $routes = Route::getRoutes();

            return $routes->match($request);
        });

        $updatedCompany = $controller->update(
            $request,
            $company->getKey(),
        );

        $this->assertInstanceOf(Company::class, $updatedCompany);

        $this->assertEquals($newAttributes, [
            'name' => $updatedCompany->name,
            'image_path' => $updatedCompany->image_path,
            'location' => $updatedCompany->location,
            'industry' => $updatedCompany->industry,
        ]);
    }
    /**
     * Test update model with two programs
     */
    public function test_update_with_two_programs(): void
    {
        /**
         * @var CompanyController $controller
         */
        $controller = app(CompanyController::class);

        $company = Company::factory()->create();
        $programs = [Program::factory()->create(), Program::factory()->create()];

        $this->assertInstanceOf(Company::class, $company);
        $this->assertInstanceOf(Program::class, $programs[0]);
        $this->assertInstanceOf(Program::class, $programs[1]);

        $newAttributes = [
            'name' => fake()->name,
            'image_path' => fake()->imageUrl(),
            'location' => fake()->country(),
            'industry' => fake()->company(),
        ];
        $attributes = [
            'name' => $newAttributes['name'],
            'image_path' => $newAttributes['image_path'],
            'location' => $newAttributes['location'],
            'industry' => $newAttributes['industry'],
            'programs' => [$programs[0]->getKey(), $programs[1]->getKey()],
        ];

        $request = UpdateCompanyRequest::create("/api/companies/{$company->getKey()}", 'PATCH', $attributes);

        $request->setRouteResolver(function () use ($request) {
            $routes = Route::getRoutes();

            return $routes->match($request);
        });

        $updatedCompany = $controller->update(
            $request,
            $company->getKey(),
        );

        $this->assertInstanceOf(Company::class, $updatedCompany);

        $this->assertEquals($newAttributes, [
            'name' => $updatedCompany->name,
            'image_path' => $updatedCompany->image_path,
            'location' => $updatedCompany->location,
            'industry' => $updatedCompany->industry,
        ]);
    }

    /**
     * Test update model failed name
     */
    public function test_update_failed_name(): void
    {
        /**
         * @var CompanyController $controller
         */
        $controller = app(CompanyController::class);

        $company = Company::factory()->create();

        $this->assertInstanceOf(Company::class, $company);

        $newAttributes = [
            'image_path' => fake()->imageUrl(),
            'location' => fake()->country(),
            'industry' => fake()->company(),
        ];

        $request = UpdateCompanyRequest::create("/api/companies/{$company->getKey()}", 'PATCH', $newAttributes);

        $request->setRouteResolver(function () use ($request) {
            $routes = Route::getRoutes();

            return $routes->match($request);
        });

        $updatedCompany = $controller->update(
            $request,
            $company->getKey(),
        );

        $this->assertInstanceOf(Company::class, $updatedCompany);

        $this->assertEquals(
            array_merge([
                'name' => $company->name,
            ], $newAttributes),
            [
                'name' => $updatedCompany->name,
                'image_path' => $updatedCompany->image_path,
                'location' => $updatedCompany->location,
                'industry' => $updatedCompany->industry,
            ]
        );
    }

    /**
     * Test update model failed image_path
     */
    public function test_update_failed_image_path(): void
    {
        /**
         * @var CompanyController $controller
         */
        $controller = app(CompanyController::class);

        $company = Company::factory()->create();

        $this->assertInstanceOf(Company::class, $company);

        $newAttributes = [
            'name' => fake()->name,
            'location' => fake()->country(),
            'industry' => fake()->company(),
        ];

        $request = UpdateCompanyRequest::create("/api/companies/{$company->getKey()}", 'PATCH', $newAttributes);

        $request->setRouteResolver(function () use ($request) {
            $routes = Route::getRoutes();

            return $routes->match($request);
        });

        $updatedCompany = $controller->update(
            $request,
            $company->getKey(),
        );

        $this->assertInstanceOf(Company::class, $updatedCompany);

        $this->assertEquals(
            array_merge([
                'image_path' => $company->image_path,
            ], $newAttributes),
            [
                'name' => $updatedCompany->name,
                'image_path' => $updatedCompany->image_path,
                'location' => $updatedCompany->location,
                'industry' => $updatedCompany->industry,
            ]
        );
    }

    /**
     * Test update model failed location
     */
    public function test_update_failed_location(): void
    {
        /**
         * @var CompanyController $controller
         */
        $controller = app(CompanyController::class);

        $company = Company::factory()->create();

        $this->assertInstanceOf(Company::class, $company);

        $newAttributes = [
            'name' => fake()->name,
            'image_path' => fake()->imageUrl(),
            'industry' => fake()->company(),
        ];

        $request = UpdateCompanyRequest::create("/api/companies/{$company->getKey()}", 'PATCH', $newAttributes);

        $request->setRouteResolver(function () use ($request) {
            $routes = Route::getRoutes();

            return $routes->match($request);
        });

        $updatedCompany = $controller->update(
            $request,
            $company->getKey(),
        );

        $this->assertInstanceOf(Company::class, $updatedCompany);

        $this->assertEquals(
            array_merge([
                'location' => $company->location,
            ], $newAttributes),
            [
                'name' => $updatedCompany->name,
                'image_path' => $updatedCompany->image_path,
                'location' => $updatedCompany->location,
                'industry' => $updatedCompany->industry,
            ]
        );
    }

    /**
     * Test update model failed industry
     */
    public function test_update_failed_industry(): void
    {
        /**
         * @var CompanyController $controller
         */
        $controller = app(CompanyController::class);

        $company = Company::factory()->create();

        $this->assertInstanceOf(Company::class, $company);

        $newAttributes = [
            'name' => fake()->name,
            'image_path' => fake()->imageUrl(),
            'location' => fake()->country(),
        ];

        $request = UpdateCompanyRequest::create("/api/companies/{$company->getKey()}", 'PATCH', $newAttributes);

        $request->setRouteResolver(function () use ($request) {
            $routes = Route::getRoutes();

            return $routes->match($request);
        });

        $updatedCompany = $controller->update(
            $request,
            $company->getKey(),
        );

        $this->assertInstanceOf(Company::class, $updatedCompany);

        $this->assertEquals(
            array_merge([
                'industry' => $company->industry,
            ], $newAttributes),
            [
                'name' => $updatedCompany->name,
                'image_path' => $updatedCompany->image_path,
                'location' => $updatedCompany->location,
                'industry' => $updatedCompany->industry,
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
         * @var CompanyController $controller
         */
        $controller = app(CompanyController::class);

        $newAttributes = [
            'name' => fake()->name,
            'image_path' => fake()->imageUrl(),
            'location' => fake()->country(),
            'industry' => fake()->company(),
        ];

        $fakeId = $this->faker->randomNumber();

        $request = UpdateCompanyRequest::create("/api/companies/{$fakeId}", 'PATCH', $newAttributes);

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