<?php

use Illuminate\Support\Facades\Route;
use Modules\Users\Livewire\Admin\EditUser;
use Modules\Users\Livewire\Admin\ShowUser;
use Modules\Users\Livewire\Admin\Users;

Route::prefix(config('admintw.prefix'))->middleware(['auth', 'verified', 'activeUser', 'ipCheckMiddleware'])->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/', Users::class)->name('admin.users.index');
        Route::get('{user}/edit', EditUser::class)->name('admin.users.edit');
        Route::get('{user}', ShowUser::class)->name('admin.users.show');
    });
});
