<?php

declare(strict_types=1);

namespace Modules\Blog\Livewire;

use Illuminate\View\View;
use Livewire\Component;
use Modules\Blog\Models\Post;

class Archives extends Component
{
    public function render(): View
    {
        $databaseConnection = config('database.default');

        if ($databaseConnection === 'mysql') {
            $archives = Post::selectRaw('YEAR(display_at) as year')
                ->groupBy('year')
                ->orderByRaw('MIN(display_at) desc')
                ->get();
        } else {
            $archives = Post::selectRaw("strftime('%Y', display_at) as year")
                ->groupBy('year')
                ->orderByRaw('MIN(display_at) desc')
                ->get();
        }

        return view('blog::livewire.archives', compact('archives'))->layout('layouts.front');
    }
}
