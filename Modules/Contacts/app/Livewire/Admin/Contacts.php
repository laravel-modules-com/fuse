<?php

declare(strict_types=1);

namespace Modules\Contacts\Livewire\Admin;

use Modules\Contacts\Models\Contact;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Contacts')]
class Contacts extends Component
{
    use WithPagination;

    public int $paginate = 25;

    public string $name = '';

    public string $email = '';

    public string $sortField = 'name';

    public bool $sortAsc = true;

    public bool $openFilter = false;

    public function render(): View
    {
        abort_if_cannot('view_contacts');

        return view('contacts::livewire.admin.contacts');
    }

    /**
     * @return Builder<Contact>
     */
    public function builder(): Builder
    {
        return Contact::query()->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        }

        $this->sortField = $field;
    }

    /**
     * @return LengthAwarePaginator<int, Contact>
     */
    public function contacts(): LengthAwarePaginator
    {
        $query = $this->builder();

        if ($this->name) {
            $query->where('name', 'like', '%'.$this->name.'%');
        }

        if ($this->email) {
            $this->openFilter = true;
            $query->where('email', 'like', '%'.$this->email.'%');
        }

        return $query->paginate($this->paginate);
    }

    public function resetFilters(): void
    {
        $this->reset();
    }

    public function deleteContact(string $id): void
    {
        abort_if_cannot('delete_contacts');

        $this->builder()->findOrFail($id)->delete();

        $this->dispatch('close-modal');
    }
}
