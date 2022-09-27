<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//profile routes
Route::get('/profile', 'ProfileController@index')->name('profile');
Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit');
Route::put('/profile/update', 'ProfileController@update')->name('profile.update');

Route::name('profile.')->namespace('Profile')->group(function () {

    //password routes
    Route::get('/password/edit', 'PasswordController@edit')->name('password.edit');
    Route::put('/password/update', 'PasswordController@update')->name('password.update');
});


Route::group(['middleware' => ['auth', 'role:admin|super_admin']], function () {
    //role routes
    Route::delete('/roles/bulk_delete', 'RoleController@bulkDelete')->name('roles.bulk_delete');
    Route::resource('roles', 'RoleController');

    Route::get('assign-articale-to-category/{id}', 'CategoryController@assignArticale')->name('category.assign.articale');
    Route::post('assign-articale-to-category/{id}', 'CategoryController@storeAssignedArticale')->name('store.category.assign.articale');

    Route::resource('categories', 'CategoryController');
    Route::resource('articale', 'ArticaleController');
    Route::resource('user', 'UserController');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
