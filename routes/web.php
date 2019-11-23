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

Route::get('/', 'Admin\LoginController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// admin Guest Route Start
Route::get('/admin/login', 'Admin\LoginController@index')   ; 
Route::post('/admin/auth', 'Admin\LoginController@checkLogin')    
    ->name('admin_login');

 // Eof admin Guest Route   
Route::get('/admin/dashboard', 'Admin\HomeController@dashboard')    
    ->middleware('is_admin')    
    ->name('admin');
Route::get('/admin/manage-category', 'Admin\HomeController@manageCategory')   ; 

Route::get('/admin/manage-user', 'Admin\HomeController@manageUser')   ; 

Route::get('admin/list-users','Admin\HomeController@ListUser');
Route::get('users', ['uses'=>'UserController@index', 'as'=>'users.index']);
