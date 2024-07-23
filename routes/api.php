<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;

Route::get('/dashboard', [Dashboard::class, 'index'])->middleware(['auth:sanctum', 'boss']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/auth/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
Route::get('/me', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/user', [UserController::class, 'store'])->middleware(['auth:sanctum', 'boss']);
Route::get('/coba', function () {
    $data = ["coaba" => "boleh coba"];
    return response()->json($data, 200);
});

Route::get('/order', [OrderController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/order/{id}', [OrderController::class, 'show'])->middleware(['auth:sanctum']);
Route::post('/order/{id}/kitchen', [OrderController::class, 'orderReady'])->middleware(['auth:sanctum', 'cook']);
Route::get('/order/{id}/waiter', [OrderController::class, 'serve'])->middleware(['auth:sanctum', 'retainer']);
Route::get('/order/{id}/payment', [OrderController::class, 'payment'])->middleware(['auth:sanctum', 'payment']);
Route::post('/order', [OrderController::class, 'store'])->middleware(['auth:sanctum', 'retainer']);
Route::delete('/order/{id}', [OrderController::class, 'destroy'])->middleware(['auth:sanctum', 'retainer']);

Route::get('/item', [itemController::class, 'index'])->middleware(['auth:sanctum']);
Route::post('/item', [itemController::class, 'store'])->middleware(['auth:sanctum', 'boss']);
Route::get('/item/{id}/edit', [ItemController::class, 'edit'])->middleware(['auth:sanctum', 'boss']);
Route::put('/item/{id}', [ItemController::class, 'update'])->middleware(['auth:sanctum', 'boss']);
Route::delete('/item/{id}', [ItemController::class, 'destroy'])->middleware(['auth:sanctum', 'boss']);
