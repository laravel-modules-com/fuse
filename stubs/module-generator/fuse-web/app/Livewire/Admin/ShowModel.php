<?php

declare(strict_types=1);

namespace Modules\{Module}\Livewire\Admin;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;
use Modules\{Module}\Models\{Model};

use function abort_if_cannot;
use function view;

#[Title('View {Model }')]
class Show{Model} extends Component
{
    public {model} ${modelCamel};

    public function mount({Model} ${model_}): void
    {
        $this->{modelCamel} = ${model_};
    }

    public function render(): View
    {
        abort_if_cannot('view_{model_}');

        return view('{module}::livewire.admin.show-{model-}');
    }
}
