<?php

declare(strict_types=1);

namespace Modules\Blog\Livewire\Admin\Posts;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Blog\Models\Post;

#[Title('Posts')]
class Posts extends Component
{
    use WithPagination;

    public string $title = '';

    public string $displayAt = '';

    public string $updatedAt = '';

    public string $createdAt = '';

    public string $sortField = 'display_at';

    public bool $sortAsc = false;

    public bool $openFilter = false;

    public function render(): View
    {
        abort_if_cannot('view_blog_posts');

        return view('blog::livewire.admin.posts.index');
    }

    public function builder()
    {
        return Post::orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
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

    public function posts()
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

        if ($this->displayAt) {
            $this->openFilter = true;
            $parts = explode(' to ', $this->displayAt);
            if (isset($parts[1])) {
                $from = Carbon::parse($parts[0])->format('Y-m-d');
                $to = Carbon::parse($parts[1])->format('Y-m-d');
                $query->whereBetween('display_at', [$from, $to]);
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

    public function deletePost(Post $id): void
    {
        abort_if_cannot('delete_blog_posts');

        $this->builder()->findOrFail($id)->delete();

        $this->dispatch('close-modal');
    }
}
