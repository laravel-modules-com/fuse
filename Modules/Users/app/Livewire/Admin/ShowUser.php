<?php

declare(strict_types=1);

namespace Modules\Users\Livewire\Admin;

use App\Models\User;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('View User')]
class ShowUser extends Component
{
    public User $user;

    public function render(): View
    {
        abort_if_cannot('view_users_profiles');

        return view('users::livewire.admin.show');
    }
}
