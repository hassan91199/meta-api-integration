<?php

use App\Http\Controllers\MetatraderAccountController;
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

Route::post('/metatrader-accounts', [MetatraderAccountController::class, 'store']);
Route::post('/metatrader-accounts/historical-trades', [MetatraderAccountController::class, 'getHistoricalTrades']);
