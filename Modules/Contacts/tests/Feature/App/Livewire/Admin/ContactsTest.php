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
        ->assertSee('demo@demo.com');
});

test('can reset', function () {
    Livewire::test(Contacts::class)
        ->call('resetFilters')
        ->assertSet('name', '')
        ->assertSet('email', '')
        ->assertSet('openFilter', false)
        ->assertSet('selected', [])
        ->assertSet('selectAll', false);
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
});

test('can select contacts', function () {
    // Create test contacts
    $contact1 = Contact::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    $contact2 = Contact::factory()->create([
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
    ]);

    Livewire::test(Contacts::class)
        ->set('selected', [$contact1->id])
        ->assertSet('selected', [$contact1->id]);
});

test('can select all contacts', function () {
    // Create test contacts
    $contact1 = Contact::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    $contact2 = Contact::factory()->create([
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
    ]);

    $component = Livewire::test(Contacts::class);

    // Get the IDs as strings (as they would be in the form)
    $expectedIds = [$contact1->id, $contact2->id];
    $expectedIds = array_map('strval', $expectedIds);

    $component->set('selectAll', true)
        ->assertSet('selectAll', true)
        ->assertCount('selected', count($expectedIds));

    // Check that all contact IDs are in the selected array
    foreach ($expectedIds as $id) {
        $component->assertSet('selected', function ($selected) use ($id) {
            return in_array($id, $selected);
        });
    }
});

test('can archive contacts with filters', function () {

    // Create test contacts
    $contact1 = Contact::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    $contact2 = Contact::factory()->create([
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
    ]);

    Livewire::test(Contacts::class)
        ->set('name', 'John')
        ->call('archiveContacts');

    // Verify only John Doe is archived
    $this->assertSoftDeleted('contacts', [
        'id' => $contact1->id,
    ]);

    $this->assertDatabaseHas('contacts', [
        'id' => $contact2->id,
        'deleted_at' => null,
    ]);
});

test('can archive selected contacts', function () {

    $contact1 = Contact::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    $contact2 = Contact::factory()->create([
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
    ]);

    Livewire::test(Contacts::class)
        ->set('selected', [$contact1->id])
        ->call('archiveContacts');

    $this->assertSoftDeleted('contacts', [
        'id' => $contact1->id,
    ]);

    $this->assertDatabaseHas('contacts', [
        'id' => $contact2->id,
        'deleted_at' => null,
    ]);
});
