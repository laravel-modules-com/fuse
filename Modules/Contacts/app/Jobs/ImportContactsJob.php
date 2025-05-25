<?php

declare(strict_types=1);

namespace Modules\Contacts\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Modules\Contacts\Models\Contact;

class ImportContactsJob implements ShouldQueue
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
     * @param  array<string, int|string>  $fieldMapping  The mapping of contact fields to CSV column indices
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

            // Map the CSV columns to contact fields
            $contactData = $this->mapRowToContactData($row);

            // Validate the data
            $validator = Validator::make($contactData, [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
            ]);

            if ($validator->fails()) {
                $errorCount++;
                Log::warning('Invalid contact data during import', [
                    'errors' => $validator->errors()->toArray(),
                    'data' => $contactData,
                    'row_number' => $processedRows,
                ]);

                continue;
            }

            $chunk[] = $contactData;

            // Process in chunks to reduce memory usage
            if (count($chunk) >= $this->chunkSize) {
                $successCount += $this->saveContacts($chunk);
                $chunk = [];
            }
        }

        // Save any remaining contacts
        if (! empty($chunk)) {
            $successCount += $this->saveContacts($chunk);
        }

        fclose($file);

        Log::info('Contact import completed', [
            'processed' => $processedRows,
            'success' => $successCount,
            'errors' => $errorCount,
        ]);
    }

    /**
     * Map a CSV row to contact data using the field mapping.
     *
     * @param  array<int, string|null>  $row  The CSV row
     * @return array<string, string|null> The mapped contact data
     */
    protected function mapRowToContactData(array $row): array
    {
        $contactData = [];

        foreach ($this->fieldMapping as $field => $columnIndex) {
            // Skip empty column indices
            if ($columnIndex === '') {
                continue;
            }

            // Convert string column index to integer if it's numeric
            $index = is_numeric($columnIndex) ? (int) $columnIndex : $columnIndex;

            // Only use integer indices to access the row array
            if (is_int($index) && isset($row[$index])) {
                $contactData[$field] = $row[$index];
            }
        }

        return $contactData;
    }

    /**
     * Save a chunk of contacts to the database.
     *
     * @param  array<int, array<string, string|null>>  $contacts  Array of contact data
     * @return int Number of contacts successfully saved
     */
    protected function saveContacts(array $contacts): int
    {
        $successCount = 0;

        foreach ($contacts as $contactData) {
            try {
                // Check if contact with this email already exists
                $existingContact = Contact::where('email', $contactData['email'])->first();

                if ($existingContact) {
                    // Update existing contact
                    $existingContact->update($contactData);
                } else {
                    // Create new contact
                    Contact::create($contactData);
                }

                $successCount++;
            } catch (\Exception $e) {
                Log::error('Error saving contact during import', [
                    'error' => $e->getMessage(),
                    'data' => $contactData,
                ]);
            }
        }

        return $successCount;
    }
}
