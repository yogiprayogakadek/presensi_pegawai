<?php

use Illuminate\Support\Facades\Route;


Route::namespace('Main')->middleware(['auth', 'checkRole:admin', 'checkStatus'])->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('/absensi-pegawai', 'DashboardController@absensi')->name('absensi');
    Route::get('/update/log-qr', 'DashboardController@updateLogQr')->name('update.log');
    Route::get('/config/database', 'DashboardController@configDB')->name('config.database');
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

    Route::controller(ConfigController::class)
        ->as('config.')
        ->prefix('config')
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
            Route::prefix('all')->as('all.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/filter', 'filter')->name('filter');
                Route::post('/printAll', 'printAll')->name('printAll');
            });

            Route::prefix('by-name')->as('by-name.')->group(function () {
                Route::get('/', 'byNameIndex')->name('index');
                Route::post('/filter', 'byNamefilter')->name('filter');
                Route::post('/print', 'print')->name('print');
            });
        });
});

Route::namespace('Pegawai')->as('staff.')->prefix('/staff')->middleware(['auth', 'checkStatus'])
    ->group(function () {
        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::get('/qrcode', 'DashboardController@generateQRCode')->name('qrcode');

        Route::controller(AbsensiController::class)
            ->as('absensi.')
            ->prefix('absensi')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/filter', 'filter')->name('filter');
                Route::post('/print', 'print')->name('print');
                Route::get('/store/{qr_code}', 'store')->name('store');
            });

        Route::controller(ProfilController::class)
            ->prefix('/profil')
            ->as('profil.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/update', 'update')->name('update');
                Route::post('/update-password', 'updatePassword')->name('update.password');
            });
    });

Route::get('/not-found', function () {
    return view('template.error.notFound');
})->middleware('auth');

Route::get('/inactive', function () {
    return view('template.error.inactive');
})->middleware('guest');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
