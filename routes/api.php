<?php

use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// User
Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index')->name('users.index');
    Route::post('/users', 'create')->name('users.create');
    Route::get('/users/{id}', 'read')->name('users.read');
    Route::patch('/users/{id}', 'update')->name('users.update');
    Route::delete('/users/{id}', 'delete')->name('users.delete');
});

// Challenge
Route::controller(ChallengeController::class)->group(function () {
    Route::get('/challenges', 'index')->name('challenges.index');
    Route::post('/challenges', 'create')->name('challenges.create');
    Route::get('/challenges/{id}', 'read')->name('challenges.read');
    Route::patch('/challenges/{id}', 'update')->name('challenges.update');
    Route::delete('/challenges/{id}', 'delete')->name('challenges.delete');
});

// Companies
Route::controller(CompanyController::class)->group(function () {
    Route::get('/companies', 'index')->name('companies.index');
    Route::post('/companies', 'create')->name('companies.create');
    Route::get('/companies/{id}', 'read')->name('companies.read');
    Route::patch('/companies/{id}', 'update')->name('companies.update');
    Route::delete('/companies/{id}', 'delete')->name('companies.delete');
});

//Programs
Route::controller(ProgramController::class)->group(function () {
    Route::get('/programs', 'index')->name('programs.index');
    Route::post('/programs', 'create')->name('programs.create');
    Route::get('/programs/{id}', 'read')->name('programs.read');
    Route::patch('/programs/{id}', 'update')->name('programs.update');
    Route::delete('/programs/{id}', 'delete')->name('programs.delete');
});
