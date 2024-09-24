<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ListVedikaController;
use App\Http\Controllers\UserVedikaController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\MonitoringRalanController;
use App\Http\Controllers\ListVedikaBPJSController;
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

Route::get('/', [AuthController::class, 'showLoginForm']);
Route::get('login', [AuthController::class, 'showLoginForm']);
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('listvedika', [ListVedikaController::class, 'index'])->name('listvedika')->middleware('auth');
Route::get('listvedika/validasiverifikator/{no_rawat}', [ListVedikaController::class, 'showValidasiverifikatorForm'])->name('listvedika.validasiverifikator')->middleware('auth');
Route::post('listvedika/validasiverifikator/{no_rawat}', [ListVedikaController::class, 'validasiverifikator'])->name('listvedika.validasiverifikator')->middleware('auth');
Route::get('listvedika/gabungberkas/{no_rawat}', [ListVedikaController::class, 'gabungberkas'])->name('listvedika.gabungberkas')->middleware('auth');

Route::get('listvedikabpjs', [ListVedikaBPJSController::class, 'index'])->name('listvedikabpjs')->middleware('auth');
Route::get('listvedikabpjs/validasibpjs/{no_rawat}', [ListVedikaBPJSController::class, 'showValidasibpjsForm'])->name('listvedikabpjs.validasibpjs')->middleware('auth');
Route::post('listvedikabpjs/validasibpjs/{no_rawat}', [ListVedikaBPJSController::class, 'validasibpjs'])->name('listvedikabpjs.validasibpjs')->middleware('auth');

Route::get('feedback', [FeedbackController::class, 'index'])->name('feedback')->middleware('auth');
Route::get('feedback/{validasiVedika}/edit', [FeedbackController::class, 'edit'])->name('feedback.edit')->middleware('auth');
Route::put('feedback/{validasiVedika}', [FeedbackController::class, 'update'])->name('feedback.update')->middleware('auth');
Route::delete('feedback/{validasiVedika}', [FeedbackController::class, 'destroy'])->name('feedback.destroy')->middleware('auth');

Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::get('/monitoringralan', [MonitoringRalanController::class, 'index'])->name('ralan.index');
    Route::get('/monitoringralan/{no_rawat}', [MonitoringRalanController::class, 'show'])
    ->where('no_rawat', '^[A-Za-z0-9\-\/]+$')
    ->name('ralan.show');
});

Route::resource('uservedika', UserVedikaController::class)->middleware('auth');