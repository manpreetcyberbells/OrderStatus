<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartLocationController;
use App\Http\Controllers\OrderStatusController;

Route::get('/', [OrderStatusController::class, 'statusForm']);
Route::get('/order-status', [OrderStatusController::class, 'checkOrderStatus']);