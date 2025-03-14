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

#[Title('Edit Author')]
class EditAuthor extends Component
{
    use WithFileUploads;

    public Author $author;

    public $name;

    public $slug;

    public $image;

    public $exitingImage;

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

    public function mount()
    {
        $this->name = $this->author->name;
        $this->slug = $this->author->slug;
        $this->bio = $this->author->bio;
        $this->facebook = $this->author->facebook;
        $this->instagram = $this->author->instagram;
        $this->linkedin = $this->author->linkedin;
        $this->twitter = $this->author->twitter;
        $this->github = $this->author->github;
        $this->youtube = $this->author->youtube;
        $this->exitingImage = $this->author->image;
    }

    public function updated($propertyName): void
    {
        if ($propertyName == 'name') {
            $this->slug = Str::slug($this->name);
        }

        $this->validateOnly($propertyName);
    }

    public function render(): View
    {
        abort_if_cannot('edit_blog_authors');

        return view('blog::livewire.admin.authors.edit');
    }

    public function update()
    {
        $this->validate();

        $this->author->name = $this->name;
        $this->author->slug = $this->slug;
        $this->author->bio = $this->bio;
        $this->author->facebook = $this->facebook;
        $this->author->instagram = $this->instagram;
        $this->author->linkedin = $this->linkedin;
        $this->author->twitter = $this->twitter;
        $this->author->github = $this->github;
        $this->author->youtube = $this->youtube;
        $this->author->save();

        if (! empty($this->image)) {
            Storage::disk('images')->delete($this->image);

            $name = $this->slug.'.png';
            $img = Image::make($this->image)->encode('png')->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->stream();

            Storage::disk('images')->put('authors/'.$name, $img);

            $this->author->update(['image' => 'images/authors/'.$name]);
        }

        add_user_log([
            'reference_id' => $this->author->id,
            'title' => 'Updated author: '.$this->name,
            'link' => route('admin.blog.index'),
            'section' => 'Blog Author',
            'type' => 'Update',
        ]);

        flash('Author updated')->success();

        return to_route('admin.blog.authors.index');
    }
}
