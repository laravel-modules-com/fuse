<?php

declare(strict_types=1);

namespace Modules\Blog\Livewire;

use Illuminate\View\View;
use Livewire\Component;
use Modules\Blog\Models\Category;

class Categories extends Component
{
    public function render(): View
    {
        $categories = Category::with('posts')
            ->whereHas('posts')
            ->order()
            ->get();

        return view('blog::livewire.categories', compact('categories'))->layout('layouts.front');
    }
}
