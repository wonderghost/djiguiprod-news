<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategory;
use App\Http\Controllers\SubCategoryController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/category')->group(function() {
    Route::get('', [CategoryController::class, 'index']);
    Route::post('/store', [CategoryController::class, 'store']);
    Route::put('/{slug}/update', [CategoryController::class, 'update']);
    Route::delete('/{slug}/delete', [CategoryController::class, 'destroy']);
});

Route::prefix('/sub-category')->group(function() {
    Route::get('', [SubCategoryController::class, 'index']);
    Route::post('/store', [SubCategoryController::class, 'store']);
    Route::put('/{slug}/update', [SubCategoryController::class, 'update']);
    Route::delete('/{slug}/delete', [SubCategoryController::class, 'destroy']);
});
