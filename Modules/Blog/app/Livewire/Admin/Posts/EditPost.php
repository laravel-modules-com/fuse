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

#[Title('Edit Post')]
class EditPost extends Component
{
    use WithFileUploads;

    public Post $post;

    public $title;

    public $slug;

    public $image;

    public $exitingImage;

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
        'image' => 'nullable|mimes:jpg,png,gif,webp',
        'authorId' => 'required',
    ];

    public function mount()
    {
        $this->title = $this->post->title;
        $this->slug = $this->post->slug;
        $this->displayAt = $this->post->display_at->format('d-m-Y h:i');
        $this->exitingImage = $this->post->image;
        $this->description = $this->post->description;
        $this->content = $this->post->content;
        $this->authorId = $this->post->author_id;
        $this->categories = Category::where('parent_id', '0')->orderBy('title')->get();
        $catIds = $this->post->categories->pluck('id')->toArray();
        $this->categoriesArray = array_fill_keys($catIds, true);
        $this->authors = Author::get()->sortBy('name')->pluck('name', 'id');
    }

    public function render(): View
    {
        abort_if_cannot('edit_blog_posts');

        return view('blog::livewire.admin.posts.edit');
    }

    public function updated($propertyName): void
    {
        if ($propertyName == 'title') {
            $this->slug = Str::slug($this->title);
        }

        $this->validateOnly($propertyName);
    }

    public function update()
    {
        $this->validate();

        $this->post->update([
            'title' => $this->title,
            'slug' => Str::slug($this->slug),
            'display_at' => date('Y-m-d H:i:s', strtotime($this->displayAt)),
            'description' => $this->description,
            'content' => $this->content,
            'author_id' => $this->authorId,
        ]);

        if (! empty($this->image)) {
            if (file_exists($this->exitingImage)) {
                Storage::disk('images')->delete($this->exitingImage);
            }

            $name = $this->slug.'.png';
            $img = Image::make($this->image)->encode('png')->resize(900, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->stream();

            Storage::disk('images')->put('posts/'.$name, $img);

            $this->post->update(['image' => 'images/posts/'.$name]);
        }

        if (is_array($this->categoriesArray)) {
            CategoryPost::where('post_id', $this->post->id)->delete();
            foreach ($this->categoriesArray as $key => $value) {
                if ($value !== false) {
                    CategoryPost::create(['category_id' => $key, 'post_id' => $this->post->id]);
                }
            }
        }

        add_user_log([
            'title' => 'Updated blog post: '.$this->title,
            'link' => route('admin.blog.posts.edit', $this->post),
            'reference_id' => auth()->id(),
            'section' => 'Blog',
            'type' => 'Update',
        ]);

        flash('Blog post updated')->success();

        return redirect(route('admin.blog.posts.edit', $this->post));
    }
}
