<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PCController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\VncController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AlertController;
use App\Models\SubPc;





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


Route::post('/upload', [PCController::class, 'uploadFile'])->name('pc.upload');
Route::post('/pcs/control', [PCController::class, 'controlPC']);
Route::get('/pcs/device-counts', [PCController::class, 'getDeviceCounts']);
Route::get('/pcs/update-status', [PCController::class, 'updateDeviceStatus']);
Route::post('/pcs/processes', [PcController::class, 'getProcesses']);
Route::get('/fetch-alerts', [AlertController::class, 'fetchAlerts']);

Route::get('/pcs/get-status', [PCController::class, 'getDeviceStatuses']);
Route::post('/set-timer', [PcController::class, 'setLockTimer']);

Route::post('/add-pc', [PcController::class, 'store']);
Route::get('/next-port', [PCController::class, 'getNextPort']);


Route::get('/pc-status', function () {
    return response()->json(SubPc::all(['id', 'ip_address', 'device_status']));
});

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

require __DIR__ . '/auth.php';


