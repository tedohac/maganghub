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
})->name('/')->middleware('web');

Route::group(['namespace' => 'Auth', 'middleware' => 'web'], function () {
    Route::get('/demoverify','VerifyController@demoverify');

    Route::get('/forgetpass', 'ForgetpassController@form')->name('forgetpass');
    Route::post('/forgetpass', 'ForgetpassController@process');

    Route::get('/login', 'LoginController@form')->name('login');
    Route::post('/login', 'LoginController@process');

    Route::get('/registkampus','RegisterController@kampusform')->name('registkampus');
    Route::post('/registkampus','RegisterController@kampusprocess');

    Route::get('/resetpass/{email}/{token}', 'ForgetpassController@resetpassform')->name('resetpass');

    Route::post('/resetpassprocess', 'ForgetpassController@resetpassprocess')->name('resetpassprocess');

    Route::get('/verify/{email}/{token}', 'VerifyController@verifyemail')->name('verify');

    Route::get('/verifyneeded','VerifyController@verifyneededform')->name('verifyneeded');
    Route::post('/verifyneeded','VerifyController@verifyneededprocess');
    
    Route::get('/logout', 'LoginController@logout')->name('logout');
});

Route::group(['prefix' => 'kampus', 'middleware' => 'web'], function () {
    Route::get('manage','KampusController@manage')->name('kampus.manage');
    Route::post('update','KampusController@update')->name('kampus.update');
});