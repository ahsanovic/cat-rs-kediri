<?php

Auth::routes(['register' => false]);

// SKD
Route::get('/', function() {
    return view('tes.welcome');
});
Route::get('/login', 'Auth\PesertaLoginController@showLoginForm')->name('login-form');
Route::post('/login', 'Auth\PesertaLoginController@login')->name('login');
Route::get('/compare', 'CompareController@compare')->name('compare');
Route::get('/compare-skb', 'CompareController@compareskb')->name('compare-skb');
Route::group(['middleware' => 'auth:peserta'], function() {
    Route::get('/ujian', 'UjianController@index')->name('ujian');
    Route::post('/ujian', 'UjianController@store')->name('ujian.store');
    Route::post('/ujian/{id}', 'UjianController@update')->name('ujian.update');
    Route::get('/ujian/{id}', 'UjianController@show')->name('ujian.show');
    Route::delete('/ujian/{peserta}', 'UjianController@destroy')->name('ujian.destroy');
    Route::post('/logout', 'Auth\PesertaLoginController@logout')->name('ujian.logout');
});

// SKB
Route::prefix('/skb')->group(function() {
    Route::get('/', 'Auth\PesertaSkbLoginController@showLoginForm')->name('login-skb.form');
    Route::post('/', 'Auth\PesertaSkbLoginController@login')->name('login-skb');
    Route::group(['middleware' => 'auth:peserta-skb'], function() {
        Route::get('/ujian', 'UjianSkbController@index')->name('ujian-skb');
        Route::post('/ujian', 'UjianSkbController@store')->name('ujian-skb.store');
        Route::post('/ujian/{id}', 'UjianSkbController@update')->name('ujian-skb.update');
        Route::get('/ujian/{id}', 'UjianSkbController@show')->name('ujian-skb.show');
        Route::delete('/ujian/{peserta}', 'UjianSkbController@destroy')->name('ujian-skb.destroy');
        Route::post('/logout', 'Auth\PesertaSkbLoginController@logout')->name('logout-skb');
    });
});

// Simulasi
Route::prefix('/simulasi')->group(function() {
    Route::get('/', function() {
        return view('simulasi.welcome');
    });
    Route::get('/login', 'Auth\PesertaSimLoginController@showLoginForm')->name('login-sim.form');
    Route::post('/login', 'Auth\PesertaSimLoginController@login')->name('login-sim');
    Route::get('/register', 'Auth\PesertaSimLoginController@showRegisterForm');
    Route::post('/register', 'Auth\PesertaSimLoginController@register')->name('register-sim');
    Route::group(['middleware' => 'auth:peserta-sim'], function() {
        Route::get('/ujian', 'UjianSimController@index')->name('ujian-sim');
        Route::post('/ujian', 'UjianSimController@store')->name('ujian-sim.store');
        Route::post('/ujian/{id}', 'UjianSimController@update')->name('ujian-sim.update');
        Route::get('/ujian/{id}', 'UjianSimController@show')->name('ujian-sim.show');
        Route::delete('/ujian/{peserta}', 'UjianSimController@destroy')->name('ujian-sim.destroy');
        Route::post('/logout', 'Auth\PesertaSimLoginController@logout')->name('logout-sim');
    });
});

