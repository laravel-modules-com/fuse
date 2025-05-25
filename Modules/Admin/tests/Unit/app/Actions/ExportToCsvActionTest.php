<?php

use Illuminate\Database\Eloquent\Builder;
use Modules\Admin\Actions\ExportToCsvAction;
use Symfony\Component\HttpFoundation\StreamedResponse;

test('it adds csv extension to filename if not present', function () {
    $filename = 'test_export';
    $headers = ['ID', 'Name'];
    $data = [['1', 'Test']];

    $response = app(ExportToCsvAction::class)($filename, $headers, $data);

    expect($response)
        ->toBeInstanceOf(StreamedResponse::class)
        ->and($response->headers->get('Content-Disposition'))
        ->toContain('filename=test_export.csv');
});

test('it keeps csv extension if already present in filename', function () {
    $filename = 'test_export.csv';
    $headers = ['ID', 'Name'];
    $data = [['1', 'Test']];

    $response = app(ExportToCsvAction::class)($filename, $headers, $data);

    expect($response)
        ->toBeInstanceOf(StreamedResponse::class)
        ->and($response->headers->get('Content-Disposition'))
        ->toContain('filename=test_export.csv');
});

test('it sets correct content type header', function () {
    $filename = 'test_export.csv';
    $headers = ['ID', 'Name'];
    $data = [['1', 'Test']];

    $response = app(ExportToCsvAction::class)($filename, $headers, $data);

    expect($response->headers->get('Content-Type'))->toBe('text/csv');
});

test('it exports data from an array', function () {
    $filename = 'test_export.csv';
    $headers = ['ID', 'Name'];
    $data = [
        ['id' => '1', 'name' => 'John'],
        ['id' => '2', 'name' => 'Jane'],
    ];

    $response = app(ExportToCsvAction::class)($filename, $headers, $data);

    // Capture the output of the streamed response
    ob_start();
    $response->sendContent();
    $content = ob_get_clean();

    // Check that the CSV content is correct
    expect($content)
        ->toContain('ID,Name')
        ->toContain('1,John')
        ->toContain('2,Jane');
});

test('it exports data from a collection', function () {
    $filename = 'test_export.csv';
    $headers = ['ID', 'Name'];
    $data = collect([
        ['id' => '1', 'name' => 'John'],
        ['id' => '2', 'name' => 'Jane'],
    ]);

    $response = app(ExportToCsvAction::class)($filename, $headers, $data);

    // Capture the output of the streamed response
    ob_start();
    $response->sendContent();
    $content = ob_get_clean();

    // Check that the CSV content is correct
    expect($content)
        ->toContain('ID,Name')
        ->toContain('1,John')
        ->toContain('2,Jane');
});

test('it exports data from a query builder', function () {
    // Mock a Builder instance
    $items = collect([
        (object) ['id' => '1', 'name' => 'John'],
        (object) ['id' => '2', 'name' => 'Jane'],
    ]);

    $builder = Mockery::mock(Builder::class);
    $builder->shouldReceive('chunk')
        ->once()
        ->with(1000, Mockery::on(function ($callback) use ($items) {
            $callback($items);

            return true;
        }));

    $filename = 'test_export.csv';
    $headers = ['ID', 'Name'];

    $response = app(ExportToCsvAction::class)($filename, $headers, $builder);

    // Capture the output of the streamed response
    ob_start();
    $response->sendContent();
    $content = ob_get_clean();

    // Check that the CSV content is correct
    expect($content)
        ->toContain('ID,Name')
        ->toContain('1,John')
        ->toContain('2,Jane');
});

test('it extracts values from objects with toArray method', function () {
    $filename = 'test_export.csv';
    $headers = ['ID', 'Name'];

    // Create a mock object with a toArray method
    $obj1 = new class
    {
        public function toArray()
        {
            return ['id' => '1', 'name' => 'John'];
        }
    };

    $obj2 = new class
    {
        public function toArray()
        {
            return ['id' => '2', 'name' => 'Jane'];
        }
    };

    $data = collect([$obj1, $obj2]);

    $response = app(ExportToCsvAction::class)($filename, $headers, $data);

    // Capture the output of the streamed response
    ob_start();
    $response->sendContent();
    $content = ob_get_clean();

    // Check that the CSV content is correct
    expect($content)
        ->toContain('ID,Name')
        ->toContain('1,John')
        ->toContain('2,Jane');
});

test('it can handle custom chunk sizes for query builders', function () {
    // Mock a Builder instance
    $items = collect([
        (object) ['id' => '1', 'name' => 'John'],
        (object) ['id' => '2', 'name' => 'Jane'],
    ]);

    $builder = Mockery::mock(Builder::class);
    $builder->shouldReceive('chunk')
        ->once()
        ->with(500, Mockery::on(function ($callback) use ($items) {
            $callback($items);

            return true;
        }));

    $filename = 'test_export.csv';
    $headers = ['ID', 'Name'];
    $chunkSize = 500;

    $response = app(ExportToCsvAction::class)($filename, $headers, $builder, $chunkSize);

    // Capture the output of the streamed response
    ob_start();
    $response->sendContent();
    $content = ob_get_clean();

    // Check that the CSV content is correct
    expect($content)
        ->toContain('ID,Name')
        ->toContain('1,John')
        ->toContain('2,Jane');
});
