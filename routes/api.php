<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('signup', [AuthController::class, 'signup']);
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('category', CategoryController::class)->middleware('auth:sanctum');

Route::apiResource('vehicles', VehicleController::class)->middleware('auth:sanctum');
Route::put('updateVehicle/{id}', [VehicleController::class, 'update'])->name('vehicles.update');
Route::get('dashboardData', [VehicleController::class, 'dashboardData'])->name('dashboardData');
Route::get('index2', [VehicleController::class, 'index2'])->name('vehicles.index2');
Route::get('filter', [VehicleController::class, 'filter'])->name('filter');
Route::get('/download-pdf', [VehicleController::class, 'downloadPdf'])->name('reports.download');
Route::get('/download-pdf2', [VehicleController::class, 'pdf2'])->name('pdf2');
Route::get('/download-pdf3', [VehicleController::class, 'pdf3'])->name('pdf3');
Route::get('/download-pdf4/{id}', [VehicleController::class, 'pdf4'])->name('pdf4');
Route::get('/download-pdf5/{id}', [VehicleController::class, 'pdf5'])->name('pdf5');
Route::get('/download-pdf6', [VehicleController::class, 'pdf6'])->name('pdf6');
