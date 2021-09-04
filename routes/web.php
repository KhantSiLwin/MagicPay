<?php

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
// admin
Route::get('/admin/login', 'Auth\AdminLoginController@showLoginForm');

Route::post('/admin/login', 'Auth\AdminLoginController@login')->name('admin.login');

Route::post('/admin/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');


// user
Auth::routes();

    Route::middleware('auth')->namespace('Frontend')->group(function(){
        Route::get('/', 'PageController@home')->name('home');

        Route::get('/profile', 'PageController@profile')->name('profile');
        Route::get('/update-password', 'PageController@updatePassword')->name('update-password');
        Route::post('/update-password', 'PageController@updatePasswordStore')->name('update-password.store');
        Route::get('/wallet', 'PageController@wallet')->name('wallet');

        Route::get('/transfer', 'PageController@transfer')->name('transfer');
    
        Route::get('/transfer/confirm', 'PageController@transferConfirm');

        Route::get('/to-account-verify', 'PageController@toAccountVerify');

        Route::post('/transfer/complete', 'PageController@transferComplete');

        Route::post('/transfer/password-check', 'PageController@passwordCheck');

        Route::get('/transaction', 'PageController@transaction');
    
        Route::get('/transaction/{trx_id}', 'PageController@transactionDetail');

        Route::get('/transfer-hash', 'PageController@transferHash');

        Route::get('/recieve-qr', 'PageController@recieveQR');

        Route::get('/scan-and-pay', 'PageController@scanAndPay');

        Route::get('/scan-and-pay-form', 'PageController@scanAndPayform');

        Route::get('/scan-and-pay/confirm', 'PageController@scanAndPayConfirm');

        Route::post('/scan-and-pay/complete', 'PageController@scanAndPayComplete');

        Route::post('/scan-and-pay/password-check', 'PageController@passwordCheck');

        Route::get('/notification', 'NotificationController@index');

        Route::get('/notification/{id}', 'NotificationController@show');
    });


