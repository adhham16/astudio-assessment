<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TimesheetController;
use App\Http\Controllers\Api\AttributeController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('user/register', [AuthController::class, 'register']);
Route::post('user/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::resource('timesheet', TimesheetController::class);
    Route::resource('project', ProjectController::class);
    Route::post('project/attribute/{id}', [ProjectController::class, 'setAttributes']);
    Route::resource('user', \App\Http\Controllers\Api\UserController::class);
    Route::resource('attribute', AttributeController::class);

    Route::get('logout', [AuthController::class, 'logout']);
});
