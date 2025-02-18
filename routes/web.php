<?php

use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Models\Permission;
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
    Route::get('/forgot-password', [ResetPasswordController::class, 'showResetLink']);
    Route::post('/send-reset-link', [ResetPasswordController::class, 'sendResetLink']);
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm']);
    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword']);
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
            Route::post('/users/create', [UserController::class, 'store']);
            Route::get('/users/{id}', [UserController::class, 'edit']);
            Route::match(['put', 'patch'], '/users/{id}', [UserController::class, 'update']);
            Route::delete('/users/{id}', [UserController::class, 'destroy']);
            // Role
            Route::get('/roles', [RoleController::class, 'index']);
            Route::get('/roles/create', [RoleController::class, 'create']);
            Route::post('/roles/create', [RoleController::class, 'store']);
            Route::get('/roles/{id}', [RoleController::class, 'edit']);
            Route::match(['put', 'patch'], '/roles/{id}', [RoleController::class, 'update']);
            Route::delete('/roles/{id}', [RoleController::class, 'destroy']);
            // Permissions
            Route::get('/permissions', [PermissionController::class, 'index']);
            Route::get('/permissions/create', [PermissionController::class, 'create']);
            Route::post('/permissions/create', [PermissionController::class, 'store']);
            Route::get('/permissions/{id}', [PermissionController::class, 'edit']);
            Route::match(['put', 'patch'], '/permissions/{id}', [PermissionController::class, 'update']);
            Route::delete('/permissions/{id}', [PermissionController::class, 'destroy']);
            // Features
            Route::get('/features', [FeatureController::class, 'index']);
            Route::get('/features/create', [FeatureController::class, 'create']);
            Route::post('/features/create', [FeatureController::class, 'store']);
            Route::get('/features/{id}', [FeatureController::class, 'edit']);
            Route::match(['put', 'patch'], '/features/{id}', [FeatureController::class, 'update']);
            Route::delete('/features/{id}', [FeatureController::class, 'destroy']);
            // Product
            Route::get('/products', [ProductController::class, 'index']);
            Route::get('/products/create', [ProductController::class, 'create']);
            Route::post('/products/create', [ProductController::class, 'store']);
            Route::get('/products/{id}', [ProductController::class, 'edit']);
            Route::match(['put', 'patch'], '/products/{id}', [ProductController::class, 'update']);
            Route::delete('/products/{id}', [ProductController::class, 'destroy']);
        });
    });
    Route::middleware('role:admin')->group(function() {
        Route::post('/admin/all-update', [AdminHomeController::class, 'allUpdate']);
    });
});