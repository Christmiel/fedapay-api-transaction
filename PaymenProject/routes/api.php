<?php

use App\Http\Controllers\OperationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('action')->group(function () {

    Route::get('/new/transaction', [OperationController::class, 'createTransaction']);
    Route::get('/status/transaction/{id}', [OperationController::class, 'getStatus']);
});
