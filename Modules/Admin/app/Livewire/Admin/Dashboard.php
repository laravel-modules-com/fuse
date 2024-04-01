<?php

declare(strict_types=1);

namespace Modules\Admin\Livewire\Admin;

use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
class Dashboard extends Component
{
    public function render(): View
    {
        abort_if_cannot('view_dashboard');

        return view('admin::livewire.admin.dashboard');
    }
}
