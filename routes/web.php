<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return \Inertia\Inertia::render('auth/Login');
})->middleware('guest');

Route::group(['middleware' => ['auth']], function(){
    Route::get('dashboard', App\Http\Controllers\DashboardController::class)->name('dashboard.index');

    Route::resource('plans', App\Http\Controllers\Transactions\PlanController::class);
    Route::resource('realizations', App\Http\Controllers\Transactions\RealizationController::class, [ 'except' => [ 'show' ] ]);
});

// Route::get('/', function () {
//     return Inertia::render('Welcome');
// })->name('home');

// Route::get('dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// require __DIR__.'/settings.php';
// require __DIR__.'/auth.php';
