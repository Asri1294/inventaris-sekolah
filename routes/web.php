<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoanReturnController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\UserLoanController;
use App\Http\Controllers\UserItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('items', ItemController::class)->except(['show']);
    Route::resource('loans', LoanController::class)->only(['index', 'create', 'store']);
    Route::patch('loans/{loan}/approve', [LoanController::class, 'approve'])->name('loans.approve');
    Route::patch('loans/{loan}/reject', [LoanController::class, 'reject'])->name('loans.reject');
    Route::get('loans/{loan}/return', [LoanReturnController::class, 'create'])->name('loans.return.create');
    Route::post('loans/{loan}/return', [LoanReturnController::class, 'store'])->name('loans.return.store');
    Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::resource('users', UserController::class)->except(['show']);
});

Route::middleware(['auth', 'role:user'])
    ->prefix('my-loans')
    ->name('my-loans.')
    ->group(function () {
        Route::get('/', [UserLoanController::class, 'index'])->name('index');
        Route::get('/create', [UserLoanController::class, 'create'])->name('create');
        Route::post('/', [UserLoanController::class, 'store'])->name('store');
});

Route::middleware(['auth', 'role:user'])
    ->prefix('available-items')
    ->name('available-items.')
    ->group(function () {
        Route::get('/', [UserItemController::class, 'index'])->name('index');
});
