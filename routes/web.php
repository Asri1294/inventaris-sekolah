<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserLoanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('items', ItemController::class)->except(['show']);
    Route::resource('loans', LoanController::class)->only(['index', 'create', 'store']);
});

Route::middleware(['auth', 'role:user'])
    ->prefix('my-loans')
    ->name('my-loans.')
    ->group(function () {
        Route::get('/', [UserLoanController::class, 'index'])->name('index');
        Route::get('/create', [UserLoanController::class, 'create'])->name('create');
        Route::post('/', [UserLoanController::class, 'store'])->name('store');
});
