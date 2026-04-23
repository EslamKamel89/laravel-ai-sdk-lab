<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Chapter2\AgentPromptingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'laravel_version' => app()->version()
    ]);
})->name('health');
Route::get('/php', fn() => phpinfo())->name('php_info');
Route::prefix('/auth')->name('auth.')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::Get('/me', [AuthController::class, 'me'])->name('me')->middleware('auth:sanctum');
});

Route::prefix('/chapter2')
    ->name('chapter2.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/hello-world', [AgentPromptingController::class, 'helloWorld'])->name('hello_world');
        Route::get('/prompt', [AgentPromptingController::class, 'promptWithInput'])->name('prompt_with_input');
    });
