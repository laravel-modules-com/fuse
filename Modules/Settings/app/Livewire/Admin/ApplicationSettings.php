<?php

declare(strict_types=1);

namespace Modules\Settings\Livewire\Admin;

use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Component;
use Modules\Settings\Models\Setting;

class ApplicationSettings extends Component
{
    public string $siteName = '';

    public bool $isForced2Fa = false;

    /**
     * @return array<string, array<int, string>>
     */
    protected function rules(): array
    {
        return [
            'siteName' => [
                'required',
                'string',
            ],
        ];
    }

    /**
     * @var array<string, string>
     */
    protected array $messages = [
        'siteName.required' => 'Site name is required',
    ];

    public function mount(): void
    {
        $this->siteName = Setting::where('key', 'app.name')->value('value') ?? '';
        $this->isForced2Fa = (bool) Setting::where('key', 'is_forced_2fa')->value('value');
    }

    public function render(): View
    {
        return view('settings::livewire.admin.application-settings');
    }

    /**
     * @throws ValidationException
     */
    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function update(): void
    {
        $this->validate();

        Setting::updateOrCreate(['key' => 'app.name'], ['value' => $this->siteName]);
        Setting::updateOrCreate(['key' => 'is_forced_2fa'], ['value' => $this->isForced2Fa]);

        add_user_log([
            'title' => 'updated application settings',
            'link' => route('admin.system-settings'),
            'reference_id' => auth()->id(),
            'section' => 'Settings',
            'type' => 'Update',
        ]);

        flash('Application Settings Updated!')->success();
    }
}
