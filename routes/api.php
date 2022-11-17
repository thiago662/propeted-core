<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\InterectionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile.show');

    // Route::apiResource('/roles', RoleController::class);
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/option', [RoleController::class, 'option'])->name('roles.option');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show');
    Route::match(['put', 'patch'], '/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    // Route::apiResource('/users', UserController::class);
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/option', [UserController::class, 'option'])->name('users.option');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::match(['put', 'patch'], '/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Route::apiResource('/owners', OwnerController::class);
    Route::get('/owners', [OwnerController::class, 'index'])->name('owners.index');
    Route::get('/owners/option', [OwnerController::class, 'option'])->name('owners.option');
    Route::post('/owners', [OwnerController::class, 'store'])->name('owners.store');
    Route::get('/owners/{owner}', [OwnerController::class, 'show'])->name('owners.show');
    Route::match(['put', 'patch'], '/owners/{owner}', [OwnerController::class, 'update'])->name('owners.update');
    Route::delete('/owners/{owner}', [OwnerController::class, 'destroy'])->name('owners.destroy');

    // Route::apiResource('/animals', AnimalController::class);
    Route::get('/animals', [AnimalController::class, 'index'])->name('animals.index');
    Route::get('/animals/option', [AnimalController::class, 'option'])->name('animals.option');
    Route::post('/animals', [AnimalController::class, 'store'])->name('animals.store');
    Route::get('/animals/{animal}', [AnimalController::class, 'show'])->name('animals.show');
    Route::match(['put', 'patch'], '/animals/{animal}', [AnimalController::class, 'update'])->name('animals.update');
    Route::delete('/animals/{animal}', [AnimalController::class, 'destroy'])->name('animals.destroy');

    // Route::apiResource('/interections', InterectionController::class);
    Route::get('/interections', [InterectionController::class, 'index'])->name('interections.index');
    Route::post('/interections', [InterectionController::class, 'store'])->name('interections.store');
    Route::get('/interections/{interection}', [InterectionController::class, 'show'])->name('interections.show');
    Route::match(['put', 'patch'], '/interections/{interection}', [InterectionController::class, 'update'])->name('interections.update');
    Route::delete('/interections/{interection}', [InterectionController::class, 'destroy'])->name('interections.destroy');

    // Route::apiResource('/messages', MessageController::class);
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::match(['put', 'patch'], '/messages/{message}', [MessageController::class, 'update'])->name('messages.update');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

    // Route::apiResource('/schedules', ScheduleController::class);
    Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store');
    Route::get('/schedules/{schedule}', [ScheduleController::class, 'show'])->name('schedules.show');
    Route::match(['put', 'patch'], '/schedules/{schedule}', [ScheduleController::class, 'update'])->name('schedules.update');
    Route::delete('/schedules/{schedule}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');
});
