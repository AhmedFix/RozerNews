<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');


Route::middleware('auth:sanctum')->group(function () {

     //category  routes
     Route::get('/categories', 'CategoriesController@index');


     //articale routes
     Route::get('/articales/{articale}/images', 'ArticalesController@images');
     Route::get('/articales/{articale}/related_articales', 'ArticalesController@relatedArticales');
     Route::get('/articales', 'ArticalesController@index');

    //articale routes
    Route::get('/articales/toggle_articale', 'ArticalesController@toggleFavorite');

    //user route
    Route::get('/user', 'AuthController@user');
});
