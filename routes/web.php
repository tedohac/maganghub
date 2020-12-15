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

    Route::get('/registkampus','RegisterKampusController@form')->name('registkampus');
    Route::post('/registkampus','RegisterKampusController@process');
    
    Route::get('/registperusahaan','RegisterPerusahaanController@form')->name('registperusahaan');
    Route::post('/registperusahaan','RegisterPerusahaanController@process');

    Route::get('/resetpass/{email}/{token}', 'ForgetpassController@resetpassform')->name('resetpass');
    Route::post('/resetpassprocess', 'ForgetpassController@resetpassprocess')->name('resetpassprocess');

    Route::get('/changepass', 'ForgetpassController@changepassform')->name('changepass');
    Route::post('/changepassprocess', 'ForgetpassController@changepassprocess')->name('changepassprocess');

    Route::get('/verify/{email}/{token}', 'VerifyController@verifyemail')->name('verify');

    Route::get('/verifyneeded','VerifyController@verifyneededform')->name('verifyneeded');
    Route::post('/verifyneeded','VerifyController@verifyneededprocess');
    
    Route::get('/logout', 'LoginController@logout')->name('logout');
});

Route::group(['prefix' => 'kampus', 'middleware' => 'web'], function () {

    Route::get('list','ManageKampusController@list')->name('kampus.list');

    Route::get('detail/{id}','ManageKampusController@detail')->name('kampus.detail');

    Route::get('edit','ManageKampusController@edit')->name('kampus.edit')->middleware('cekrole:admin kampus');
    Route::post('update','ManageKampusController@update')->name('kampus.update')->middleware('cekrole:admin kampus');
    
});

Route::get('cityautocom','CityController@autocom')->name('cityautocom');
Route::get('prodiautocom','ManageProdiController@autocom')->name('prodiautocom');
Route::get('dospemautocom','ManageDospemController@autocom')->name('dospemautocom');
Route::get('lowonganautocom','ManageLowonganController@autocom')->name('lowonganautocom');

Route::group(['prefix' => 'prodi', 'middleware' => 'web'], function () {

    Route::get('manage','ManageProdiController@manage')->name('prodi.manage')->middleware('cekrole:admin kampus');
    Route::post('save','ManageProdiController@save')->name('prodi.save')->middleware('cekrole:admin kampus');
    Route::post('update','ManageProdiController@update')->name('prodi.update')->middleware('cekrole:admin kampus');
    Route::get('delete','ManageProdiController@delete')->name('prodi.delete')->middleware('cekrole:admin kampus');

    Route::get('detailjson','ManageProdiController@detailjson')->name('prodi.detailjson');
});

Route::group(['prefix' => 'dospem', 'middleware' => 'web'], function () {

    Route::get('manage','ManageDospemController@manage')->name('dospem.manage')->middleware('cekrole:admin kampus');
    Route::post('save','ManageDospemController@save')->name('dospem.save')->middleware('cekrole:admin kampus');
    Route::post('update','ManageDospemController@update')->name('dospem.update')->middleware('cekrole:admin kampus');
    Route::get('delete','ManageDospemController@delete')->name('dospem.delete')->middleware('cekrole:admin kampus');
    
    Route::get('reverify','ManageDospemController@reverify')->name('dospem.reverify')->middleware('cekrole:admin kampus');
    
    Route::get('import','ManageDospemController@importform')->name('dospem.import')->middleware('cekrole:admin kampus');
    Route::post('import','ManageDospemController@importprocess')->name('dospem.import')->middleware('cekrole:admin kampus');
    
    Route::get('detailjson','ManageDospemController@detailjson')->name('dospem.detailjson');
});


