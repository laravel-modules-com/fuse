<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\{Module}\Jobs\Import{Module}Job;
use Modules\{Module}\Models\{Model};

beforeEach(function () {
    Storage::fake('local');
});

test('imports {module } from csv file', function () {
    $csvContent = "name,email\nJohn Doe,john@example.com\nJane Smith,jane@example.com";
    $filePath = Storage::path('{module--}.csv');
    file_put_contents($filePath, $csvContent);

    $fieldMapping = [
        'name' => 0,
        'email' => 1
    ];

    $job = new Import{Module}Job($filePath, $fieldMapping);
    $job->handle();

    $this->assertDatabaseHas('{module_}', [
        'name' => 'John Doe',
        'email' => 'john@example.com'
    ]);

    $this->assertDatabaseHas('{module_}', [
        'name' => 'Jane Smith',
        'email' => 'jane@example.com'
    ]);

    $this->assertEquals(2, {Model}::count());
});

test('updates existing {module } with same email', function () {
   $existing{Model} = {Model}::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com'
    ]);

    // Create a test CSV file with updated data
    $csvContent = "name,email\nJohn Updated,john@example.com";
    $filePath = Storage::path('{module-}.csv');
    file_put_contents($filePath, $csvContent);

    $fieldMapping = [
        'name' => 0,
        'email' => 1
    ];

    $job = new Import{Module}Job($filePath, $fieldMapping);
    $job->handle();

    $this->assertDatabaseHas('{module_}', [
        'name' => 'John Updated',
        'email' => 'john@example.com'
    ]);

    $this->assertEquals(1, {Model}::count());
});

test('skips invalid {model } data', function () {
    $csvContent = "name,email\nJohn Doe,invalid-email\nJane Smith,jane@example.com";
    $filePath = Storage::path('{module-}.csv');
    file_put_contents($filePath, $csvContent);

    $fieldMapping = [
        'name' => 0,
        'email' => 1
    ];

    Log::spy();

    $job = new Import{Module}Job($filePath, $fieldMapping);
    $job->handle();

    $this->assertDatabaseHas('{module_}', [
        'name' => 'Jane Smith',
        'email' => 'jane@example.com'
    ]);

    $this->assertDatabaseMissing('{module_}', [
        'email' => 'invalid-email'
    ]);

    $this->assertEquals(1, {Model}::count());

    Log::shouldHaveReceived('warning')
        ->with('Invalid data during import', \Mockery::any());
});

test('handles missing required fields', function () {
    $csvContent = "name,email\n,john@example.com";
    $filePath = Storage::path('{module-}.csv');
    file_put_contents($filePath, $csvContent);

    $fieldMapping = [
        'name' => 0,
        'email' => 1
    ];

    Log::spy();

    $job = new Import{Module}Job($filePath, $fieldMapping);
    $job->handle();

    $this->assertEquals(0, {Model}::count());

    Log::shouldHaveReceived('warning')
        ->with('Invalid data during import', \Mockery::any());
});

test('processes large datasets in chunks', function () {
    $csvContent = "name,email\n";
    for ($i = 1; $i <= 100; $i++) {
        $csvContent .= "User {$i},user{$i}@example.com\n";
    }

    $filePath = Storage::path('{module--}.csv');
    file_put_contents($filePath, $csvContent);

    $fieldMapping = [
        'name' => 0,
        'email' => 1
    ];

    $job = new Import{Module}Job($filePath, $fieldMapping);

    $reflectionClass = new ReflectionClass($job);
    $reflectionProperty = $reflectionClass->getProperty('chunkSize');
    $reflectionProperty->setAccessible(true);
    $reflectionProperty->setValue($job, 10);

    $job->handle();

    $this->assertEquals(100, {Model}::count());
});

test('handles custom field mapping', function () {
    $csvContent = "email,full_name\njohn@example.com,John Doe\njane@example.com,Jane Smith";
    $filePath = Storage::path('{module-}.csv');
    file_put_contents($filePath, $csvContent);

    $fieldMapping = [
        'name' => 1,
        'email' => 0
    ];

    $job = new Import{Module}Job($filePath, $fieldMapping);
    $job->handle();

    $this->assertDatabaseHas('{module_}', [
        'name' => 'John Doe',
        'email' => 'john@example.com'
    ]);

    $this->assertDatabaseHas('{module_}', [
        'name' => 'Jane Smith',
        'email' => 'jane@example.com'
    ]);
});

test('handles file open errors gracefully', function () {
    $filePath = '/non/existent/path/{module-}.csv';

    Log::spy();

    $fieldMapping = [
        'name' => 0,
        'email' => 1
    ];

    try {
        $job = new Import{Module}Job($filePath, $fieldMapping);
        $job->handle();
    } catch (\Exception $e) {
        // Exception is expected
    }

    $this->assertEquals(0, {Model}::count());
});

test('logs import statistics', function () {
    $csvContent = "name,email\nJohn Doe,john@example.com\nJane Smith,jane@example.com";
    $filePath = Storage::path('{module--}.csv');
    file_put_contents($filePath, $csvContent);

    $fieldMapping = [
        'name' => 0,
        'email' => 1
    ];

    Log::spy();

    $job = new Import{Module}Job($filePath, $fieldMapping);
    $job->handle();

    Log::shouldHaveReceived('info')
        ->with('{Model} import completed', [
            'processed' => 2,
            'success' => 2,
            'errors' => 0,
        ]);
});
