<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\PersonController;
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

Route::get('/', [PersonController::class, 'index']);

Route::get('/showDatabaseConnectionStatus', [PersonController::class, 'showDatabaseConnectionStatus']);

Route::post('/', [PersonController::class, 'create']);

Route::get('/{user_id}', [PersonController::class, 'find' ]);

Route::put('/{user_id}', [PersonController::class, 'update']);

Route::delete('/{user_id}', [PersonController::class, 'destroy']);