<?php

declare(strict_types=1);

namespace Modules\Users\Livewire\Admin;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class UserMenu extends Component
{
    public function render(): View
    {
        return view('users::livewire.admin.user-menu');
    }
}
