<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaceLoginController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserValidationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
Route::get('/barcode/{serial}', [BarcodeController::class, 'generate'])->name('barcode.generate');
Route::post('/check-email', [UserValidationController::class, 'checkEmail']);
Route::post('/check-username', [UserValidationController::class, 'checkUsername']);
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/alt-login', [LoginController::class, 'loginForm'])->name('loginForm');
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/face-login', [FaceLoginController::class, 'show'])->name('face.login');
Route::post('/face-login', [FaceLoginController::class, 'authenticate']);


Route::middleware(['admin', 'preventBackHistory'])->group(function () {
    Route::resource('area', AreaController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('inventory', InventoryController::class);
    Route::resource('user', UserController::class);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard/search', [DashboardController::class, 'search'])->name('admin.search');
    Route::get('/category', [CategoryController::class, 'index'])->name('admin.category');
    Route::get('/area', [AreaController::class, 'index'])->name('admin.area');
    Route::get('/inventory', [InventoryController::class, 'index'])->name('admin.inventory');
    Route::get('/userList', [UserController::class, 'index'])->name('admin.userList');
    Route::get('user/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/update', [UserController::class, 'update'])->name('user.update');
});
