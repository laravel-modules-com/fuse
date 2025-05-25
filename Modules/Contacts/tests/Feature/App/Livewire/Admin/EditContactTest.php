<?php

use Livewire\Livewire;
use Modules\Contacts\Livewire\Admin\EditContact;
use Modules\Contacts\Models\Contact;

beforeEach(function () {
    $this->authenticate();
});

test('can see edit contact page', function () {
    $contact = Contact::factory()->create();

    $this
        ->get(route('admin.contacts.edit', $contact))
        ->assertOk();
});

test('can update contact', function () {
    $contact = Contact::factory()->create([
        'name' => 'Original Name',
        'email' => 'original@example.com',
    ]);

    Livewire::test(EditContact::class, ['contact' => $contact])
        ->set('name', 'Updated Name')
        ->set('email', 'updated@example.com')
        ->call('update')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.contacts.index'));

    $contact->refresh();

    expect($contact->name)->toBe('Updated Name')
        ->and($contact->email)->toBe('updated@example.com');

    $this->assertDatabaseHas('audit_trails', [
        'title' => 'Updated contact Updated Name',
        'link' => route('admin.contacts.show', ['contact' => $contact->id]),
        'section' => 'Contacts',
        'type' => 'Update',
    ]);
});

test('name cannot be null', function () {
    $contact = Contact::factory()->create();

    Livewire::test(EditContact::class, ['contact' => $contact])
        ->set('name', '')
        ->call('update')
        ->assertHasErrors('name');
});

test('email cannot be null', function () {
    $contact = Contact::factory()->create();

    Livewire::test(EditContact::class, ['contact' => $contact])
        ->set('email', '')
        ->call('update')
        ->assertHasErrors('email');
});

test('email must be an email', function () {
    $contact = Contact::factory()->create();

    Livewire::test(EditContact::class, ['contact' => $contact])
        ->set('email', 'not-an-email')
        ->call('update')
        ->assertHasErrors('email');
});

test('email must be unique except for current contact', function () {
    $contact1 = Contact::factory()->create([
        'email' => 'contact1@example.com',
    ]);

    $contact2 = Contact::factory()->create([
        'email' => 'contact2@example.com',
    ]);

    Livewire::test(EditContact::class, ['contact' => $contact1])
        ->set('email', 'contact2@example.com')
        ->call('update')
        ->assertHasErrors('email');

    Livewire::test(EditContact::class, ['contact' => $contact1])
        ->set('email', 'contact1@example.com')
        ->call('update')
        ->assertHasNoErrors();
});
