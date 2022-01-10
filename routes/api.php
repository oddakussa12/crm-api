<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/blog','App\Http\Controllers\BlogController@index');
Route::get('/blog/{id}','App\Http\Controllers\BlogController@show');

Route::get('/event','App\Http\Controllers\EventController@index');
Route::get('/event/{id}','App\Http\Controllers\EventController@show');

Route::get('/contact','App\Http\Controllers\ContactController@index');
Route::get('/contact/{id}','App\Http\Controllers\ContactController@show');

// routes for auth and admin users
// Route::group(['middleware' => ['auth:sanctum','check_role']], function(){
    Route::post('/logout','App\Http\Controllers\AuthController@logout');
    
    Route::post('/blog','App\Http\Controllers\BlogController@store');
    Route::put('/blog/{id}','App\Http\Controllers\BlogController@update');
    Route::delete('/blog/{id}','App\Http\Controllers\BlogController@destroy');

    Route::post('/event','App\Http\Controllers\EventController@store');
    Route::put('/event/{id}','App\Http\Controllers\EventController@update');
    Route::delete('/event/{id}','App\Http\Controllers\EventController@destroy');
    Route::put('/event_archive/{id}','App\Http\Controllers\EventController@archive');

    Route::post('/contact','App\Http\Controllers\ContactController@store');
    Route::put('/contact/{id}','App\Http\Controllers\ContactController@update');
    Route::delete('/contact/{id}','App\Http\Controllers\ContactController@destroy');

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
// });


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register','App\Http\Controllers\AuthController@register');
Route::post('/login','App\Http\Controllers\AuthController@login');

// public resource routes
// Route::resource('blog',App\Http\Controllers\BlogController::class);
// Route::resource('category',App\Http\Controllers\CatetoryController::class);
// Route::resource('subcategory',App\Http\Controllers\SubcategoryController::class);

// Route::get('/categoryBlogs/{id}','App\Http\Controllers\CatetoryController@categoryBlogs');
// Route::get('/subcategoryBlogs/{id}','App\Http\Controllers\SubcategoryController@subcategoryBlogs');
