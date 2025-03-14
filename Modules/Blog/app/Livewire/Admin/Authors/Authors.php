<?php

declare(strict_types=1);

namespace Modules\Blog\Livewire\Admin\Authors;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Blog\Models\Author;

#[Title('Authors')]
class Authors extends Component
{
    use WithPagination;

    public string $name = '';

    public $updatedAt = '';

    public $createdAt = '';

    public $sortField = 'name';

    public $sortAsc = true;

    public $openFilter = false;

    protected $listeners = ['refresh-authors' => '$refresh'];

    public function render(): View
    {
        abort_if_cannot('view_blog_authors');

        return view('blog::livewire.admin.authors.index');
    }

    public function builder()
    {
        return Author::orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function authors()
    {
        $query = $this->builder();

        if ($this->name) {
            $query->where('name', 'like', '%'.$this->name.'%');
        }

        if ($this->updatedAt) {
            $this->openFilter = true;
            $parts = explode(' to ', $this->updatedAt);
            if (isset($parts[1])) {
                $from = Carbon::parse($parts[0])->format('Y-m-d');
                $to = Carbon::parse($parts[1])->format('Y-m-d');
                $query->whereBetween('updated_at', [$from, $to]);
            }
        }

        if ($this->createdAt) {
            $this->openFilter = true;
            $parts = explode(' to ', $this->createdAt);
            if (isset($parts[1])) {
                $from = Carbon::parse($parts[0])->format('Y-m-d');
                $to = Carbon::parse($parts[1])->format('Y-m-d');
                $query->whereBetween('created_at', [$from, $to]);
            }
        }

        return $query->paginate();
    }

    public function resetFilters(): void
    {
        $this->reset();
    }

    public function deleteAuthor($id)
    {
        abort_if_cannot('delete_blog_authors');

        $this->builder()->findOrFail($id)->delete();

        flash('Author deleted')->success();

        return to_route('admin.blog.authors.index');
    }
}
