<?php

namespace Tests\Unit\Company;

use App\Http\Controllers\CompanyController;
use App\Models\Company;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaginationCompanyTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /**
     * Test empty pagination
     */
    public function test_empty_pagination(): void
    {
        /**
         * @var CompanyController $controller
         */
        $controller = app(CompanyController::class);

        $pagination = $controller->index();

        $this->assertInstanceOf(LengthAwarePaginator::class, $pagination);

        $this->assertEquals(0, $pagination->total());
    }

    /**
     * Test pagination
     */
    public function test_pagination(): void
    {
        $count = $this->faker->numberBetween(1, 10);

        $companies = Company::factory()->count($count)->create();

        $this->assertCount($count, $companies);

        /**
         * @var CompanyController $controller
         */
        $controller = app(CompanyController::class);

        $pagination = $controller->index();

        $this->assertInstanceOf(LengthAwarePaginator::class, $pagination);

        $this->assertEquals($count, $pagination->total());
    }
}