<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('app');
});

Route::get('/login',[Auth\LoginController::class,'index'])->middleware('guest');
Route::post('/login',[Auth\LoginController::class,'login']);

Route::prefix('/category')->group(function() {
    Route::get('', [CategoryController::class, 'index']);
    Route::post('/store', [CategoryController::class, 'store']);
    Route::get('/{slug}/show', [CategoryController::class, 'show']);
    Route::put('/{slug}/update', [CategoryController::class, 'update']);
    Route::delete('/{slug}/delete', [CategoryController::class, 'destroy']);
});

Route::prefix('/sub-category')->group(function() {
    Route::get('', [SubCategoryController::class, 'index']);
    Route::post('/store', [SubCategoryController::class, 'store']);
    Route::put('/{slug}/update', [SubCategoryController::class, 'update']);
    Route::delete('/{slug}/delete', [SubCategoryController::class, 'destroy']);
});

Route::prefix('article')->group(function() {
    Route::get('', [ArticleController::class, 'index']);
    Route::post('/store', [ArticleController::class, 'store']);
    Route::get('/{slug}/show', [ArticleController::class, 'show']);
    Route::put('/{slug}/update', [ArticleController::class, 'update']);
    Route::delete('/{slug}/delete', [ArticleController::class, 'destroy']);
});
