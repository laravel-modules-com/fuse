<?php

declare(strict_types=1);

namespace Modules\Users\Livewire\Admin;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Users\Mail\SendInviteMail;

#[Title('Users')]
class Users extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    public int $paginate = 25;

    /**
     * @var array<string>
     */
    public array $checked = [];

    public string $name = '';

    public string $email = '';

    public string $joined = '';

    public string $sortField = 'name';

    public bool $sortAsc = true;

    public bool $openFilter = false;

    public bool $sentEmail = false;

    /**
     * @var array<string>
     */
    protected $listeners = ['refreshUsers' => '$refresh'];

    public function render(): View
    {
        abort_if_cannot('view_users');

        return view('users::livewire.admin.index');
    }

    /**
     * @return Builder<User>
     */
    public function builder(): Builder
    {
        return User::with(['roles', 'invite'])->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        }

        $this->sortField = $field;
    }

    /**
     * @return LengthAwarePaginator<int, User>
     */
    public function users(): LengthAwarePaginator
    {
        $query = $this->builder();

        if ($this->name) {
            $query->where('name', 'like', '%'.$this->name.'%');
        }

        if ($this->email) {
            $this->openFilter = true;
            $query->where('email', 'like', '%'.$this->email.'%');
        }

        if ($this->joined) {
            $this->openFilter = true;
            $parts = explode(' to ', $this->joined);
            if (isset($parts[1])) {
                $from = Carbon::parse($parts[0])->format('Y-m-d');
                $to = Carbon::parse($parts[1])->format('Y-m-d');
                $query->whereBetween('created_at', [$from, $to]);
            }
        }

        return $query->paginate($this->paginate);
    }

    public function resetFilters(): void
    {
        $this->reset();
    }

    public function deleteUser(string $id): void
    {
        abort_if_cannot('delete_users');

        $this->builder()->findOrFail($id)->delete();

        $this->dispatch('close-modal');
    }

    public function resendInvite(string $id): void
    {
        $user = User::findOrFail($id);
        Mail::queue((new SendInviteMail($user))->onQueue('notifications'));

        $user->invited_at = now();
        $user->save();

        $this->sentEmail = true;
    }
}
