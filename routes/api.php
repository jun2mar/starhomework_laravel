<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth'], function() {
    Route::post('getProfileInfo', 'API\AccountController@getProfileInfo');
    Route::post('updateUserInfo', 'API\AccountController@updateUserInfo');

    Route::post('getHomeworks', 'API\HomeworkController@getHomeworks');
    Route::post('getSubjectList', 'API\HomeworkController@getSubjectList');
    Route::post('save_homework_detail', 'API\HomeworkController@save_homework_detail');
    Route::post('get_unpaid_homework_info', 'API\HomeworkController@get_unpaid_homework_info');
    Route::post('save_order_info', 'API\HomeworkController@save_order_info');

    // ORDER VIEW
    Route::post('get_order_main', 'API\OrderViewController@get_order_main');
    Route::post('get_order_messages', 'API\OrderViewController@get_order_messages');
    Route::post('send_order_message', 'API\OrderViewController@send_order_message');
    
    Route::post('get_order_timer', 'API\HomeworkOrderView@get_order_timer');

});
