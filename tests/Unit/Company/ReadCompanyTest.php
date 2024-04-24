<?php

namespace Tests\Unit\Company;

use App\Http\Controllers\CompanyController;
use App\Models\Company;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadCompanyTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /**
     * Test find model
     */
    public function test_read(): void
    {
        /**
         * @var CompanyController $controller
         */
        $controller = app(CompanyController::class);

        $company = Company::factory()->create();

        $this->assertInstanceOf(Company::class, $company);

        $foundCompany = $controller->read($company->getKey());

        $this->assertInstanceOf(Company::class, $foundCompany);

        $this->assertTrue($company->is($foundCompany));
    }

    /**
     * Test find missing model
     */
    public function test_read_404(): void
    {
        $this->expectException(ModelNotFoundException::class);

        /**
         * @var CompanyController $controller
         */
        $controller = app(CompanyController::class);

        $controller->read($this->faker->randomNumber());
    }
}