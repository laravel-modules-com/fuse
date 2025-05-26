<?php

declare(strict_types=1);

namespace Modules\{Module}\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Modules\{Module}\Models\{Model};

class Import{Module}Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds the job can run before timing out.
     */
    public int $timeout = 3600; // 1 hour

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The number of records to process in each chunk.
     */
    protected int $chunkSize = 1000;

    /**
     * Create a new job instance.
     *
     * @param  string  $filePath  The path to the CSV file
     * @param  array<string, int|string>  $fieldMapping  The mapping of fields to CSV column indices
     */
    public function __construct(
        protected string $filePath,
        protected array $fieldMapping
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Open the CSV file
        $file = fopen($this->filePath, 'r');
        if (! $file) {
            Log::error('Failed to open CSV file for import', [
                'file_path' => $this->filePath,
            ]);

            return;
        }

        // Skip the header row
        fgetcsv($file);

        $processedRows = 0;
        $successCount = 0;
        $errorCount = 0;
        $chunk = [];

        // Process the file in chunks
        while (($row = fgetcsv($file)) !== false) {
            $processedRows++;

            // Map the CSV columns to fields
            ${model}Data = $this->mapRowTo{Model}Data($row);

            // Validate the data
            $validator = Validator::make(${model}Data, [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
            ]);

            if ($validator->fails()) {
                $errorCount++;
                Log::warning('Invalid data during import', [
                    'errors' => $validator->errors()->toArray(),
                    'data' => ${model}Data,
                    'row_number' => $processedRows,
                ]);

                continue;
            }

            $chunk[] = ${model}Data;

            // Process in chunks to reduce memory usage
            if (count($chunk) >= $this->chunkSize) {
                $successCount += $this->save{Model}s($chunk);
                $chunk = [];
            }
        }

        // Save any remaining {model}s
        if (! empty($chunk)) {
            $successCount += $this->save{Model}s($chunk);
        }

        fclose($file);

        Log::info('{Model} import completed', [
            'processed' => $processedRows,
            'success' => $successCount,
            'errors' => $errorCount,
        ]);
    }

    /**
     * Map a CSV row to data using the field mapping.
     *
     * @param  array<int, string|null>  $row  The CSV row
     * @return array<string, string|null> The mapped {model} data
     */
    protected function mapRowTo{Model}Data(array $row): array
    {
        ${model}Data = [];

        foreach ($this->fieldMapping as $field => $columnIndex) {
            // Skip empty column indices
            if ($columnIndex === '') {
                continue;
            }

            // Convert string column index to integer if it's numeric
            $index = is_numeric($columnIndex) ? (int) $columnIndex : $columnIndex;

            // Only use integer indices to access the row array
            if (is_int($index) && isset($row[$index])) {
                ${model}Data[$field] = $row[$index];
            }
        }

        return ${model}Data;
    }

    /**
     * Save a chunk of {model}s to the database.
     *
     * @param  array<int, array<string, string|null>>  ${model}s  Array of {model} data
     * @return int Number of {model}s successfully saved
     */
    protected function save{Model}s(array ${model}s): int
    {
        $successCount = 0;

        foreach (${model}s as ${model}Data) {
            try {
                // Check if {model} with this email already exists
                $existing{Model} = {Model}::where('email', ${model}Data['email'])->first();

                if ($existing{Model}) {
                    // Update existing {model}
                    $existing{Model}->update(${model}Data);
                } else {
                    // Create new {model}
                        {Model}::create(${model}Data);
                }

                $successCount++;
            } catch (\Exception $e) {
                Log::error('Error saving {model} during import', [
                    'error' => $e->getMessage(),
                    'data' => ${model}Data,
                ]);
            }
        }

        return $successCount;
    }
}
