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

Route::get('/', 'ForestMapController@index');

Route::get('/login', 'AuthController@index')->name('auth.index')->middleware('guest');
Route::post('/login', 'AuthController@login')->name('login')->middleware('guest');

Route::group(['middleware' => ['web', 'auth', 'roles']], function () {
    Route::post('/logout', 'AuthController@logout')->name('logout');

    Route::get('/my-profile', 'UserController@show')->name('my_profile');
    Route::get('/edit-profile', 'UserController@editProfile')->name('edit_profile');
    Route::patch('/update-profile/{id}', 'UserController@updateProfile')->name('update-profile');
    Route::get('/change-password', 'UserController@changePassword')->name('change_password');
    Route::patch('/update-password/{id}', 'UserController@updatePassword')->name('update-password');

    Route::group(['roles' => 'Staff IT'], function () {
        Route::resource('/users', 'UserController')->except(['show']);
        Route::patch('/users/password-reset/{id}', 'UserController@resetPassword')->name('users.password_reset');
        Route::get('/users/softdelete/{id}', 'UserController@softdelete')->name('users.delete');
        Route::get('/users/trash', 'UserController@trash')->name('users.trash');
        Route::get('/users/restore/{id}', 'UserController@restore')->name('users.restore');
        Route::get('/users/restore', 'UserController@restoreAll')->name('users.restore_all');

        Route::resource('/role', 'RoleController')->except(['create', 'show']);
        Route::post('/getRole/{id}', 'RoleController@getRole');
        Route::post('/change-access', 'RoleController@changeAccess');

        Route::resource('/menu', 'MenuController')->except(['create', 'show', 'edit']);
        Route::post('/getMenu', 'MenuController@getMenu');

        Route::resource('/submenu', 'SubmenuController')->except(['create', 'show', 'edit']);;
        Route::post('/getSubmenu', 'SubmenuController@getSubmenu');
    });

    Route::group(['roles' => 'Kepala Dinas'], function () {
        Route::get('/dashboard', 'HomeController@dashboard');
    });

    Route::group(['roles' => 'Pegawai'], function () {
        /*
        * Forests Routes
        */
        Route::get('/community_forests', 'ForestMapController@index')->name('forest_map.index');
        Route::resource('forests', 'ForestController');
    });
});
