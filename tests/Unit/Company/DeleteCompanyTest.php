<?php

namespace Tests\Unit\Company;

use App\Http\Controllers\CompanyController;
use App\Models\Company;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class DeleteCompanyTest extends TestCase
{
    use DatabaseMigrations, WithFaker;


    /**
     * Test delete model
     */
    public function test_delete(): void
    {
        /**
         * @var CompanyController $controller
         */
        $controller = app(CompanyController::class);

        $company = Company::factory()->create();

        $this->assertInstanceOf(Company::class, $company);

        /**
         * @var JsonResponse $deleteResult
         */
        $deleteResult = $controller->delete($company->getKey());

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
         * @var CompanyController $controller
         */
        $controller = app(CompanyController::class);

        $controller->delete($this->faker->randomNumber());
    }

}