<?php

use App\Http\Controllers\HomepageController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\MemberSettingController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\UserSettingController;
use App\Http\Controllers\FormQ1Controllers;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomepageController::class, 'index']);
Route::get('/dashboard/partisipasi-alumni', fn() => view('pages.dashboard.table data.read_partisipasiAlumni'));
Route::get('/panduan', fn() => view('pages.panduan'));
Route::get('/pengisian-tracer-study', fn() => view('pages.Kuesioner.index_quest'))->name('kuesioner.index');
Route::get('/pengisian-tracer-study/Tracer-Study-1', fn() => view('pages.Kuesioner.Tracer-study-1'))->name('kuesioner.tracer-study-1');
Route::get('/pengisian-tracer-study/Tracer-Study-1/Q1', [FormQ1Controllers::class, 'index'])->name('kuesioner.tracer-study-1.index');
Route::get('/pengisian-tracer-study/Tracer-Study-1/Q1_2015-2020', [FormQ1Controllers::class, 'index_Public'])->name('kuesioner.tracer-study-1.index_public');
Route::post('/pengisian-tracer-study/Tracer-Study-1/Q1_2015-2020', [FormQ1Controllers::class, 'store_public'])->name('kuesioner.tracer-study-1.store_public');
Route::get('/search-by-nim/{nim}', [FormQ1Controllers::class, 'searchByNim'])->name('alumni.searchByNim');


// Member Setting (Alumni Management)
Route::controller(MemberSettingController::class)->group(function () {
    Route::get('/dashboard/member/setting', 'memberSetting')->name('dashboard.member-setting');
    Route::post('/alumni', 'store')->name('alumni.store');
    Route::get('/alumni/{id}', 'ambilDataAlumni')->name('alumni.show');
    Route::put('/alumni/{id}', 'update')->name('alumni.update');
    Route::delete('/alumni/{id}', 'destroy');
});

Route::controller(UserSettingController::class)->group(function () {
    Route::get('dashboard/user/setting', 'index')->name('dashboard.user-setting');
    Route::post('dashboard/user/setting', 'store')->name('dashboard.user.setting.store');
    Route::get('dashboard/user/setting/{id}', 'show')->name('dashboard.user.setting.show');
    Route::get('dashboard/user/setting/{id}', 'show')->name('dashboard.user.setting.search');
    Route::put('dashboard/user/setting/{id}', 'update')->name('dashboard.user.setting.update');
    Route::delete('dashboard/user/setting/{id}', 'destroy')->name('dashboard.user.setting.destroy');
});

// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::get('/logout', 'logout')->name('logout');
});

// Registration Routes
Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register.show');
    Route::post('/register', 'register')->name('register');
});

// Dashboard
Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard.dashboard');
});

