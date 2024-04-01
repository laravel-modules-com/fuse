<?php

use App\Http\Controllers\WelcomeController;
use App\Livewire\Admin\Dashboard;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('livewire/update', $handle);
});

Route::get('/', WelcomeController::class);

Route::prefix(config('admintw.prefix'))->middleware(['auth', 'verified', 'activeUser', 'ipCheckMiddleware'])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
});
