<?php

use App\Http\Controllers\WEB\AdminStaff\AdminStaffController;
use App\Http\Controllers\WEB\AdminStaff\DashboardController;
use App\Http\Controllers\WEB\AdminStaff\DosenController;
use App\Http\Controllers\WEB\AdminStaff\MahasiswaController;
use App\Http\Controllers\WEB\Auth\ForgotController;
use App\Http\Controllers\WEB\Auth\LoginController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('pages.admin-staff.dashboard.index');
});

Route::resource('login', LoginController::class);
Route::resource('forgot-password', ForgotController::class);

Route::resource('dashboard', DashboardController::class);
Route::resource('admin-dan-staff', AdminStaffController::class);
Route::resource('dosen', DosenController::class);
Route::resource('mahasiswa', MahasiswaController::class);


