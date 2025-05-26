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

#[Title('Edit {Model }')]
class Edit{Model} extends Component
{
    public {modelCamel} ${modelCamel};

    public string $name = '';

    public string $email = '';

    public function mount({Model} ${model_}): void
    {
        $this->{modelCamel} = ${model_};
        $this->name = ${model_}->name;
        $this->email = ${model_}->email;
    }

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
                'unique:{module_},email,'.$this->{modelCamel}->id,
            ],
        ];
    }

    public function render(): View
    {
        abort_if_cannot('edit_{module_}');

        return view('{module}::livewire.admin.edit-{model-}');
    }

    public function update(): Redirector|RedirectResponse
    {
        $validated = $this->validate();
        $this->{modelCamel}->update($validated);

        add_user_log([
            'title' => 'Updated {Model } '.$this->name,
            'reference_id' => $this->{modelCamel}->id,
            'link' => route('admin.{module-}.show', ['{model_}' => $this->{modelCamel}->id]),
            'section' => '{Module }',
            'type' => 'Update',
        ]);

        flash('{Model } Updated!')->success();

        return redirect()->route('admin.{module-}.index');
    }
}
