<?php

declare(strict_types=1);

namespace Modules\Blog\Livewire\Admin\Categories;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;
use Modules\Blog\Models\Category;

#[Title('Edit Post')]
class EditCategory extends Component
{
    public Category $category;

    public $title;

    public $parentId = 0;

    public $categories;

    protected array $rules = [
        'title' => 'required|string',
    ];

    public function mount()
    {
        $this->title = $this->category->title;
        $this->parentId = $this->category->parent_id;
        $this->categories = Category::where('parent_id', '0')->orderBy('title')->get();
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function render(): View
    {
        abort_if_cannot('edit_blog_categories');

        return view('blog::livewire.admin.categories.edit');
    }

    public function update()
    {
        $this->validate();

        $this->category->title = $this->title;
        $this->category->parent_id = $this->parentId;
        $this->category->slug = Str::slug($this->title);
        $this->category->save();

        add_user_log([
            'reference_id' => $this->category->id,
            'title' => 'Updated category: '.$this->title,
            'link' => route('admin.blog.index'),
            'section' => 'Blog Category',
            'type' => 'Update',
        ]);

        flash('Category updated')->success();

        return to_route('admin.blog.categories.index');
    }
}
