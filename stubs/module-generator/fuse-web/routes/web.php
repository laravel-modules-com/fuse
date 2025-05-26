<?php

use Illuminate\Support\Facades\Route;
use Modules\{Module}\Livewire\Admin\{Module};
use Modules\{Module}\Livewire\Admin\Create{Model};
use Modules\{Module}\Livewire\Admin\Edit{Model};
use Modules\{Module}\Livewire\Admin\Import{Module};
use Modules\{Module}\Livewire\Admin\Show{Model};

Route::prefix(config('fuse.prefix'))->middleware(['auth', 'verified', 'activeUser', 'ipCheckMiddleware'])->group(function () {
    Route::prefix('{module-}')->group(function () {
        Route::get('/', {Module}::class)->name('admin.{module-}.index');
        Route::get('create', Create{Model}::class)->name('admin.{module-}.create');
        Route::get('import', Import{Module}::class)->name('admin.{module-}.import');
        Route::get('{{model_}}/edit', Edit{Model}::class)->name('admin.{module-}.edit');
        Route::get('{{model_}}', Show{Model}::class)->name('admin.{module-}.show');
    });
});

