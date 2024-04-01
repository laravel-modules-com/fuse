<?php

use Modules\Settings\Livewire\Admin\Settings;

Route::prefix(config('admintw.prefix'))->middleware(['auth', 'verified', 'activeUser', 'ipCheckMiddleware'])->group(function () {
    Route::prefix('settings')->group(function () {
        Route::get('system-settings', Settings::class)->name('admin.settings');
    });
});
