<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\PC;
use App\Http\Controllers\DeviceController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/device-stats', [DeviceController::class, 'getDeviceStats']);

Route::get('/connected-pcs', function () {
    return response()->json(PC::where('status', 'Online')->get(['id', 'name', 'image_url', 'status']));
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
