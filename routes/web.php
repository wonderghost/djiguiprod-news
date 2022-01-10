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
Route::get('/request/users', [Auth\LoginController::class, 'users']);
Route::get('/request/user', function() {
    return request()->user();
})->middleware('auth');

Route::post('/request/logout', [Auth\LoginController::class, 'logout']);

Route::prefix('/request/category')->group(function() {
    Route::get('', [CategoryController::class, 'index']);
    Route::post('/store', [CategoryController::class, 'store'])->middleware('auth');
    Route::get('/{slug}/show', [CategoryController::class, 'show']);
    Route::put('/{slug}/update', [CategoryController::class, 'update'])->middleware('auth');
    Route::delete('/{slug}/delete', [CategoryController::class, 'destroy'])->middleware('auth');
});

Route::prefix('/request/sub-category')->group(function() {
    Route::get('', [SubCategoryController::class, 'index']);
    Route::post('/store', [SubCategoryController::class, 'store'])->middleware('auth');
    Route::put('/{slug}/update', [SubCategoryController::class, 'update'])->middleware('auth');
    Route::delete('/{slug}/delete', [SubCategoryController::class, 'destroy'])->middleware('auth');
});

Route::prefix('/request/article')->group(function() {
    Route::get('', [ArticleController::class, 'index']);
    Route::post('/store', [ArticleController::class, 'store'])->middleware('auth');
    Route::get('/{slug}/show', [ArticleController::class, 'show']);
    Route::post('/{slug}/update', [ArticleController::class, 'update'])->middleware('auth');
    Route::delete('/{slug}/delete', [ArticleController::class, 'destroy'])->middleware('auth');
});

Route::get('/request/search', [ArticleController::class, 'search']);
Route::get('/request/categorie/{slug}', [ArticleController::class, 'articleByCategory']);
Route::get('/request/articles/{idSubCategory}', [ArticleController::class, 'articleBySubCategory']);

Route::prefix('/request/client')->group(function() {
    Route::get('', [ClientBannerController::class, 'index']);
    Route::post('/store', [ClientBannerController::class, 'store'])->middleware('auth');
    Route::get('/{slug}/show', [ClientBannerController::class, 'show']);
    Route::put('/{slug}/update', [ClientBannerController::class, 'update'])->middleware('auth');
    Route::delete('/{slug}/delete', [ClientBannerController::class, 'destroy'])->middleware('auth');
});

Route::prefix('/request/banner')->group(function() {
    Route::get('', [BannerController::class, 'index']);
    Route::post('/store', [BannerController::class, 'store'])->middleware('auth');
    Route::get('/{slug}/show', [BannerController::class, 'show']);
    Route::post('/{slug}/update', [BannerController::class, 'update'])->middleware('auth');
    Route::delete('/{slug}/delete', [BannerController::class, 'destroy'])->middleware('auth');
});

Route::post('/request/newsletter', [NewsletterController::class, 'store']);
Route::get('/request/sendMail', [ArticleController::class, 'sendMail']);

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
