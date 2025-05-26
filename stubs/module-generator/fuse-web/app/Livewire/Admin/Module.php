<?php

declare(strict_types=1);

namespace Modules\{Module}\Livewire\Admin;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Admin\Actions\ExportToCsvAction;
use Modules\{Module}\Models\{Model};
use Symfony\Component\HttpFoundation\StreamedResponse;

#[Title('{Module }')]
class {Module} extends Component
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
        abort_if_cannot('view_{module_}');

        return view('{module}::livewire.admin.{module-}');
    }

    public function affected{Module}Count(): int
    {
        if (! empty($this->selected)) {
            return count($this->selected);
        }

        return $this->load{Module}()->total();
    }

    /**
     * @return Builder<{Model}>
     */
    public function builder(): Builder
    {
        return {Model}::query()->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        }

        $this->sortField = $field;
    }

    /**
     * @return Builder<{Model}>
     */
    public function filteredBuilder(): Builder
    {
        return $this->builder()
            ->when($this->name, fn ($query) => $query->where('name', 'like', '%'.$this->name.'%'))
            ->when($this->email, fn ($query) => $query->where('email', 'like', '%'.$this->email.'%'));
    }

    /**
     * @return LengthAwarePaginator<int, {Model}>
     */
    public function load{ModuleCamel}(): LengthAwarePaginator
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
            $this->selected = collect($this->load{Module}()->items())->pluck('id')->map('strval')->all();
        } else {
            $this->selected = [];
        }
    }

    public function delete{Model}(string $id): void
    {
        abort_if_cannot('delete_{module_}');

        $this->builder()->findOrFail($id)->delete();

        $this->dispatch('close-modal');
    }

    public function export{Module}(): StreamedResponse
    {
        abort_if_cannot('export_{module_}');

        $filename = '{module}_'.date('Y-m-d_His').'.csv';
        $headers = ['ID', 'Name', 'Email', 'Created At'];

        $query = ! empty($this->selected)
            ? {Model}::query()->whereIn('id', $this->selected)
            : $this->filteredBuilder();

        add_user_log([
            'title' => 'Exported {Module }',
            'section' => '{Module }',
            'type' => 'Export',
        ]);

        /** @var ExportToCsvAction<{Model}> $action */
        $action = app(ExportToCsvAction::class);

        return $action(
            $filename,
            $headers,
            $query
        );
    }

    public function archive{ModuleCamel}(): void
    {
        abort_if_cannot('delete_{module_}');

        $query = ! empty($this->selected)
            ? {ModelCamel}::query()->whereIn('id', $this->selected)
            : $this->filteredBuilder();

        add_user_log([
            'title' => 'Archived {Module }',
            'section' => '{Module }',
            'type' => 'Archived',
        ]);

        $query->delete();
    }
}
