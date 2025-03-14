<div>
    <div class="flex justify-between">
        <p>
            <x-a href="{{ route('admin.blog.index') }}">{{ __('Posts') }}</x-a>
            <span class="dark:text-gray-200">- {{ __('Edit Post') }}</span>
        </p>
        <p class="mt-2">
            <x-a href="{{ route('blog.show', $post->slug) }}">{{ __('View post') }}</x-a>
        </p>
   </div>

    <div class="card">

        <div class="flex justify-between">
            <h2 class="mb-5">{{ __('Edit Post') }}</h2>
            <div>
                <span class="error">*</span>
                <span class="dark:text-gray-200"> = {{ __('required') }}</span>
            </div>
        </div>

        <x-form wire:submit.prevent="update">

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-form.input wire:model="title" label="Title" name="title" required />
                <x-form.input wire:model="slug" label="Slug" name="slug" required />
                <x-form.datetime wire:model="displayAt" label="Display At (Post won't be displayed until this date/time has passed)" required name="displayAt" />
                <div>
                    <x-form.input type="file" wire:model="image" label="Image" name="image" />
                    @if ($image)
                        <p>Image Preview:</p>
                        <p><img style="height: 200px;" src="{{ $image->temporaryUrl() }}"></p>
                    @elseif($exitingImage !='')
                        <p><img src="{{ url($exitingImage) }}"></p>
                    @endif
                </div>
                <x-form.select :data="$authors" wire:model="authorId" label="Author" placeholder="Select an author" required />
            </div>

            <x-form.ckeditor wire:model="description" name="description" required />
            <x-form.ckeditor wire:model="content" name="content" required />

            <p><label>Categories</label></p>
            @foreach($categories as $category)
                <x-form.checkbox-row :data="$category" wireName="categoriesArray" wire:key="{{ $category->id }}" />
            @endforeach

            <x-form.submit>Submit</x-form.submit>
        </x-form>

    </div>

</div>
