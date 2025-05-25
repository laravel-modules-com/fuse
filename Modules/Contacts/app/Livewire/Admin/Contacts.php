<?php

declare(strict_types=1);

namespace Modules\Contacts\Livewire\Admin;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Admin\Actions\ExportToCsvAction;
use Modules\Contacts\Models\Contact;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    public function exportContacts(): StreamedResponse
    {
        abort_if_cannot('export_contacts');

        $filename = 'contacts_'.date('Y-m-d_His').'.csv';
        $headers = ['ID', 'Name', 'Email', 'Created At'];

        $query = Contact::query()
            ->when($this->name, function ($query) {
                return $query->where('name', 'like', '%'.$this->name.'%');
            })
            ->when($this->email, function ($query) {
                return $query->where('email', 'like', '%'.$this->email.'%');
            })
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');

        /** @var ExportToCsvAction<Contact> $action */
        $action = app(ExportToCsvAction::class);

        return $action(
            $filename,
            $headers,
            $query
        );
    }
}
