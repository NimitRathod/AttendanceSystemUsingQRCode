<?php
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

    // QR-Code
    Route::resource('qrcode','Backend\qrcodecontroller');

    Route::get('qrcode','Backend\qrcodecontroller@genrate_qr_code')->name('qrcode');

    // Call the Chanhe Password blade file
    Route::view('changePassword', 'backend.templates.All_Pages.changePassword')->name('change_password');
    // Request the Change password Method
    Route::post('changePassword', 'Auth\Custom\CustomController@reset')->name('change_password.reset');



});
