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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// public resource routes
// Route::resource('blog',App\Http\Controllers\BlogController::class);
// Route::resource('category',App\Http\Controllers\CatetoryController::class);
// Route::resource('subcategory',App\Http\Controllers\SubcategoryController::class);

Route::get('/blog','App\Http\Controllers\BlogController@index');
Route::get('/blog/{id}','App\Http\Controllers\BlogController@show');

 Route::get('/categoryBlogs/{id}','App\Http\Controllers\CatetoryController@categoryBlogs');
 Route::get('/subcategoryBlogs/{id}','App\Http\Controllers\SubcategoryController@subcategoryBlogs');

Route::post('/register','App\Http\Controllers\AuthController@register');
Route::post('/login','App\Http\Controllers\AuthController@login');


// routes for auth and admin users
Route::group(['middleware' => ['auth:sanctum','check_role']], function(){
    Route::post('/logout','App\Http\Controllers\AuthController@logout');
    Route::post('/blog','App\Http\Controllers\BlogController@store');
    Route::put('/blog/{id}','App\Http\Controllers\BlogController@update');
    Route::delete('/blog/{id}','App\Http\Controllers\BlogController@destroy');

    Route::get('/category','App\Http\Controllers\CatetoryController@index');
    Route::get('/category/{id}','App\Http\Controllers\CatetoryController@show');
    Route::post('/category','App\Http\Controllers\CatetoryController@store');
    Route::put('/category/{id}','App\Http\Controllers\CatetoryController@update');
    Route::delete('/category/{id}','App\Http\Controllers\CatetoryController@destroy');

    Route::get('/subcategory','App\Http\Controllers\SubcategoryController@index');
    Route::get('/subcategory/{id}','App\Http\Controllers\SubcategoryController@show');
    Route::post('/subcategory','App\Http\Controllers\SubcategoryController@store');
    Route::put('/subcategory/{id}','App\Http\Controllers\SubcategoryController@update');
    Route::delete('/subcategory/{id}','App\Http\Controllers\SubcategoryController@destroy');
});