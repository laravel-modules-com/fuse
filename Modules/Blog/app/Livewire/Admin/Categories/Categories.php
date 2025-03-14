<?php

declare(strict_types=1);

namespace Modules\Blog\Livewire\Admin\Categories;

use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Blog\Models\Category;

#[Title('Categories')]
class Categories extends Component
{
    use WithPagination;

    public string $title = '';

    public string $updatedAt = '';

    public string $createdAt = '';

    public string $sortField = 'title';

    public bool $sortAsc = true;

    public bool $openFilter = false;

    protected $listeners = ['refresh-categories' => '$refresh'];

    public function render(): View
    {
        abort_if_cannot('view_blog_categories');

        return view('blog::livewire.admin.categories.index');
    }

    public function builder()
    {
        return Category::with('children')->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
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

    public function categories(): LengthAwarePaginator
    {
        $query = $this->builder();

        if ($this->title) {
            $query->where('title', 'like', '%'.$this->title.'%');
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

        return $query->paginate(50);
    }

    public function resetFilters(): void
    {
        $this->reset();
    }

    public function deleteCategory(Category $category): RedirectResponse
    {
        abort_if_cannot('delete_blog_categories');

        $category->delete();

        flash('Category deleted')->success();

        return to_route('admin.blog.categories.index');
    }
}
