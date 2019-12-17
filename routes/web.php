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
Route::post('admin/save-category', 'Admin\HomeController@saveCategory')->name('save-category'); ;

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
Route::get('admin/category-list', ['uses'=>'Admin\HomeController@categoryList', 'as'=>'admin.category-list']);
Route::get('admin/category-details/{id}', ['uses'=>'Admin\HomeController@categoryDetails', 'as'=>'admin.category-details']);
Route::get('admin/category-delete/{id}', ['uses'=>'Admin\HomeController@categoryDelete', 'as'=>'admin.category-delete']);

Route::post('admin/save-user', 'UserController@addEdituser')->name('save-user'); 



Route::get('/admin/manage-prayer', 'Admin\PrayerController@managePrayer')   ; 
Route::get('admin/prayer-list', ['uses'=>'Admin\PrayerController@prayerList', 'as'=>'admin.prayer-list']);
Route::post('admin/save-prayer', 'Admin\PrayerController@savePrayer')->name('save-prayer'); 
Route::get('admin/prayer-details/{idprayers}', 'Admin\PrayerController@prayerDetails')->name('prayer-details');
Route::get('admin/prayer-delete/{idprayers}', 'Admin\PrayerController@prayerDelete')->name('prayer-delete'); 

Route::get('admin/manage-users','Admin\HomeController@ListUser');
Route::get('users', ['uses'=>'UserController@index', 'as'=>'users.index']);


Route::get('/admin/manage-dates', 'Admin\HomeController@manageDate')   ; 
Route::post('admin/load-date-content', 'Admin\HomeController@loadBibleDateContent')->name('load-date-content'); 
Route::post('admin/save-bible-date', 'Admin\HomeController@saveBibleDateContent')->name('save-bible-date'); 

Route::get('/admin/set-language/{id}', 'Admin\SettingsController@saveLanguage')   ; 
Route::get('/admin/language', 'Admin\SettingsController@addLanguage')   ; 
Route::post('/admin/save-language', 'Admin\SettingsController@newLanguageSave')->name('save-language')   ; 
Route::get('/admin/edit-language/{id}', 'Admin\SettingsController@addLanguage')   ; 


Route::get('/admin/patron', 'Admin\SettingsController@patronData')   ; 
Route::post('/admin/save-patron', 'Admin\SettingsController@patronDataSave')->name('save-patron')   ; 

Route::get('/admin/app-message', 'Admin\SettingsController@appMessage')   ; 
Route::post('/admin/save-message', 'Admin\SettingsController@messageDataSave')->name('save-message')   ; 



// Route::get('import-export-csv-excel',array('as'=>'excel.import','uses'=>'FileController@importExportExcelORCSV'));
// Route::post('import-csv-excel',array('as'=>'import-csv-excel','uses'=>'FileController@importFileIntoDB'));
// Route::get('download-excel-file/{type}', array('as'=>'excel-file','uses'=>'FileController@downloadExcelFile'));

Route::get('download-prayer-file/{type}', array('as'=>'excel-file-prayer','uses'=>'FileController@downloadExcelFilePrayer'));
Route::post('import-prayer',array('as'=>'import-prayer','uses'=>'FileController@importExcelFilePrayer'));

Route::get('download-bibledata-file/{type}', array('as'=>'excel-file-prayer','uses'=>'FileController@downloadExcelFileBibleDate'));
Route::post('import-bibledata',array('as'=>'import-bibledata','uses'=>'FileController@importExcelFileBibleData'));


