<?php

use Modules\AuditTrails\Livewire\Admin\AuditTrails;

Route::prefix(config('fuse.prefix'))->middleware(['auth', 'verified', 'activeUser', 'ipCheckMiddleware'])->group(function () {
    Route::get('settings/audit-trails', AuditTrails::class)->name('admin.settings.audit-trails.index');
});
