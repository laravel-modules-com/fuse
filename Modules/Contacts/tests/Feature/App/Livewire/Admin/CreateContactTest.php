<?php

use Livewire\Livewire;
use Modules\Contacts\Livewire\Admin\CreateContact;
use Modules\Contacts\Models\Contact;

beforeEach(function () {
    $this->authenticate();
});

test('can see create contact page', function () {
    $this
        ->get(route('admin.contacts.create'))
        ->assertOk();
});

test('can create contact', function () {
    Livewire::test(CreateContact::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->call('create')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.contacts.index'));

    $this->assertDatabaseHas('contacts', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    $contact = Contact::where('email', 'john@example.com')->first();

    $this->assertDatabaseHas('audit_trails', [
        'title' => 'Created contact John Doe',
        'link' => route('admin.contacts.show', ['contact' => $contact->id]),
        'section' => 'Contacts',
        'type' => 'Create',
    ]);
});

test('name cannot be null', function () {
    Livewire::test(CreateContact::class)
        ->set('name', '')
        ->set('email', 'john@example.com')
        ->call('create')
        ->assertHasErrors('name');
});

test('email cannot be null', function () {
    Livewire::test(CreateContact::class)
        ->set('name', 'John Doe')
        ->set('email', '')
        ->call('create')
        ->assertHasErrors('email');
});

test('email must be an email', function () {
    Livewire::test(CreateContact::class)
        ->set('name', 'John Doe')
        ->set('email', 'not-an-email')
        ->call('create')
        ->assertHasErrors('email');
});

test('email must be unique', function () {
    Contact::factory()->create([
        'email' => 'john@example.com',
    ]);

    Livewire::test(CreateContact::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->call('create')
        ->assertHasErrors('email');
});
