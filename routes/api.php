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

Route::resource('blog',App\Http\Controllers\BlogController::class);
Route::resource('category',App\Http\Controllers\CatetoryController::class);
Route::resource('subcategory',App\Http\Controllers\SubcategoryController::class);

// return blogs in a category
Route::get('/categoryBlogs/{id}','App\Http\Controllers\CatetoryController@categoryBlogs');
// return blogs in a subcategory
Route::get('/subcategoryBlogs/{id}','App\Http\Controllers\SubcategoryController@subcategoryBlogs');