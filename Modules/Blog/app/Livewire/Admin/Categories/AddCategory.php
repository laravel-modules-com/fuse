<?php

declare(strict_types=1);

namespace Modules\Blog\Livewire\Admin\Categories;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;
use Modules\Blog\Models\Category;

#[Title('Create Category')]
class AddCategory extends Component
{
    public $title;

    public $parentId = 0;

    public $categories;

    protected array $rules = [
        'title' => 'required|string',
    ];

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function mount(): void
    {
        $this->categories = Category::where('parent_id', '0')->orderBy('title')->get();
    }

    public function render(): View
    {
        abort_if_cannot('add_blog_categories');

        return view('blog::livewire.admin.categories.add');
    }

    public function store()
    {
        $this->validate();

        $category = Category::create([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'parent_id' => $this->parentId,
        ]);

        add_user_log([
            'reference_id' => $category->id,
            'title' => 'Added category: '.$this->title,
            'link' => route('admin.blog.index'),
            'section' => 'Blog Category',
            'type' => 'Create',
        ]);

        flash('Category created')->success();

        return to_route('admin.blog.categories.index');
    }
}
