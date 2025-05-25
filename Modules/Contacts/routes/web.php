<?php

use Illuminate\Support\Facades\Route;
use Modules\Contacts\Livewire\Admin\Contacts;
use Modules\Contacts\Livewire\Admin\CreateContact;
use Modules\Contacts\Livewire\Admin\EditContact;
use Modules\Contacts\Livewire\Admin\ImportContacts;
use Modules\Contacts\Livewire\Admin\ShowContact;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix(config('fuse.prefix'))->middleware(['auth', 'verified', 'activeUser', 'ipCheckMiddleware'])->group(function () {
    Route::prefix('contacts')->group(function () {
        Route::get('/', Contacts::class)->name('admin.contacts.index');
        Route::get('create', CreateContact::class)->name('admin.contacts.create');
        Route::get('import', ImportContacts::class)->name('admin.contacts.import');
        Route::get('{contact}/edit', EditContact::class)->name('admin.contacts.edit');
        Route::get('{contact}', ShowContact::class)->name('admin.contacts.show');
    });
});
