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

    /**
     * @var array<string>
     */
    public array $selected = [];

    public bool $selectAll = false;

    public function render(): View
    {
        abort_if_cannot('view_contacts');

        return view('contacts::livewire.admin.contacts');
    }

    public function affectedContactsCount(): int
    {
        if (! empty($this->selected)) {
            return count($this->selected);
        }

        return $this->contacts()->total();
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
     * @return Builder<Contact>
     */
    public function filteredBuilder(): Builder
    {
        return $this->builder()
            ->when($this->name, fn ($query) => $query->where('name', 'like', '%'.$this->name.'%'))
            ->when($this->email, fn ($query) => $query->where('email', 'like', '%'.$this->email.'%'));
    }

    /**
     * @return LengthAwarePaginator<int, Contact>
     */
    public function contacts(): LengthAwarePaginator
    {
        return $this->filteredBuilder()->paginate($this->paginate);
    }

    public function resetFilters(): void
    {
        $this->reset(['name', 'email', 'openFilter', 'selected', 'selectAll']);
    }

    public function updatedSelectAll(): void
    {
        if ($this->selectAll) {
            $this->selected = collect($this->contacts()->items())->pluck('id')->map('strval')->all();
        } else {
            $this->selected = [];
        }
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

        $query = ! empty($this->selected)
            ? Contact::query()->whereIn('id', $this->selected)
            : $this->filteredBuilder();

        add_user_log([
            'title' => 'Exported contacts',
            'section' => 'Contacts',
            'type' => 'Export',
        ]);

        /** @var ExportToCsvAction<Contact> $action */
        $action = app(ExportToCsvAction::class);

        return $action(
            $filename,
            $headers,
            $query
        );
    }

    public function archiveContacts(): void
    {
        abort_if_cannot('delete_contacts');

        $query = ! empty($this->selected)
            ? Contact::query()->whereIn('id', $this->selected)
            : $this->filteredBuilder();

        add_user_log([
            'title' => 'Archived contacts',
            'section' => 'Contacts',
            'type' => 'Archived',
        ]);

        $query->delete();
    }
}
