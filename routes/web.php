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
    return view('welcome');
});

Route::namespace('Auth')->group(function () {
    Route::get('/login', 'LoginController@loginform')->name('login');
    Route::post('/login', 'LoginController@loginprocess');
    Route::get('/registkampus','RegisterController@kampusform')->name('registkampus');
    Route::post('/registkampus','RegisterController@kampusprocess');
    Route::get('/verify/{email}/{token}', 'VerifyController@verifyemail')->name('verify');
    Route::get('/demoverify','VerifyController@demoverify');
    Route::get('/verifyneeded','VerifyController@verifyneededform')->name('verifyneeded');
    Route::post('/verifyneeded','VerifyController@verifyneededprocess');
  });
