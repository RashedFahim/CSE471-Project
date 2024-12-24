<?php

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
use App\Http\Controllers\Backend\PropertyTypeController;

Route::controller(PropertyTypeController::class)->group(function () {
    Route::get('/new/type', 'NewType'); // Fetch all property types
    Route::post('/save/type', 'SaveType'); // Create a new property type
});




