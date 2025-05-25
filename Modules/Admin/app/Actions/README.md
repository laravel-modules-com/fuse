# Admin Module Actions

This directory contains reusable actions that can be used across the application.

## ExportToCsvAction

The `ExportToCsvAction` provides a generic way to export data to CSV files. It's designed to handle large datasets efficiently by using streaming and chunking.

### Usage

```php
use Modules\Admin\Actions\ExportToCsvAction;

// In your controller or Livewire component:
public function exportData()
{
    abort_if_cannot('export_permission');

    $filename = 'export_'.date('Y-m-d_His').'.csv';
    $headers = ['ID', 'Name', 'Email', 'Created At'];
    
    // Option 1: Using a query builder
    $query = YourModel::query()
        ->where('some_condition', true)
        ->orderBy('created_at', 'desc');
        
    return app(ExportToCsvAction::class)(
        $filename,
        $headers,
        $query
    );
    
    // Option 2: Using a collection
    $collection = YourModel::all();
    
    return app(ExportToCsvAction::class)(
        $filename,
        $headers,
        $collection
    );
    
    // Option 3: Using an array
    $data = [
        ['id' => 1, 'name' => 'John', 'email' => 'john@example.com', 'created_at' => '2023-01-01'],
        ['id' => 2, 'name' => 'Jane', 'email' => 'jane@example.com', 'created_at' => '2023-01-02'],
    ];
    
    return app(ExportToCsvAction::class)(
        $filename,
        $headers,
        $data
    );
}
```

### Parameters

- `$filename` (string): The name of the CSV file. If it doesn't end with '.csv', the extension will be added automatically.
- `$headers` (array): An array of column headers for the CSV file.
- `$data` (Builder|Collection|array): The data to export. Can be a query builder, a collection, or an array.
- `$chunkSize` (int, optional): The number of records to process at once when using a query builder. Defaults to 1000.

### Features

- Handles large datasets efficiently by using streaming and chunking
- Supports different data sources: query builders, collections, and arrays
- Automatically adds the '.csv' extension to the filename if needed
- Sets appropriate headers for CSV download
