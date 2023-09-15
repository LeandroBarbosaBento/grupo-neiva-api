<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;

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

Route::get('/', function() {
    return response()->json(['api-name' => 'api-neiva']);
});

Route::prefix('auth')->group(function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('ProtectedRouteAuth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('me', [AuthController::class, 'me']);
    });
});

Route::group([
    'prefix' => 'student',
    'middleware' => 'ProtectedRouteAuth',
], function ($router) {
    Route::post('create', [StudentController::class, 'create']);
    Route::get('list', [StudentController::class, 'list']);
    Route::post('update/{id}', [StudentController::class, 'update']);
});
