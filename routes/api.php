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

// API Routes for PropertyType
Route::controller(PropertyTypeController::class)->group(function () {
    Route::get('/property_types', 'NewType'); // GET 
    Route::post('/property_types', 'SaveType'); // POST 
});
