<?php

declare(strict_types=1);

namespace Modules\Admin\Livewire\Admin;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use function view;

class HelpMenu extends Component
{
    public function render(): View
    {
        return view('admin::livewire.admin.help-menu');
    }
}
