<?php

declare(strict_types=1);

namespace Modules\Blog\Livewire\Admin\Posts;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Blog\Models\Author;
use Modules\Blog\Models\Category;
use Modules\Blog\Models\CategoryPost;
use Modules\Blog\Models\Post;

#[Title('Create Post')]
class AddPost extends Component
{
    use WithFileUploads;

    public $title;

    public $slug;

    public $image;

    public $displayAt;

    public $description;

    public $content;

    public $categories;

    public $categoriesArray;

    public $authorId;

    public $authors;

    protected array $rules = [
        'title' => 'required',
        'displayAt' => 'required|date_format:d-m-Y H:i',
        'description' => 'required',
        'content' => 'required',
        'authorId' => 'required',
    ];

    public function mount(): void
    {
        $this->categories = Category::where('parent_id', '0')->orderBy('title')->get();
        $this->displayAt = date('d-m-Y H:i');
        $this->authors = Author::get()->sortBy('name')->pluck('name', 'id');
    }

    public function render(): View
    {
        abort_if_cannot('add_blog_posts');

        return view('blog::livewire.admin.posts.add');
    }

    public function updated($propertyName): void
    {
        if ($propertyName == 'title') {
            $this->slug = Str::slug($this->title);
        }

        $this->validateOnly($propertyName);
    }

    public function store()
    {
        $this->validate();

        $post = Post::create([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'author_id' => (string) $this->authorId,
            'description' => $this->description,
            'content' => $this->content,
            'display_at' => date('Y-m-d H:i:s', strtotime($this->displayAt)),
        ]);

        if (! empty($this->image)) {
            $name = $this->slug.'.png';
            $img = Image::make($this->image)->encode('png')->resize(900, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->stream();

            Storage::disk('images')->put('posts/'.$name, $img);

            $post->update(['image' => 'images/posts/'.$name]);
        }

        if (is_array($this->categoriesArray)) {
            foreach ($this->categoriesArray as $key => $value) {
                if ($value !== false) {
                    CategoryPost::create(['category_id' => $key, 'post_id' => $post->id]);
                }
            }
        }

        add_user_log([
            'title' => 'Create blog post: '.$this->title,
            'link' => route('admin.blog.posts.edit', $post),
            'reference_id' => auth()->id(),
            'section' => 'Blog',
            'type' => 'Create',
        ]);

        flash('Blog post created')->success();

        return redirect(route('admin.blog.index'));
    }
}
