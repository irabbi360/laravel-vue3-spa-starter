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


Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::apiResource('posts', \App\Http\Controllers\Api\PostController::class);
    Route::apiResource('categories', \App\Http\Controllers\Api\CategoryController::class);
    Route::get('category-list', [\App\Http\Controllers\Api\CategoryController::class, 'getList']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('abilities', function(Request $request) {
        return $request->user()->roles()->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('name')
            ->unique()
            ->values()
            ->toArray();
    });
});