Route::group(['prefix' => 'mahasiswa', 'middleware' => 'web'], function () {

    Route::get('manage','ManageMahasiswaController@manage')->name('mahasiswa.manage')->middleware('cekrole:admin kampus');
    Route::post('save','ManageMahasiswaController@save')->name('mahasiswa.save')->middleware('cekrole:admin kampus');
    Route::post('update','ManageMahasiswaController@update')->name('mahasiswa.update')->middleware('cekrole:admin kampus');
    Route::get('delete','ManageMahasiswaController@delete')->name('mahasiswa.delete')->middleware('cekrole:admin kampus');
    
    Route::get('reverify','ManageMahasiswaController@reverify')->name('mahasiswa.reverify')->middleware('cekrole:admin kampus');

    Route::get('import','ManageMahasiswaController@importform')->name('mahasiswa.import')->middleware('cekrole:admin kampus');
    Route::post('import','ManageMahasiswaController@importprocess')->name('mahasiswa.import')->middleware('cekrole:admin kampus');
    
    Route::get('detailjson','ManageMahasiswaController@detailjson')->name('mahasiswa.detailjson');
    
    Route::get('detail/{id}','ProfilMahasiswaController@detail')->name('mahasiswa.detail')->middleware('cekrole:mahasiswa|dospem|admin kampus');
    
    Route::get('edit','ProfilMahasiswaController@edit')->name('mahasiswa.edit')->middleware('cekrole:mahasiswa');
    Route::post('updateprofile','ProfilMahasiswaController@update')->name('mahasiswa.updateprofile')->middleware('cekrole:mahasiswa');
});

Route::group(['prefix' => 'skill', 'middleware' => 'web'], function () {

    Route::get('manage','ManageSkillController@manage')->name('skill.manage')->middleware('cekrole:mahasiswa');
    Route::post('save','ManageSkillController@save')->name('skill.save')->middleware('cekrole:mahasiswa');
    Route::get('delete','ManageSkillController@delete')->name('skill.delete')->middleware('cekrole:mahasiswa');

});

Route::group(['prefix' => 'perusahaan', 'middleware' => 'web'], function () {
    
    Route::get('detail/{id}','ProfilPerusahaanController@detail')->name('perusahaan.detail');
    Route::get('edit','ProfilPerusahaanController@edit')->name('perusahaan.edit')->middleware('cekrole:perusahaan');
    Route::post('update','ProfilPerusahaanController@update')->name('perusahaan.update')->middleware('cekrole:perusahaan');
    
});

Route::group(['prefix' => 'lowongan', 'middleware' => 'web'], function () {
    
    Route::get('list','ManageLowonganController@list')->name('lowongan.list');
    Route::get('detail/{id}','ManageLowonganController@detail')->name('lowongan.detail')->middleware('cekrole:mahasiswa|dospem|perusahaan');
    Route::get('manage','ManageLowonganController@manage')->name('lowongan.manage')->middleware('cekrole:perusahaan');

    Route::get('add','ManageLowonganController@add')->name('lowongan.add')->middleware('cekrole:perusahaan');
    Route::post('add','ManageLowonganController@save')->middleware('cekrole:perusahaan');
    Route::get('edit/{id}','ManageLowonganController@edit')->name('lowongan.edit')->middleware('cekrole:perusahaan');
    Route::post('update','ManageLowonganController@update')->name('lowongan.update')->middleware('cekrole:perusahaan');
    Route::get('delete','ManageLowonganController@delete')->name('lowongan.delete')->middleware('cekrole:perusahaan');
    
});

Route::group(['prefix' => 'perekrutan', 'middleware' => 'web'], function () {
    Route::get('apply/{id}','PerekrutanController@apply')->name('perekrutan.apply')->middleware('cekrole:mahasiswa');
    Route::get('pelamar','PerekrutanController@pelamar')->name('perekrutan.pelamar')->middleware('cekrole:perusahaan');
    Route::get('detailpelamar/{id}','PerekrutanController@detailpelamar')->name('perekrutan.detailpelamar')->middleware('cekrole:perusahaan');
    
    Route::post('undang','PerekrutanController@undang')->name('perekrutan.undang')->middleware('cekrole:perusahaan');
    Route::get('kirimulangundangan/{id}','PerekrutanController@kirimulangundangan')->name('perekrutan.kirimulangundangan')->middleware('cekrole:perusahaan');
    Route::get('tolak/{id}','PerekrutanController@tolak')->name('perekrutan.tolak')->middleware('cekrole:perusahaan');
    Route::get('bataltolak/{id}','PerekrutanController@bataltolak')->name('perekrutan.bataltolak')->middleware('cekrole:perusahaan');
    
    Route::get('lamaranlist','PerekrutanController@lamaranlist')->name('perekrutan.lamaranlist')->middleware('cekrole:mahasiswa');
    Route::get('detaillamaran/{id}','PerekrutanController@detaillamaran')->name('perekrutan.detaillamaran')->middleware('cekrole:mahasiswa');
    
    Route::get('confirmundangan/{id}','PerekrutanController@confirmundangan')->name('perekrutan.confirmundangan')->middleware('cekrole:mahasiswa');
    Route::post('tolakundangan','PerekrutanController@tolakundangan')->name('perekrutan.tolakundangan')->middleware('cekrole:mahasiswa');
    
    Route::get('lulus/{id}','PerekrutanController@lulus')->name('perekrutan.lulus')->middleware('cekrole:perusahaan');
    Route::get('tdklulus/{id}','PerekrutanController@tdklulus')->name('perekrutan.tdklulus')->middleware('cekrole:perusahaan');
});

