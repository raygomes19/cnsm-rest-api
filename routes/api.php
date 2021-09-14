<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VarietyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('stock', [VarietyController::class, 'index'])->middleware('jsonpayload');
Route::post('stock', [VarietyController::class, 'store'])->middleware('jsonpayload');
Route::put('stock/{id}', [VarietyController::class, 'update'])->middleware('jsonpayload');
Route::get('availability', [VarietyController::class, 'search'])->middleware('jsonpayload');
