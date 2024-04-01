<?php

use Illuminate\Support\Facades\Route;
use Modules\Roles\Livewire\Admin\Edit;
use Modules\Roles\Livewire\Admin\Roles;

Route::prefix(config('fuse.prefix'))->middleware(['auth', 'verified', 'activeUser', 'ipCheckMiddleware'])->group(function () {
    Route::prefix('settings')->group(function () {
        Route::get('roles', Roles::class)->name('admin.settings.roles.index');
        Route::get('roles/{role}/edit', Edit::class)->name('admin.settings.roles.edit');
    });
});
