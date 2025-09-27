<?php

use App\Http\Controllers\AttendanceController;
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

Route::middleware('auth')->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'stamp']);
    Route::post('/punch_in', 'App\Http\Controllers\AttendanceController@punchIn')->name('timestamp/punch_in');
    Route::post('/punch_out', 'App\Http\Controllers\AttendanceController@punchOut')->name('timestamp/punch_out');
    Route::post('/rest_in', 'App\Http\Controllers\AttendanceController@restIn')->name('timestamp/rest_in');
    Route::post('/rest_out', 'App\Http\Controllers\AttendanceController@restOut')->name('timestamp/rest_out');

    Route::get('/attendance/list', [AttendanceController::class, 'list']);
    Route::get('/attendance/{work_id}', [AttendanceController::class, 'detail']);
    Route::post('/correction/{work_id}', [AttendanceController::class, 'postCorrection']);
    Route::get('/stamp_correction_request/list', [AttendanceController::class, 'applicationList']);
});