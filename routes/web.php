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
Route::get('/forest/{forest}', 'ForestController@show')->name('forests.show');

Route::group(['middleware' => ['web', 'auth', 'roles']], function () {
    Route::post('/logout', 'AuthController@logout')->name('logout');

    Route::get('/my-profile', 'UserController@myProfile')->name('my_profile');
    Route::get('/edit-profile', 'UserController@editProfile')->name('edit_profile');
    Route::patch('/update-profile/{id}', 'UserController@updateProfile')->name('update_profile');
    Route::get('/change-password', 'UserController@changePassword')->name('change_password');
    Route::patch('/update-password/{id}', 'UserController@updatePassword')->name('update_password');

    //ajax
    Route::get('/get-user','UserController@getUser')->name('ajax.get_user');
    Route::get('/get-user-deleted','UserController@getUserDeleted')->name('ajax.get_user_deleted');
    Route::get('/get-forest','ForestController@getForest')->name('ajax.get_forest');

    Route::group(['roles' => 'Staff IT'], function () {
        Route::resource('/users', 'UserController')->except(['show']);
        Route::patch('/users/password-reset/{id}', 'UserController@resetPassword')->name('users.password_reset');
        Route::delete('/users/delete/{id}', 'UserController@deleteUser')->name('users.delete');
        Route::get('/users/deleted', 'UserController@showDeleted')->name('users.deleted');
        Route::put('/users/restore/{id}', 'UserController@restore')->name('users.restore');
        Route::patch('/users/restore/all/user', 'UserController@restoreAll')->name('users.restore_all');

        Route::resource('/role', 'RoleController')->except(['create', 'show']);
        Route::post('/getRole/{id}', 'RoleController@getRole');
        Route::post('/change-access', 'RoleController@changeAccess');

        Route::resource('/menu', 'MenuController')->except(['create', 'show', 'edit']);
        Route::post('/getMenu', 'MenuController@getMenu');

        Route::resource('/submenu', 'SubmenuController')->except(['create', 'show', 'edit']);
        Route::get('/getSubmenu', 'SubmenuController@getSubmenu')->name('ajax.get.submenu');
        Route::post('/getSubmenu/edit', 'SubmenuController@getEditSubmenu')->name('ajax.get.edit.submenu');
    });

    Route::group(['roles' => 'Kepala Dinas'], function () {
        Route::get('/users/{user}', 'UserController@show')->name('users.show');
        Route::get('/dashboard', 'HomeController@index');
        Route::put('/forest/verify/{forest}/approving','ForestController@approving')->name('forest.approving');
        Route::patch('/forest/verify/{forest}/rejecting','ForestController@rejecting')->name('forest.rejecting');
    });

    Route::group(['roles' => 'Pegawai'], function () {
        Route::get('/community_forests', 'ForestMapController@index')->name('forest_map.index');
        Route::resource('forests', 'ForestController')->except(['show']);
    });
});
