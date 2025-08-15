<?php

use App\Http\Controllers\POS\ItemsController;
use App\Http\Controllers\POS\TransactionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get("/items/search", [ItemsController::class, 'search'])->name('items.search');
Route::get("/items/index2", [ItemsController::class, 'index2'])->name('items.index2');
Route::resource("items", ItemsController::class);

Route::get("/tx/create/{id}", [TransactionController::class, 'create'])->name('tx.create');
Route::resource("tx", TransactionController::class)->only("index", "show", "store", "update");

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
