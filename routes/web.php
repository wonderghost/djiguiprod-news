<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Auth\LoginController;
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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware('auth');

Route::get('/login',[Auth\LoginController::class,'index'])->middleware('guest');
Route::post('/login',[Auth\LoginController::class,'login']);
Route::post('/create-user', [Auth\LoginController::class, 'createUser']);
Route::get('/users', [Auth\LoginController::class, 'users']);
Route::get('/user', function() {
    return request()->user();
})->middleware('auth');

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

Route::prefix('client')->group(function() {
    Route::get('', [ClientBannerController::class, 'index']);
    Route::post('/store', [ClientBannerController::class, 'store']);
    Route::get('/{slug}/show', [ClientBannerController::class, 'show']);
    Route::put('/{slug}/update', [ClientBannerController::class, 'update']);
    Route::delete('/{slug}/delete', [ClientBannerController::class, 'destroy']);
});

Route::prefix('bannier')->group(function() {
    Route::get('', [BannierController::class, 'index']);
    Route::post('/store', [BannierController::class, 'store']);
    Route::get('/{slug}/show', [BannierController::class, 'show']);
    Route::put('/{slug}/update', [BannierController::class, 'update']);
    Route::delete('/{slug}/delete', [BannierController::class, 'destroy']);
});
