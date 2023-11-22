<?php

use App\Http\Controllers\Agent\DelayQueueController;
use App\Http\Controllers\Order\DelayController;
use App\Http\Controllers\Statistics\VendorController;
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
Route::group(['prefix' => 'orders', 'as' => 'order.'], function () {
    Route::post('delay_order', [DelayController::class, 'delay'])->name('delay');
});

Route::group(['prefix' => 'agent', 'as' => 'delayQueue.'], function () {
    Route::post('pick_delay_queue', [DelayQueueController::class, 'pickDelayQueue'])->name('pick_delay_queue');
});

Route::group(['prefix' => 'statistics', 'as' => 'statistics.'], function () {
    Route::get('vendor_delayed', [VendorController::class, 'vendorDelayed'])->name('delayed_vendor');
});
