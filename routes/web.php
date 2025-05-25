<?php

use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('livewire/update', $handle);
});

Route::get('/', WelcomeController::class);

// Documentation Routes
Route::prefix('documentation')->name('documentation.')->group(function () {
    Route::get('/', [DocumentationController::class, 'index'])->name('index');
    Route::get('/modules/{module}', [DocumentationController::class, 'module'])->name('module');
    Route::get('/{page?}', [DocumentationController::class, 'show'])->name('show')->where('page', '.*');
});
