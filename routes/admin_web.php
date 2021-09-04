<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
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

Route::prefix('admin')->name('admin.')->namespace('Backend')->middleware('auth:admin_user')->group(function(){
    Route::get('/','PageController@home')->name('home');
//admin user crud
    Route::resource('admin-user','AdminUserController');

    Route::get('/admin-user/datatables/ssd','AdminUserController@ssd');

//user crud
    Route::resource('user','UserController');

    Route::get('user/datatables/ssd','UserController@ssd');

//wallet
    Route::get('wallet','WalletController@index')->name('wallet.index');

    Route::get('/wallet/datatables/ssd','WalletController@ssd');

});
