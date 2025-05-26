<?php

declare(strict_types=1);

namespace Modules\{Module}\Livewire\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\{Module}\Models\{Model};

use function add_user_log;
use function flash;
use function redirect;
use function route;
use function view;

#[Title('Create {Model }')]
class Create{Model} extends Component
{
    public string $name = '';

    public string $email = '';

    /**
     * @return array<string, array<int, string>>
     */
    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:{module_},email',
            ],
        ];
    }

    public function render(): View
    {
        abort_if_cannot('add_{module_}');

        return view('{module}::livewire.admin.create-{model-}');
    }

    public function create(): Redirector|RedirectResponse
    {
        $validated = $this->validate();
        ${modelCamel} = {Model}::create($validated);

        add_user_log([
            'title' => 'Created {Model } '.$this->name,
            'reference_id' => ${modelCamel}->id,
            'link' => route('admin.{module-}.show', ['{model_}' => ${modelCamel}->id]),
            'section' => '{Module }',
            'type' => 'Create',
        ]);

        flash('{Model } Created!')->success();

        return redirect()->route('admin.{module-}.index');
    }
}
