<?php

use Livewire\Livewire;
use Modules\Contacts\Livewire\Admin\Contacts;
use Modules\Contacts\Models\Contact;

beforeEach(function () {
    $this->authenticate();
});

test('can see contacts page', function () {
    $this
        ->get(route('admin.contacts.index'))
        ->assertOk();
});

test('can see contacts create page', function () {
    $this
        ->get(route('admin.contacts.create'))
        ->assertOk();
});

test('can see contacts edit page', function () {
    $this
        ->get(route('admin.contacts.edit', Contact::factory()->create()))
        ->assertOk();
});

test('can see contacts show page', function () {
    $this
        ->get(route('admin.contacts.show', Contact::factory()->create()))
        ->assertOk();
});

test('can search contacts', function () {
    Livewire::test(Contacts::class)
        ->set('name', 'john')
        ->assertSet('name', 'john');
});

test('can set property', function () {
    Livewire::test(Contacts::class)
        ->set('sortField', 'name')
        ->assertSet('sortField', 'name');
});

test('can sort contacts in desc', function () {
    Contact::factory()->create(['name' => 'Andy']);
    Contact::factory()->create(['name' => 'Dave']);
    Contact::factory()->create(['name' => 'Zara']);

    Livewire::test(Contacts::class)
        ->call('sortBy', 'name')
        ->assertSet('sortField', 'name')
        ->assertSeeInOrder(['Zara', 'Dave', 'Andy']);
});

test('can sort contacts in asc', function () {
    Contact::factory()->create(['name' => 'Andy']);
    Contact::factory()->create(['name' => 'Dave']);
    Contact::factory()->create(['name' => 'Zara']);

    Livewire::test(Contacts::class)
        ->call('sortBy', 'name')
        ->call('sortBy', 'name')
        ->assertSet('sortAsc', true)
        ->assertSeeInOrder(['Andy', 'Dave', 'Zara']);
});

test('can filter name', function () {
    Contact::factory()->create([
        'name' => 'Andy',
        'email' => 'demo@demo.com',
    ]);

    Livewire::test(Contacts::class)
        ->set('name', 'Andy')
        ->call('contacts')
        ->assertOk()
        ->assertSet('openFilter', false)
        ->assertSee('Andy');
});

test('can filter email', function () {
    Contact::factory()->create([
        'name' => 'Andy',
        'email' => 'demo@demo.com',
    ]);

    Livewire::test(Contacts::class)
        ->set('email', 'demo@demo.com')
        ->call('contacts')
        ->assertOk()
        ->assertSet('openFilter', true)
        ->assertSee('demo@demo.com');
});

test('can reset', function () {
    Livewire::test(Contacts::class)
        ->call('resetFilters')
        ->assertSet('name', '')
        ->assertSet('email', '')
        ->assertSet('openFilter', false);
});

test('can delete contact', function () {
    $contact = Contact::factory()->create([
        'name' => 'Dave',
        'email' => 'demo45@demo.com',
    ]);

    Livewire::test(Contacts::class)
        ->call('deleteContact', $contact->id);

    $this->assertSoftDeleted('contacts', [
        'id' => $contact->id,
    ]);
});

test('can export contacts to csv', function () {

    // Create test contacts
    Contact::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    Contact::factory()->create([
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
    ]);

    Livewire::test(Contacts::class)->call('exportContacts')
        ->assertOk();
    // ->assertHeader('Content-Type', 'text/csv')
    //        ->assertHeader('Content-Disposition', fn ($header) =>
    //            str_contains($header, 'attachment; filename="contacts_') &&
    //            str_contains($header, '.csv"')
    //        );
});
