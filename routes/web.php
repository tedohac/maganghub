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

    Route::get('list','KampusController@list')->name('kampus.list');

    Route::get('detail/{id}','KampusController@detail')->name('kampus.detail');

    Route::get('edit','KampusController@edit')->name('kampus.edit')->middleware('cekrole:admin kampus');
    Route::post('update','KampusController@update')->name('kampus.update')->middleware('cekrole:admin kampus');
    
});

Route::get('cityautocom','CityController@autocom')->name('cityautocom');

Route::group(['prefix' => 'prodi', 'middleware' => 'web'], function () {

    Route::get('manage','ProdiController@manage')->name('prodi.manage')->middleware('cekrole:admin kampus');
    Route::post('save','ProdiController@save')->name('prodi.save')->middleware('cekrole:admin kampus');
    Route::post('update','ProdiController@update')->name('prodi.update')->middleware('cekrole:admin kampus');
    Route::get('delete','ProdiController@delete')->name('prodi.delete')->middleware('cekrole:admin kampus');

    Route::get('detailjson','ProdiController@detailjson')->name('prodi.detailjson');
});

Route::group(['prefix' => 'dospem', 'middleware' => 'web'], function () {

    Route::get('manage','DospemController@manage')->name('dospem.manage')->middleware('cekrole:admin kampus');
});