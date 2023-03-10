<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::controller(AuthController::class)
    ->group(function () {
        Route::post('/forgot-password', 'forgotPassword')->name('forgotPassword');
        Route::post('/reset-password', 'resetPassword')->name('resetPassword');
    });

    Route::get('/reset-password/{token}', function ($token) {
        return ['token' => $token];
    })->middleware('guest')->name('password.reset');

    Route::controller(AuthController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('/logout', 'logout')->name('logout');
        Route::get('/user-profile', 'userProfile')->name('userProfile');
    });

Route::controller(UserController::class)
->middleware('auth:sanctum')
->prefix('users')
->group(function(){
    Route::get('/', 'index');
    Route::get('/{user}', 'show');
    Route::put('/{user}', 'update');
    Route::delete('/{user}', 'destroy');
});
