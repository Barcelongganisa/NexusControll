<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PCController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\VncController;



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

Route::post('/pcs/control', [PCController::class, 'controlPC']);
Route::get('/pcs/device-counts', [PCController::class, 'getDeviceCounts']);
Route::get('/pcs/update-status', [PCController::class, 'updateDeviceStatus']);
Route::post('/pcs/processes', [PcController::class, 'getProcesses']);



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [VncController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
});

Route::post('/add-pc', [PcController::class, 'store']);
require __DIR__.'/auth.php';
