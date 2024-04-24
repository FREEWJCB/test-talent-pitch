<?php

namespace Tests\Unit\User;

use App\Http\Controllers\UserController;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /**
     * Test update model
     */
    public function test_update(): void
    {
        /**
         * @var UserController $controller
         */
        $controller = app(UserController::class);

        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);

        $newAttributes = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'image_path' => $this->faker->imageUrl(),
        ];

        $request = UpdateUserRequest::create("/api/users/{$user->getKey()}", 'PATCH', $newAttributes);

        $request->setRouteResolver(function () use ($request) {
            $routes = Route::getRoutes();

            return $routes->match($request);
        });

        $updatedUser = $controller->update(
            $request,
            $user->getKey(),
        );

        $this->assertInstanceOf(User::class, $updatedUser);

        $this->assertEquals($newAttributes, [
            'name' => $updatedUser->name,
            'email' => $updatedUser->email,
            'image_path' => $updatedUser->image_path,
        ]);
    }

    /**
     * Test update model
     */
    public function test_update_with_one_program(): void
    {
        /**
         * @var UserController $controller
         */
        $controller = app(UserController::class);

        $user = User::factory()->create();
        $program = Program::factory()->create();

        $this->assertInstanceOf(User::class, $user);
        $this->assertInstanceOf(Program::class, $program);

        $newAttributes = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'image_path' => $this->faker->imageUrl(),
        ];

        $attributes = [
            'name' => $newAttributes['name'],
            'email' => $newAttributes['email'],
            'image_path' => $newAttributes['image_path'],
            'programs' => [$program->getKey()],
        ];

        $request = UpdateUserRequest::create("/api/users/{$user->getKey()}", 'PATCH', $attributes);

        $request->setRouteResolver(function () use ($request) {
            $routes = Route::getRoutes();

            return $routes->match($request);
        });

        $updatedUser = $controller->update(
            $request,
            $user->getKey(),
        );

        $this->assertInstanceOf(User::class, $updatedUser);

        $this->assertEquals($newAttributes, [
            'name' => $updatedUser->name,
            'email' => $updatedUser->email,
            'image_path' => $updatedUser->image_path,
        ]);
    }


    /**
     * Test update model with two programs
     */
    public function test_update_with_two_programs(): void
    {
        /**
         * @var UserController $controller
         */
        $controller = app(UserController::class);

        $user = User::factory()->create();
        $programs = [Program::factory()->create(), Program::factory()->create()];

        $this->assertInstanceOf(User::class, $user);
        $this->assertInstanceOf(Program::class, $programs[0]);
        $this->assertInstanceOf(Program::class, $programs[1]);

        $newAttributes = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'image_path' => $this->faker->imageUrl(),
        ];

        $attributes = [
            'name' => $newAttributes['name'],
            'email' => $newAttributes['email'],
            'image_path' => $newAttributes['image_path'],
            'programs' => [$programs[0]->getKey(), $programs[1]->getKey()],
        ];

        $request = UpdateUserRequest::create("/api/users/{$user->getKey()}", 'PATCH', $attributes);

        $request->setRouteResolver(function () use ($request) {
            $routes = Route::getRoutes();

            return $routes->match($request);
        });

        $updatedUser = $controller->update(
            $request,
            $user->getKey(),
        );

        $this->assertInstanceOf(User::class, $updatedUser);

        $this->assertEquals($newAttributes, [
            'name' => $updatedUser->name,
            'email' => $updatedUser->email,
            'image_path' => $updatedUser->image_path,
        ]);
    }

    /**
     * Test update model failed name
     */
    public function test_update_failed_name(): void
    {
        /**
         * @var UserController $controller
         */
        $controller = app(UserController::class);

        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);

        $newAttributes = [
            'email' => $this->faker->email,
            'image_path' => $this->faker->imageUrl(),
        ];

        $request = UpdateUserRequest::create("/api/users/{$user->getKey()}", 'PATCH', $newAttributes);

        $request->setRouteResolver(function () use ($request) {
            $routes = Route::getRoutes();

            return $routes->match($request);
        });

        $updatedUser = $controller->update(
            $request,
            $user->getKey(),
        );

        $this->assertInstanceOf(User::class, $updatedUser);

        $this->assertEquals(
            array_merge([
                'name' => $user->name,
            ], $newAttributes),
            [
                'name' => $updatedUser->name,
                'email' => $updatedUser->email,
                'image_path' => $updatedUser->image_path,
            ]
        );
    }

    /**
     * Test update model failed email
     */
    public function test_update_failed_email(): void
    {
        /**
         * @var UserController $controller
         */
        $controller = app(UserController::class);

        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);

        $newAttributes = [
            'name' => $this->faker->name,
            'image_path' => $this->faker->imageUrl(),
        ];

        $request = UpdateUserRequest::create("/api/users/{$user->getKey()}", 'PATCH', $newAttributes);

        $request->setRouteResolver(function () use ($request) {
            $routes = Route::getRoutes();

            return $routes->match($request);
        });

        $updatedUser = $controller->update(
            $request,
            $user->getKey(),
        );

        $this->assertInstanceOf(User::class, $updatedUser);

        $this->assertEquals(
            array_merge([
                'email' => $user->email,
            ], $newAttributes),
            [
                'name' => $updatedUser->name,
                'email' => $updatedUser->email,
                'image_path' => $updatedUser->image_path,
            ]
        );
    }

    /**
     * Test update model failed image_path
     */
    public function test_update_failed_image_path(): void
    {
        /**
         * @var UserController $controller
         */
        $controller = app(UserController::class);

        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);

        $newAttributes = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
        ];

        $request = UpdateUserRequest::create("/api/users/{$user->getKey()}", 'PATCH', $newAttributes);

        $request->setRouteResolver(function () use ($request) {
            $routes = Route::getRoutes();

            return $routes->match($request);
        });

        $updatedUser = $controller->update(
            $request,
            $user->getKey(),
        );

        $this->assertInstanceOf(User::class, $updatedUser);

        $this->assertEquals(
            array_merge([
                'image_path' => $user->image_path,
            ], $newAttributes),
            [
                'name' => $updatedUser->name,
                'email' => $updatedUser->email,
                'image_path' => $updatedUser->image_path,
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
         * @var UserController $controller
         */
        $controller = app(UserController::class);

        $newAttributes = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
        ];

        $fakeId = $this->faker->randomNumber();

        $request = UpdateUserRequest::create("/api/users/{$fakeId}", 'PATCH', $newAttributes);

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