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

/* Route::get('/', function () {
    return view('welcome');
}); */

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::redirect('/','/bck');

Auth::routes(['register' => false]);

// Backend Default Page
Route::group(['prefix'=>'/bck','middleware' => ['auth']], function () {

    Route::get('/default', function () {
        return view('backend.default');
    });

    //Profile
    Route::get('/profile', function () {
        return view('backend.templates.profile.show');
    });

    // Dashboard Page
    Route::get('/', function () {
        return view('backend.templates.empty_page');
    });

    Route::get('users/getData', ['as'=>'users.getData','uses'=>'spatie\UserController@getData']);
    Route::resource('users', 'spatie\UserController');
    Route::get('roles/getData', ['as'=>'roles.getData','uses'=>'spatie\RoleController@getData']);
    Route::resource('roles', 'spatie\RoleController');
    Route::get('permissions/getData', ['as'=>'permissions.getData','uses'=>'spatie\PermissionController@getData']);
    Route::resource('permissions', 'spatie\PermissionController');

    Route::view('changePassword', 'backend.templates.All_Pages.changePassword')->name('change_password');
});
