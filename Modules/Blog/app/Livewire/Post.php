<?php

declare(strict_types=1);

namespace Modules\Blog\Livewire;

use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;
use Modules\Blog\Helpers\Tags;
use Modules\Blog\Models\Post as PostModel;
use TOC\MarkupFixer;
use TOC\TocGenerator;

class Post extends Component
{
    public $post;

    public $previous;

    public $next;

    public $content;

    public $toc;

    public $latestPosts;

    public function mount($slug): void
    {
        $this->post = PostModel::where('slug', $slug)->firstOrFail();
        $this->previous = PostModel::where('display_at', '<', $this->post->display_at)->orderBy('display_at', 'desc')->first();
        $this->next = PostModel::where('display_at', '>', $this->post->display_at)->orderBy('display_at')->first();
        $this->latestPosts = PostModel::orderBy('display_at', 'desc')->take(10)->get();

        $demo = "<a class='btn btn-primary' href='".$this->post->demo."' target='_blank'>Demo</a>";
        $download = "<a class='btn btn-primary' href='".$this->post->download."' target='_blank'>Download source files</a>";
        $content = $this->post->content;

        $content = str_replace('[download]', $download, $content);
        $content = str_replace('[demo]', $demo, $content);
        $content = Str::markdown($content);
        $content = Tags::get($content);

        $markupFixer = new MarkupFixer;
        $tocGenerator = new TocGenerator;
        $this->content = $markupFixer->fix($content);
        $this->toc = $tocGenerator->getHtmlMenu($this->content);
    }

    public function render(): View
    {
        return view('blog::livewire.post')->layout('layouts.front');
    }
}