// Admin
Route::prefix('/admin')->group(function() {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('login-admin');
    Route::group(['middleware' => 'auth:admin'], function() {
        Route::get('/', 'AdminController@index')->name('home');

        /* setting ujian */
        Route::livewire('/setting-ujian', 'setting-ujian-index')->name('setting-ujian');

        /* peserta & user */
        Route::livewire('/user', 'user-index')->name('user');
        Route::livewire('/peserta', 'peserta-index')->name('peserta');
        Route::livewire('/peserta-skb', 'peserta-skb-index')->name('peserta-skb');
        Route::livewire('/peserta-sim', 'peserta-sim-index')->name('peserta-sim');
        Route::patch('/peserta', 'PesertaController@blokir')->name('blokir-peserta-skd');
        Route::patch('/peserta/unblock', 'PesertaController@unblock')->name('unblock-peserta-skd');
        Route::patch('/peserta-skb', 'PesertaSkbController@blokir')->name('blokir-peserta-skb');
        Route::patch('/peserta-skb/unblock', 'PesertaSkbController@unblock')->name('unblock-peserta-skb');

        /* data master */
        Route::livewire('/jenis-soal', 'jenis-soal-index')->name('jenis-soal');
        Route::livewire('/bidang', 'bidang-index')->name('bidang');
        Route::livewire('/subbidang', 'sub-bidang-index')->name('subbidang');
        Route::livewire('/rumpun', 'rumpun-index')->name('rumpun');
        Route::livewire('/jabatan', 'jabatan-index')->name('jabatan');

        /* soal skd */
        Route::get('/soal', 'SoalController@index')->name('soal');
        Route::get('/soal/create', 'SoalController@create')->name('soal.create');
        Route::get('/soal/create/get-bidang', 'SoalController@getBidangList')->name('get-bidang');
        Route::get('/soal/create/get-subbidang', 'SoalController@getSubBidangList')->name('get-subbidang');
        Route::post('/soal', 'SoalController@store')->name('soal.store');
        Route::post('/soal/image', 'SoalController@uploadImage')->name('soal.image');
        Route::get('/soal/edit/{id}', 'SoalController@edit')->name('soal.edit');
        Route::get('/soal/view/{id}', 'SoalController@view')->name('soal.view');
        Route::patch('/soal/update', 'SoalController@update')->name('soal.update');
        Route::delete('/soal/delete/{id}', 'SoalController@destroy')->name('soal.destroy');

        /* soal skb */
        Route::get('/soal-skb', 'SoalSkbController@index')->name('soal-skb');
        Route::get('/soal-skb/create', 'SoalSkbController@create')->name('soal-skb.create');
        Route::get('/soal-skb/create/get-rumpun', 'SoalSkbController@getRumpunList')->name('get-rumpun');
        Route::get('/soal-skb/create/get-jabatan', 'SoalSkbController@getJabatanList')->name('get-jabatan');
        Route::post('/soal-skb', 'SoalSkbController@store')->name('soal-skb.store');
        Route::post('/soal-skb/image', 'SoalSkbController@uploadImage')->name('soal-skb.image');
        Route::get('/soal-skb/edit/{id}', 'SoalSkbController@edit')->name('soal-skb.edit');
        Route::get('/soal-skb/view/{id}', 'SoalSkbController@view')->name('soal-skb.view');
        Route::patch('/soal-skb/update', 'SoalSkbController@update')->name('soal-skb.update');
        Route::delete('/soal-skb/delete/{id}', 'SoalSkbController@destroy')->name('soal-skb.destroy');

        /* soal simulasi skd */
        Route::get('/soal-sim', 'SoalSimController@index')->name('soal-sim');
        Route::get('/soal-sim/create', 'SoalSimController@create')->name('soal-sim.create');
        Route::get('/soal-sim/create/get-bidang', 'SoalSimController@getBidangList')->name('get-bidang');
        Route::get('/soal-sim/create/get-subbidang', 'SoalSimController@getSubBidangList')->name('get-subbidang');
        Route::post('/soal-sim', 'SoalSimController@store')->name('soal-sim.store');
        Route::post('/soal-sim/image', 'SoalSimController@uploadImage')->name('soal-sim.image');
        Route::get('/soal-sim/edit/{id}', 'SoalSimController@edit')->name('soal-sim.edit');
        Route::get('/soal-sim/view/{id}', 'SoalSimController@view')->name('soal-sim.view');
        Route::patch('/soal-sim/update', 'SoalSimController@update')->name('soal-sim.update');
        Route::delete('/soal-sim/delete/{id}', 'SoalSimController@destroy')->name('soal-sim.destroy');

        /* hasil tes */
        Route::livewire('/hasil-sim', 'hasil-sim-index')->name('hasil-sim');
        Route::livewire('/hasil-skb', 'hasil-skb-index')->name('hasil-skb');
        Route::livewire('/hasil', 'hasil-index')->name('hasil');

        /* livescore */
        Route::livewire('/live-sim', 'live-sim-index')->name('live-sim');
        Route::livewire('/live-skb', 'live-skb-index')->name('live-skb');
        Route::livewire('/live', 'live-index')->name('live');
	Route::patch('/live/reset-skd', 'LiveController@resetWaktuSkd')->name('reset-waktu-ujian-skd');
	Route::patch('/live-skb/reset-skb', 'LiveController@resetWaktuSkb')->name('reset-waktu-ujian-skb');

        /* import & export excel */
        Route::get('/export-excel', 'PesertaController@exportExcel')->name('export');
        Route::post('/import-excel', 'PesertaController@importExcel')->name('import');
        Route::get('/export-excel-skb', 'PesertaSkbController@exportExcel')->name('export-skb');
        Route::post('/import-excel-skb', 'PesertaSkbController@importExcel')->name('import-skb');
        Route::get('/download', 'PesertaController@getDownload');
        Route::get('/download-skb', 'PesertaSkbController@getDownload');
        Route::get('/export-excel-sim', 'PesertaSimController@exportExcel')->name('export-sim');
        Route::post('/import-excel-sim', 'PesertaSimController@importExcel')->name('import-sim');
        Route::get('/export-hasil-sim', 'HasilController@exportExcelSimulasi')->name('export-hasil-sim');
        Route::get('/export-hasil', 'HasilController@exportExcel')->name('export-hasil');
        Route::get('/export-hasil-skb', 'HasilController@exportExcelSkb')->name('export-hasil-skb');

        Route::post('/logout', 'Auth\AdminLoginController@logout')->name('logout');
    });
});

// Livescore
Route::get('/livescore', 'LiveController@index')->name('livescore');
Route::get('/livescore-skb', 'LiveController@liveSkb')->name('livescore-skb');
