<?php

use Illuminate\Support\Facades\Route;
use Modules\Contacts\Livewire\Admin\Contacts;
use Modules\Contacts\Livewire\Admin\CreateContact;
use Modules\Contacts\Livewire\Admin\EditContact;
use Modules\Contacts\Livewire\Admin\ImportContacts;
use Modules\Contacts\Livewire\Admin\ShowContact;

Route::prefix(config('fuse.prefix'))->middleware(['auth', 'verified', 'activeUser', 'ipCheckMiddleware'])->group(function () {
    Route::prefix('contacts')->group(function () {
        Route::get('/', Contacts::class)->name('admin.contacts.index');
        Route::get('create', CreateContact::class)->name('admin.contacts.create');
        Route::get('import', ImportContacts::class)->name('admin.contacts.import');
        Route::get('{contact}/edit', EditContact::class)->name('admin.contacts.edit');
        Route::get('{contact}', ShowContact::class)->name('admin.contacts.show');
    });
});
