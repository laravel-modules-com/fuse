<?php

declare(strict_types=1);

namespace Modules\Admin\Livewire\Admin;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Modules\Admin\Models\Notification;

class NotificationsMenu extends Component
{
    /**
     * @var Collection<int, Notification>
     */
    public Collection $notifications;

    public int $unseenCount = 0;

    public function mount(): void
    {
        $this->notifications = Notification::where('assigned_to_user_id', auth()->id())->take(20)->get();
        $this->unseenCount = Notification::where('assigned_to_user_id', auth()->id())->where('viewed', 0)->count();
    }

    public function render(): View
    {
        return view('admin::livewire.admin.notifications-menu');
    }

    public function open(): void
    {
        Notification::where('assigned_to_user_id', auth()->id())
            ->where('viewed', 0)
            ->update([
                'viewed' => 1,
                'viewed_at' => now(),
            ]);
    }
}
