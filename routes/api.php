<?php

use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider, and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix('tickets')->group(function () {
    Route::get('/', [TicketController::class, 'index']);
    Route::post('/', [TicketController::class, 'store']);

    Route::get('/{id}', [TicketController::class, 'get']);
    Route::patch('/{id}', [TicketController::class, 'update']);
    Route::patch('/{id}/classify', [TicketController::class, 'classify']);
    Route::get('/{id}/classify/check', [TicketController::class, 'checkClassification']);
    Route::get('/stats', [DashboardController::class, 'getStatistics']);
});
Route::get('/stats', [DashboardController::class, 'getStatistics']);