Route::group(['prefix' => 'kegiatan', 'middleware' => 'web'], function () {
    Route::get('manage','ManageKegiatanController@manage')->name('kegiatan.manage')->middleware('cekrole:mahasiswa');
    
    Route::get('add/{date}','ManageKegiatanController@add')->name('kegiatan.add')->middleware('cekrole:mahasiswa');
    Route::post('save','ManageKegiatanController@save')->name('kegiatan.save')->middleware('cekrole:mahasiswa');
    
    Route::get('edit/{date}','ManageKegiatanController@edit')->name('kegiatan.edit')->middleware('cekrole:mahasiswa');
    Route::post('update','ManageKegiatanController@update')->name('kegiatan.update')->middleware('cekrole:mahasiswa');
    
    Route::get('delete/{date}','ManageKegiatanController@delete')->name('kegiatan.delete')->middleware('cekrole:mahasiswa');
    
    Route::get('mentorview/{id}','ManageKegiatanController@mentorview')->name('kegiatan.mentorview')->middleware('cekrole:perusahaan');
    Route::get('detail/{id}/{date}','ManageKegiatanController@detail')->name('kegiatan.detail')->middleware('cekrole:perusahaan');
    Route::get('detailmhs/{id}/{date}','ManageKegiatanController@detailmhs')->name('kegiatan.detailmhs')->middleware('cekrole:mahasiswa');
    
    Route::get('verify/{id}','ManageKegiatanController@verify')->name('kegiatan.verify')->middleware('cekrole:perusahaan');
    
    Route::get('print','ManageKegiatanController@print')->name('kegiatan.print')->middleware('cekrole:mahasiswa');
    
    Route::post('finishmahasiswa','ManageKegiatanController@finishmahasiswa')->name('kegiatan.finishmahasiswa')->middleware('cekrole:mahasiswa');
    Route::post('finishperusahaan','ManageKegiatanController@finishperusahaan')->name('kegiatan.finishperusahaan')->middleware('cekrole:perusahaan');
});

Route::group(['prefix' => 'admin', 'middleware' => 'web'], function () {
    Route::get('dashboard','AdministratorController@dashboard')->name('admin.dashboard')->middleware('cekrole:superadmin');
    Route::get('kampuslist','AdministratorController@kampuslist')->name('admin.kampuslist')->middleware('cekrole:superadmin');
    Route::get('kampusdetail/{id}','AdministratorController@kampusdetail')->name('admin.kampusdetail')->middleware('cekrole:superadmin');
    Route::get('kampusverify/{id}','AdministratorController@kampusverify')->name('admin.kampusverify')->middleware('cekrole:superadmin');
    
    Route::get('perusahaanlist','AdministratorController@perusahaanlist')->name('admin.perusahaanlist')->middleware('cekrole:superadmin');
    Route::get('perusahaandetail/{id}','AdministratorController@perusahaandetail')->name('admin.perusahaandetail')->middleware('cekrole:superadmin');
    Route::get('perusahaanverify/{id}','AdministratorController@perusahaanverify')->name('admin.perusahaanverify')->middleware('cekrole:superadmin');
});