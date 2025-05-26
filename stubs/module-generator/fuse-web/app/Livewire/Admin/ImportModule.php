<?php

declare(strict_types=1);

namespace Modules\{Module}\Livewire\Admin;

use File;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Features\SupportRedirects\Redirector;
use Livewire\WithFileUploads;
use Modules\{Module}\Jobs\Import{Module}Job;

use function add_user_log;
use function flash;
use function redirect;
use function view;

#[Title('Import {Module }')]
class Import{Module} extends Component
{
    use WithFileUploads;

    public ?TemporaryUploadedFile $csvFile = null;

    /**
     * Headers from the CSV file
     *
     * @var array<int, string>
     */
    public array $headers = [];

    /**
     * Parsed CSV data (first 5 rows)
     *
     * @var array<int, array<int, string|null>>
     */
    public array $csvData = [];

    /**
     * Field mapping for the CSV import
     *
     * @var array<string, int|string>
     */
    public array $fieldMapping = [];

    /**
     * Required fields for the import
     *
     * @var array<string>
     */
    public array $requiredFields = ['name', 'email'];

    public int $step = 1;

    public int $totalRows = 0;

    /**
     * @return array<string, array<int, string>>
     */
    protected function rules(): array
    {
        return [
            'csvFile' => [
                'required',
                'file',
                'mimes:csv,txt',
                'max:51200', // 50MB max
            ],
        ];
    }

    public function render(): View
    {
        abort_if_cannot('import_{module_}');

        return view('{module}::livewire.admin.import-{module-}');
    }

    public function updatedCsvFile(): void
    {
        $this->validate();

        $path = $this->csvFile->getRealPath();
        $file = fopen($path, 'r');

        /** @var resource $file */
        $headers = fgetcsv($file);
        $this->headers = $headers !== false ? array_map(fn ($value) => $value ?? '', $headers) : [];

        // Get a sample of the data (first 5 rows)
        $this->csvData = [];
        for ($i = 0; $i < 5; $i++) {
            $row = fgetcsv($file);
            if ($row) {
                $this->csvData[] = $row;
            } else {
                break;
            }
        }

        // Count total rows
        $this->totalRows = 0;
        rewind($file);
        // Skip header row
        fgetcsv($file);
        while (fgetcsv($file)) {
            $this->totalRows++;
        }

        fclose($file);

        // Initialize field mapping
        $this->fieldMapping = array_fill_keys($this->requiredFields, '');

        // Try to auto-map fields
        foreach ($this->headers as $index => $header) {
            $normalizedHeader = strtolower(trim((string) $header));
            if (in_array($normalizedHeader, $this->requiredFields)) {
                $this->fieldMapping[$normalizedHeader] = $index;
            }
        }

        $this->step = 2;
    }

    public function startImport(): Redirector|RedirectResponse
    {
        $this->validate([
            'fieldMapping.name' => 'required',
            'fieldMapping.email' => 'required',
        ], [
            'fieldMapping.name.required' => 'You must map the Name field',
            'fieldMapping.email.required' => 'You must map the Email field',
        ]);

        $path = $this->csvFile->getRealPath();

        // Convert string values to integers in field mapping
        $fieldMapping = array_map(function ($value) {
            return is_numeric($value) ? (int) $value : $value;
        }, $this->fieldMapping);

        Import{Module}Job::dispatch($path, $fieldMapping);

        add_user_log([
            'title' => 'Started import of '.$this->totalRows.' {module}',
            'section' => '{Module }',
            'type' => 'Import',
        ]);

        flash('{Model } import started! '.$this->totalRows.' {module } will be processed in the background.')->success();

        return redirect()->route('admin.{module-}.index');
    }

    public function back(): void
    {
        $this->step = 1;
        $this->reset(['headers', 'csvData', 'fieldMapping']);
    }
}
