<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderStatusController;

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});
Route::get('/', [OrderStatusController::class, 'statusForm']);
Route::get('/order-status', [OrderStatusController::class, 'checkOrderStatus']);