<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureTokenIsValid;
use App\Http\Middleware\EnsureAdminIsValid;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware([EnsureTokenIsValid::class, EnsureAdminIsValid::class])->group(function () {
    Route::group(['prefix'=>'user'], function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/login', [UserController::class, 'login'])->withoutMiddleware([EnsureAdminIsValid::class]);
        Route::post('/register', [UserController::class, 'register'])->withoutMiddleware([EnsureAdminIsValid::class]);
        Route::put('/update', [UserController::class, 'update']);
        // Route::get('/{id}', [UserController::class, 'show']);
        // Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });
});
