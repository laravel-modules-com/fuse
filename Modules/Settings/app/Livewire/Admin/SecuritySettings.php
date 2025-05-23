<?php

declare(strict_types=1);

namespace Modules\Settings\Livewire\Admin;

use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Component;
use Modules\Settings\Models\Setting;

class SecuritySettings extends Component
{
    /**
     * @var array<int, array<string, string>>
     */
    public array $ips = [];

    /**
     * @var array<string, array<int, string>>
     */
    protected array $rules = [
        'ips.*.ip' => [
            'required',
            'ip',
        ],
    ];

    /**
     * @var array<string, string>
     */
    protected array $messages = [
        'ips.*.ip.required' => 'IP is required',
        'ips.*.ip.ip' => 'Please enter a valid IP address',
    ];

    public function mount(): void
    {
        $ips = Setting::where('key', 'ips')->value('value');
        if ($ips !== null) {
            $this->ips = json_decode($ips, true);
        }
    }

    public function render(): View
    {
        return view('settings::livewire.admin.security-settings');
    }

    public function add(): void
    {
        $this->ips[] = [
            'ip' => '',
            'comment' => '',
        ];
    }

    public function remove(int $index): void
    {
        unset($this->ips[$index]);
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

        $ips = json_encode($this->ips);

        Cache::flush();
        Setting::updateOrCreate(['key' => 'ips'], ['value' => $ips]);

        add_user_log([
            'title' => 'updated security settings',
            'link' => route('admin.system-settings'),
            'reference_id' => auth()->id(),
            'section' => 'Settings',
            'type' => 'Update',
        ]);

        flash('Security Settings Updated!')->success();
    }
}
