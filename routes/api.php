<?php

use App\Http\Controllers\AutorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('autors', AutorController::class);
Route::apiResource('livros', LivroController::class);

Route::prefix('v1')->group(function () {

    // Clientes
    Route::get('clientes', [ClienteController::class, 'index']);      // Lista todos
    Route::post('clientes', [ClienteController::class, 'store']);     // Cria novo
    Route::get('clientes/{id}', [ClienteController::class, 'show']);  // Busca por ID

    // Endereços
    Route::get('enderecos', [EnderecoController::class, 'index']);    // Lista todos
    Route::post('enderecos', [EnderecoController::class, 'store']);   // Cria novo
    Route::get('enderecos/{id}', [EnderecoController::class, 'show']); // Busca por ID
});
