<?php

use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Modules\Admin\Livewire\Admin\Dashboard;

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('livewire/update', $handle);
});

Route::get('/', WelcomeController::class);
