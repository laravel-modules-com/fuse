<?php

declare(strict_types=1);

namespace Modules\Blog\Livewire\Admin\Authors;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Blog\Models\Author;

#[Title('Create Author')]
class AddAuthor extends Component
{
    use WithFileUploads;

    public $name;

    public $slug;

    public $image;

    public $bio;

    public $facebook;

    public $instagram;

    public $linkedin;

    public $twitter;

    public $github;

    public $youtube;

    protected array $rules = [
        'name' => 'required|string',
        'image' => 'nullable|mimes:jpg,png,gif,webp',
    ];

    public function updated($propertyName): void
    {
        if ($propertyName == 'name') {
            $this->slug = Str::slug($this->name);
        }

        $this->validateOnly($propertyName);
    }

    public function render(): View
    {
        abort_if_cannot('add_blog_authors');

        return view('blog::livewire.admin.authors.add');
    }

    public function store()
    {
        $this->validate();

        $author = Author::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'bio' => $this->bio,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'twitter' => $this->twitter,
            'linkedin' => $this->linkedin,
            'github' => $this->github,
            'youtube' => $this->youtube,
        ]);

        if (! empty($this->image)) {
            Storage::disk('images')->delete($this->image);

            $name = $this->slug.'.png';
            $img = Image::make($this->image)->encode('png')->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->stream();

            Storage::disk('images')->put('authors/'.$name, $img);

            $author->update(['image' => 'images/authors/'.$name]);
        }

        add_user_log([
            'reference_id' => $author->id,
            'title' => 'Added author: '.$this->name,
            'link' => route('admin.blog.index'),
            'section' => 'Blog Author',
            'type' => 'Create',
        ]);

        flash('Author created')->success();

        return to_route('admin.blog.authors.index');
    }
}
