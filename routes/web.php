<?php

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

Route::get('/login', 'AuthController@index')->name('auth.index')->middleware('guest');
Route::post('/login', 'AuthController@login')->name('login')->middleware('guest');

Route::group(['middleware' => ['web', 'auth', 'roles']], function () {
    Route::post('/logout', 'AuthController@logout')->name('logout');

    Route::get('/my-profile', 'UserController@show')->name('my-profile');
    Route::get('/edit-profile', 'UserController@editProfile')->name('edit-profile');
    Route::patch('/update-profile/{id}', 'UserController@updateProfile')->name('update-profile');
    Route::get('/change-password', 'UserController@changePassword')->name('change-password');
    Route::patch('/update-password/{id}', 'UserController@updatePassword')->name('update-password');

    Route::group(['roles' => 'Admin'], function () {
        Route::resource('/users', 'UserController')->except(['show']);

        Route::resource('/role', 'RoleController')->except(['create', 'show']);
        Route::post('/getRole/{id}', 'RoleController@getRole');
        Route::post('/change-access', 'RoleController@changeAccess');

        Route::resource('/menu', 'MenuController')->except(['create', 'show', 'edit']);
        Route::post('/getMenu', 'MenuController@getMenu');

        Route::resource('/submenu', 'SubmenuController')->except(['create', 'show', 'edit']);;
        Route::post('/getSubmenu', 'SubmenuController@getSubmenu');
    });

    Route::group(['roles' => 'Kepala Dinas'], function () {
        Route::get('/', 'HomeController@index')->name('home');
    });

    Route::group(['roles' => 'Pegawai'], function () {
        Route::resource('/forests', 'ForestController');
    });
});
