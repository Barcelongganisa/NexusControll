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

Route::post('/upload', function (Request $request) {
    // Get the sub-PC's IP from the database
    $subPc = DB::table('sub_pcs')->where('ip_address', $request->input('sub_pc_id'))->first();
    
    if (!$subPc) {
        return response()->json(['message' => 'Sub-PC not found'], 404);
    }

    // Check if a file was uploaded
    if (!$request->hasFile('file')) {
        return response()->json(['message' => 'No file found'], 400);
    }

    $file = $request->file('file');
    $filename = $file->getClientOriginalName();
    $localPath = $file->getPathname(); // Temporary path

    // ✅ Establish Direct FTP Connection (Bypass Laravel Storage)
    $ftpHost = $subPc->ip_address; // Dynamically get IP from DB
    $ftpUsername = env('FTP_USERNAME');
    $ftpPassword = env('FTP_PASSWORD');
    $remoteFile = "/uploads/{$filename}"; // Destination path

    // Connect to FTP Server
    $ftpConn = ftp_connect($ftpHost, 21, 30); // 30s timeout
    if (!$ftpConn) {
        return response()->json(['message' => 'FTP connection failed!'], 500);
    }

    // Login to FTP
    if (!ftp_login($ftpConn, $ftpUsername, $ftpPassword)) {
        ftp_close($ftpConn);
        return response()->json(['message' => 'FTP login failed!'], 500);
    }

    // Enable Active Mode (Faster for LAN)
    ftp_pasv($ftpConn, false);

    // ✅ Optimize Large File Transfers
    ftp_set_option($ftpConn, FTP_TIMEOUT_SEC, 60); // Set timeout
    ftp_set_option($ftpConn, FTP_AUTOSEEK, true); // Enable seeking for large files

    // Upload the file
    $uploadSuccess = ftp_put($ftpConn, $remoteFile, $localPath, FTP_BINARY);

    // Close FTP connection
    ftp_close($ftpConn);

    if ($uploadSuccess) {
        return response()->json([
            'message' => 'File uploaded successfully!',
            'path' => $remoteFile
        ]);
    } else {
        return response()->json(['message' => 'Upload failed!'], 500);
    }
});



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

require __DIR__.'/auth.php';
