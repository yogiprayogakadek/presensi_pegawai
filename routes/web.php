<?php

use Illuminate\Support\Facades\Route;


Route::namespace('Main')->middleware('auth')->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('/absensi-pegawai', 'DashboardController@absensi')->name('absensi');
    Route::get('/update/log-qr', 'DashboardController@updateLogQr')->name('update.log');
    Route::controller(DashboardController::class)->as('dashboard.')->prefix('dashboard')->group(function () {
        Route::get('/', 'index')->name('index');
    });

    Route::controller(PegawaiController::class)
        ->as('pegawai.')
        ->prefix('pegawai')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/store', 'store')->name('store');
            Route::post('/update', 'update')->name('update');
            Route::delete('/delete/{id}', 'delete')->name('delete');
        });

    Route::controller(AbsensiController::class)
        ->as('absensi.')
        ->prefix('absensi')
        ->group(function () {
            Route::get('/all', 'all')->name('all');
            Route::get('/by-name', 'byName')->name('by-name');
        });
});

Route::namespace('Pegawai')->as('staff.')->prefix('/staff')->middleware('auth')->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('/qrcode', 'DashboardController@generateQRCode')->name('qrcode');

    Route::controller(AbsensiController::class)
        ->as('absensi.')
        ->prefix('absensi')
        ->group(function () {
            Route::get('/store/{qr_code}', 'store')->name('store');
        });
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');