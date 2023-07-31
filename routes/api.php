<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('rooms', [\App\Http\Controllers\RoomController::class, 'index'])->name('rooms');
Route::get('rooms/{room}', [\App\Http\Controllers\RoomController::class, 'show'])->name('room');

Route::post('guests', [\App\Http\Controllers\GuestController::class, 'store'])->name('storeGuest');
Route::post('guests:me', [\App\Http\Controllers\GuestController::class, 'me'])->name('getGuest');

Route::post('messages', [\App\Http\Controllers\MessageController::class, 'store'])->name('storeMessage');
