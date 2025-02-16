<?php

use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index']);
// Auth
Route::middleware('guest')->group(function() {
    Route::get('/login', [LoginController::class, 'showLoginForm']);
});
Route::post('/login', [LoginController::class, 'login']);
Route::middleware('auth')->group(function() {
    Route::post('/logout', [LoginController::class, 'Logout']);
    Route::middleware('role')->group(function() {
        Route::prefix('/admin')->group(function() {
            // Dashboard
            Route::get('/', [AdminHomeController::class, 'index']);
            // User
            Route::get('/users', [UserController::class, 'index']);
            Route::get('/users/create', [UserController::class, 'create']);
        });
    });
    Route::middleware('role:admin')->group(function() {
        Route::post('/admin/all-update', [AdminHomeController::class, 'allUpdate']);
    });
});