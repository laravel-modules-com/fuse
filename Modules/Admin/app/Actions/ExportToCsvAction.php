<?php

declare(strict_types=1);

namespace Modules\Admin\Actions;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * @template TModel of Model
 */
class ExportToCsvAction
{
    /**
     * Export data to a CSV file.
     *
     * @param  string  $filename  The name of the CSV file
     * @param  array<string>  $headers  The CSV headers
     * @param  Builder<TModel>|Collection<int, array<string, mixed>>|array<array<string, mixed>>  $data  The data to export
     * @param  int  $chunkSize  The number of records to process at once (for Builder queries)
     */
    public function __invoke(string $filename, array $headers, Builder|Collection|array $data, int $chunkSize = 1000): StreamedResponse
    {
        if (! str_ends_with(strtolower($filename), '.csv')) {
            $filename .= '.csv';
        }

        return response()->streamDownload(function () use ($headers, $data, $chunkSize) {
            // Open output stream
            $handle = fopen('php://output', 'w');

            /** @var resource $handle */
            fputcsv($handle, $headers);

            // Process data based on its type
            if ($data instanceof Builder) {
                // Process a query in chunks to handle large datasets
                $data->chunk($chunkSize, function ($items) use ($handle) {
                    foreach ($items as $item) {
                        fputcsv($handle, $this->extractValues($item));
                    }
                });
            } elseif ($data instanceof Collection) {
                // Process collection
                $data->each(function ($item) use ($handle) {
                    fputcsv($handle, $this->extractValues($item));
                });
            } else {
                // Process array
                foreach ($data as $item) {
                    fputcsv($handle, array_values($item));
                }
            }

            // Close the output stream
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }

    /**
     * Extract values from an item for CSV export.
     *
     * @return array<mixed>
     */
    private function extractValues(mixed $item): array
    {
        if (is_array($item)) {
            return array_values($item);
        }

        if (is_object($item)) {
            if (method_exists($item, 'toArray')) {
                return array_values($item->toArray());
            }

            return array_values((array) $item);
        }

        return (array) $item;
    }
}
