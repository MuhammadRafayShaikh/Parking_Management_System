<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VehicleController;
use App\Http\Middleware\AuthMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});
// Route::view('index', 'index')->name('index');

Route::view('dashboard', 'dashboard')->name('dashboard');
Route::get('addCategory', [HomeController::class, 'addCategory'])->name('addCategory');
Route::get('editCategory/{id}', [HomeController::class, 'editCategory'])->name('editCategory');
Route::view('vehicle-category', 'vehicle-category')->name('vehicle-category');
Route::view('vehicle', 'vehicle')->name('vehicle');
Route::get('view-vehicle/{id}', [HomeController::class, 'viewvehicle'])->name('view-vehicle');
Route::get('addVehicle', [HomeController::class, 'addVehicle'])->name('addVehicle');
Route::get('outgoingvehicle', [HomeController::class, 'outgoingvehicle'])->name('outgoingvehicle');
Route::get('viewoutgoingvehicle/{id}', [HomeController::class, 'viewoutgoingvehicle'])->name('viewoutgoingvehicle');
Route::get('reports', [HomeController::class, 'reports'])->name('reports');
