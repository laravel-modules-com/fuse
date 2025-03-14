<?php

declare(strict_types=1);

namespace Modules\Blog\Livewire;

use Illuminate\View\View;
use Livewire\Component;
use Modules\Blog\Models\Post;

use function view;

class Search extends Component
{
    public $search;

    public $posts;

    public function render(): View
    {
        // split on 1+ whitespace & ignore empty (eg trailing space)
        $searchValues = preg_split('/\s+/', $this->search, -1, PREG_SPLIT_NO_EMPTY);

        $this->posts = Post::date()->take(15)->order()->where(function ($q) use ($searchValues) {
            foreach ($searchValues as $value) {
                $q->orWhere('title', 'like', "%{$value}%");
            }
        })->get();

        return view('blog::livewire.search');
    }
}
