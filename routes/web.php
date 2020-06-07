<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/account/dashboard', function () { return view('pages.account.dashboard'); })->name('account_dashboard');
    Route::get('/account/profile', function () { return view('pages.account.profile'); })->name('account_profile');
    Route::get('/account/homework-list', function () { return view('pages.account.homework-list'); })->name('account_homework_list');
    Route::get('/account/homework-new', function () { return view('pages.account.homework-new'); })->name('account_homework_new');

    Route::get('/account/homework-billing/{homework_id?}', function ($request = null) {
        return view('pages.account.homework-billing')->with('request', $request);
    })->name('account_homework_billing');

    Route::get('/account/order-view/{order_id?}', function ($request = null) {
        return view('pages.account.order-view')->with('request', $request);
    })->name('account_order_view');
    // Route::get('/account/order-view/{order_id?}', 'HomeController@order_view')->name('account_order_view');


    // Route::get('/account/homework-billing/{homework_id?}', 'ProfileController@profile_save')->name('account_homework_billing');
    // Route::post('/account/profile', function () { return view('pages.account.profile'); })->name('account_profile');
    // Route::post('/account/profile/save', 'API/HomeworkController@profile_save')->name('account_profile_save');
});
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
});

Route::get('/chats', 'ChatsController@index');
Route::get('/messages', 'ChatsController@fetchMessages');
Route::post('/messages', 'ChatsController@sendMessage');
