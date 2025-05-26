<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Modules\Contacts\Jobs\ImportContactsJob;
use Modules\Contacts\Livewire\Admin\ImportContacts;

beforeEach(function () {
    $this->authenticate();

    // Set up fake storage
    Storage::fake('local');
});

test('can upload csv file', function () {
    // Create a valid CSV file
    $csvContent = "name,email\nJohn Doe,john@example.com\nJane Smith,jane@example.com";
    $file = UploadedFile::fake()->createWithContent('contacts.csv', $csvContent);

    // Test uploading the file
    Livewire::test(ImportContacts::class)
        ->set('csvFile', $file)
        ->assertSet('step', 2)
        ->assertSet('headers', ['name', 'email'])
        ->assertCount('csvData', 2)
        ->assertSet('totalRows', 2);
});

test('validates csv file', function () {
    // Create an invalid file (not a CSV)
    $file = UploadedFile::fake()->create('document.pdf', 100);

    // Test validation fails
    Livewire::test(ImportContacts::class)
        ->set('csvFile', $file)
        ->assertHasErrors(['csvFile']);
});

test('auto maps fields with matching headers', function () {
    // Create a CSV with headers matching the required fields
    $csvContent = "name,email,phone\nJohn Doe,john@example.com,123456789";
    $file = UploadedFile::fake()->createWithContent('contacts.csv', $csvContent);

    // Test field mapping
    Livewire::test(ImportContacts::class)
        ->set('csvFile', $file)
        ->assertSet('fieldMapping.name', 0)
        ->assertSet('fieldMapping.email', 1);
});

test('can manually map fields', function () {
    // Create a CSV with different header names
    $csvContent = "full_name,contact_email\nJohn Doe,john@example.com";
    $file = UploadedFile::fake()->createWithContent('contacts.csv', $csvContent);

    // Test manual field mapping
    $component = Livewire::test(ImportContacts::class)
        ->set('csvFile', $file)
        ->assertSet('fieldMapping.name', '')
        ->assertSet('fieldMapping.email', '');

    // Set manual mapping
    $component->set('fieldMapping.name', 0)
        ->set('fieldMapping.email', 1);

    // Verify mapping is set
    $component->assertSet('fieldMapping.name', 0)
        ->assertSet('fieldMapping.email', 1);
});

test('requires mapping for required fields', function () {
    // Create a CSV file
    $csvContent = "name,email\nJohn Doe,john@example.com";
    $file = UploadedFile::fake()->createWithContent('contacts.csv', $csvContent);

    // Test validation of required field mapping
    $component = Livewire::test(ImportContacts::class)
        ->set('csvFile', $file)
        ->set('fieldMapping.name', '')
        ->set('fieldMapping.email', 1);

    // Try to start import with missing mapping
    $component->call('startImport')
        ->assertHasErrors(['fieldMapping.name']);
});

test('dispatches import job when starting import', function () {
    // Fake the queue
    Queue::fake();

    // Create a CSV file
    $csvContent = "name,email\nJohn Doe,john@example.com\nJane Smith,jane@example.com";
    $file = UploadedFile::fake()->createWithContent('contacts.csv', $csvContent);

    // Upload and map fields
    $component = Livewire::test(ImportContacts::class)
        ->set('csvFile', $file)
        ->set('fieldMapping.name', 0)
        ->set('fieldMapping.email', 1);

    // Start the import
    $component->call('startImport');

    // Assert job was dispatched
    Queue::assertPushed(ImportContactsJob::class);
});

test('can go back to upload step', function () {
    // Create a CSV file
    $csvContent = "name,email\nJohn Doe,john@example.com";
    $file = UploadedFile::fake()->createWithContent('contacts.csv', $csvContent);

    // Upload file to reach step 2
    $component = Livewire::test(ImportContacts::class)
        ->set('csvFile', $file)
        ->assertSet('step', 2);

    // Go back to step 1
    $component->call('back')
        ->assertSet('step', 1)
        ->assertSet('headers', [])
        ->assertSet('csvData', [])
        ->assertSet('fieldMapping', []);
});

test('redirects to contacts index after starting import', function () {
    // Create a CSV file
    $csvContent = "name,email\nJohn Doe,john@example.com";
    $file = UploadedFile::fake()->createWithContent('contacts.csv', $csvContent);

    // Upload, map fields, and start import
    Livewire::test(ImportContacts::class)
        ->set('csvFile', $file)
        ->set('fieldMapping.name', 0)
        ->set('fieldMapping.email', 1)
        ->call('startImport')
        ->assertRedirect(route('admin.contacts.index'));
});
