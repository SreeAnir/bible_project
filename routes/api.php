<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('testpush','Api\ApiController@testpush');
Route::get('get-all-bibledata','Api\ApiController@getAllBibledata');
Route::get('get-all-prayer','Api\ApiController@getAllPrayer');
Route::get('get-all-prayertypes','Api\ApiController@getAllPrayerTypes');
Route::get('get-prayer-by-type','Api\ApiController@getAllPrayerByType');
Route::get('get-bible-by-date','Api\ApiController@getBibleByDate');

Route::get('get-app-message','Api\ApiController@getAppMessage');
Route::get('get-patron','Api\ApiController@getPatronData');
Route::get('get-splash-data','Api\ApiController@getSplashData');
Route::post('update-device-token','Api\ApiController@uptateToken');
// Route::get('update-device-token','Api\ApiController@uptateToken');
