<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\Contacts\Jobs\ImportContactsJob;
use Modules\Contacts\Models\Contact;

beforeEach(function () {
    // Set up fake storage
    Storage::fake('local');
});

test('imports contacts from csv file', function () {
    // Create a test CSV file
    $csvContent = "name,email\nJohn Doe,john@example.com\nJane Smith,jane@example.com";
    $filePath = Storage::path('contacts.csv');
    file_put_contents($filePath, $csvContent);

    // Define field mapping
    $fieldMapping = [
        'name' => 0,
        'email' => 1
    ];

    // Execute the job
    $job = new ImportContactsJob($filePath, $fieldMapping);
    $job->handle();

    // Assert contacts were created
    $this->assertDatabaseHas('contacts', [
        'name' => 'John Doe',
        'email' => 'john@example.com'
    ]);

    $this->assertDatabaseHas('contacts', [
        'name' => 'Jane Smith',
        'email' => 'jane@example.com'
    ]);

    // Assert we have exactly 2 contacts
    $this->assertEquals(2, Contact::count());
});

test('updates existing contacts with same email', function () {
    // Create an existing contact
    $existingContact = Contact::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com'
    ]);

    // Create a test CSV file with updated data
    $csvContent = "name,email\nJohn Updated,john@example.com";
    $filePath = Storage::path('contacts.csv');
    file_put_contents($filePath, $csvContent);

    // Define field mapping
    $fieldMapping = [
        'name' => 0,
        'email' => 1
    ];

    // Execute the job
    $job = new ImportContactsJob($filePath, $fieldMapping);
    $job->handle();

    // Assert contact was updated
    $this->assertDatabaseHas('contacts', [
        'name' => 'John Updated',
        'email' => 'john@example.com'
    ]);

    // Assert we still have only 1 contact
    $this->assertEquals(1, Contact::count());
});

test('skips invalid contact data', function () {
    // Create a test CSV file with invalid data
    $csvContent = "name,email\nJohn Doe,invalid-email\nJane Smith,jane@example.com";
    $filePath = Storage::path('contacts.csv');
    file_put_contents($filePath, $csvContent);

    // Define field mapping
    $fieldMapping = [
        'name' => 0,
        'email' => 1
    ];

    // Fake the log to capture warnings
    Log::spy();

    // Execute the job
    $job = new ImportContactsJob($filePath, $fieldMapping);
    $job->handle();

    // Assert only valid contact was created
    $this->assertDatabaseHas('contacts', [
        'name' => 'Jane Smith',
        'email' => 'jane@example.com'
    ]);

    $this->assertDatabaseMissing('contacts', [
        'email' => 'invalid-email'
    ]);

    // Assert we have exactly 1 contact
    $this->assertEquals(1, Contact::count());

    // Assert warning was logged
    Log::shouldHaveReceived('warning')
        ->with('Invalid contact data during import', \Mockery::any());
});

test('handles missing required fields', function () {
    // Create a test CSV file with missing name
    $csvContent = "name,email\n,john@example.com";
    $filePath = Storage::path('contacts.csv');
    file_put_contents($filePath, $csvContent);

    // Define field mapping
    $fieldMapping = [
        'name' => 0,
        'email' => 1
    ];

    // Fake the log to capture warnings
    Log::spy();

    // Execute the job
    $job = new ImportContactsJob($filePath, $fieldMapping);
    $job->handle();

    // Assert no contacts were created
    $this->assertEquals(0, Contact::count());

    // Assert warning was logged
    Log::shouldHaveReceived('warning')
        ->with('Invalid contact data during import', \Mockery::any());
});

test('processes large datasets in chunks', function () {
    // Create a large CSV file (100 contacts)
    $csvContent = "name,email\n";
    for ($i = 1; $i <= 100; $i++) {
        $csvContent .= "User {$i},user{$i}@example.com\n";
    }

    $filePath = Storage::path('contacts.csv');
    file_put_contents($filePath, $csvContent);

    // Define field mapping
    $fieldMapping = [
        'name' => 0,
        'email' => 1
    ];

    // Execute the job
    $job = new ImportContactsJob($filePath, $fieldMapping);

    // Set a small chunk size for testing
    $reflectionClass = new ReflectionClass($job);
    $reflectionProperty = $reflectionClass->getProperty('chunkSize');
    $reflectionProperty->setAccessible(true);
    $reflectionProperty->setValue($job, 10);

    $job->handle();

    // Assert all contacts were created
    $this->assertEquals(100, Contact::count());
});

test('handles custom field mapping', function () {
    // Create a test CSV file with different column order
    $csvContent = "email,full_name\njohn@example.com,John Doe\njane@example.com,Jane Smith";
    $filePath = Storage::path('contacts.csv');
    file_put_contents($filePath, $csvContent);

    // Define field mapping with reversed columns
    $fieldMapping = [
        'name' => 1,
        'email' => 0
    ];

    // Execute the job
    $job = new ImportContactsJob($filePath, $fieldMapping);
    $job->handle();

    // Assert contacts were created with correct mapping
    $this->assertDatabaseHas('contacts', [
        'name' => 'John Doe',
        'email' => 'john@example.com'
    ]);

    $this->assertDatabaseHas('contacts', [
        'name' => 'Jane Smith',
        'email' => 'jane@example.com'
    ]);
});

test('handles file open errors gracefully', function () {
    // Create a non-existent file path
    $filePath = '/non/existent/path/contacts.csv';

    // Fake the log to capture errors
    Log::spy();

    // Define field mapping
    $fieldMapping = [
        'name' => 0,
        'email' => 1
    ];

    // Execute the job with try-catch to handle the exception
    try {
        $job = new ImportContactsJob($filePath, $fieldMapping);
        $job->handle();
    } catch (\Exception $e) {
        // Exception is expected
    }

    // Assert no contacts were created
    $this->assertEquals(0, Contact::count());
});

test('logs import statistics', function () {
    // Create a test CSV file
    $csvContent = "name,email\nJohn Doe,john@example.com\nJane Smith,jane@example.com";
    $filePath = Storage::path('contacts.csv');
    file_put_contents($filePath, $csvContent);

    // Define field mapping
    $fieldMapping = [
        'name' => 0,
        'email' => 1
    ];

    // Fake the log to capture info
    Log::spy();

    // Execute the job
    $job = new ImportContactsJob($filePath, $fieldMapping);
    $job->handle();

    // Assert import statistics were logged
    Log::shouldHaveReceived('info')
        ->with('Contact import completed', [
            'processed' => 2,
            'success' => 2,
            'errors' => 0,
        ]);
});
