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

Route::get('/', 'AuthController@index');
Route::get('/register', 'AuthController@viewRegister');
Route::post('/register', 'AuthController@register');
Route::get('/login', 'AuthController@viewLogin')->name('login');
Route::post('/login', 'AuthController@login');

// Route yang hanya bisa diakses oleh user yang telah login
Route::group(['middleware' => 'auth'], function () {

    // Route yang hanya bisa di akses oleh user berlevel admin
    Route::group(['middleware' => 'checkLevel:admin'], function () {

        // Data
        Route::get('/admin', 'AdminController@index');
        Route::get('/admin/data/petugas', 'AdminController@dataPetugas');
        Route::get('/admin/data/anggota', 'AdminController@dataAnggota');
        Route::get('/admin/list-penarikan', 'AdminController@listPenarikan');
        Route::get('/admin/data/penjemputan', 'AdminController@dataPenjemputan');
        Route::get('/admin/register', 'AdminController@viewRegister');

        // Profile
        Route::get('/admin/profile', 'ProfileController@index');
        Route::get('/admin/edit-profile', 'ProfileController@edit');

        // Detail Data
        Route::get('/admin/sedekah/{sedekah}', 'AdminController@show');
        Route::get('/admin/penjemputan/{penjemputan}', 'AdminController@detailPenjemputan');
        Route::get('/admin/data/user/{user}', 'AdminController@detailUser');

        Route::get('/admin/download/qr-code/{qr_code}', 'AdminController@downloadQrCode');

        Route::post('/admin/register', 'AdminController@register');
        Route::patch('/admin/edit-profile', 'ProfileController@update');
        Route::patch('/admin/konfirmasi/{penarikan}', 'AdminController@konfirmasiPenarikanTabungan');
        Route::patch('/admin/data/user/{user}', 'AdminController@aktifkanAtauNonaktifkanUser');
        // Route::delete('/admin/data/petugas/{user}', 'AdminController@deleteUser');
    });

    // Route yang hanya bisa di akses oleh user berlevel petugas
    Route::group(['middleware' => 'checkLevel:petugas'], function () {

        // Data
        Route::get('/petugas', 'PetugasController@index');
        Route::get('/petugas/data/anggota', 'PetugasController@dataAnggota');
        Route::get('/petugas/data/penjemputan', 'PetugasController@dataPenjemputanSaya');

        // Profile
        Route::get('/petugas/profile', 'ProfileController@index');
        Route::get('/petugas/edit-profile', 'ProfileController@edit');

        // Detail Data
        Route::get('/petugas/sedekah/{sedekah}', 'PetugasController@show');
        // Route::get('/petugas/data/user/{user}', 'PetugasController@detailUser');
        Route::get('/petugas/penjemputan/{penjemputan}', 'PetugasController@detailPenjemputan');

        Route::get('/petugas/download/qr-code/{qr_code}', 'PetugasController@downloadQrCode');

        Route::post('/petugas/sedekah/{id}', 'PetugasController@store');
        Route::patch('/petugas/edit-profile', 'ProfileController@update');
        Route::patch('/petugas/sedekah/{sedekah}', 'PetugasController@update');
    });

    // Route yang hanya bisa di akses oleh user berlevel anggota
    Route::group(['middleware' => 'checkLevel:anggota'], function () {

        Route::get('/anggota', 'AnggotaController@index');
        // Route::get('/anggota/tabungan', 'AnggotaController@tabungan');
        Route::get('/anggota/penarikan', 'AnggotaController@penarikan');
        
        Route::get('/anggota/profile', 'ProfileController@index');
        Route::get('/anggota/edit-profile', 'ProfileController@edit');

        Route::get('/anggota/{sedekah}', 'AnggotaController@show');

        Route::post('/anggota', 'AnggotaController@store');
        Route::patch('/anggota/penarikan', 'AnggotaController@tarikTabungan');
        Route::patch('/anggota/edit-profile', 'ProfileController@update');

    });

    // Logout
    Route::post('/logout', 'AuthController@logout');

});