<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\ProdutoController;
use App\Http\Controllers\Api\AuthController;


// Rotas públicas
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rotas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('categorias', CategoriaController::class);
    Route::apiResource('produtos', ProdutoController::class);
});


