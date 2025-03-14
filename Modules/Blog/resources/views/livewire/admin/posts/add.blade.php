<div>

    @include('errors.messages')

    <p>
        <x-a href="{{ route('admin.blog.index') }}">{{ __('Posts') }}</x-a>
        <span class="dark:text-gray-200">- {{ __('Create Post') }}</span>
    </p>

    <div class="card">

        <div class="flex justify-between">
            <h2 class="mb-5">{{ __('Create Post') }}</h2>
            <div>
                <span class="error">*</span>
                <span class="dark:text-gray-200"> = {{ __('required') }}</span>
            </div>
        </div>

        <x-form wire:submit="store">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-form.input wire:model.blur="title" label="Title" name="title" required />
                <x-form.input wire:model="slug" label="Slug" name="slug" required />
                <x-form.datetime wire:model="displayAt" label="Display At (Post won't be displayed until this date/time has passed)" name="displayAt" required />
                <div>
                    <x-form.input type="file" wire:model="image" label="Image" name="image" />
                    @if ($image)
                        <p>Image Preview:</p>
                        <p><img style="height: 200px;" src="{{ $image->temporaryUrl() }}"></p>
                    @endif
                </div>
                <x-form.select :data="$authors" wire:model.blur="authorId" name="authorId" label="Author" placeholder="Select an author" required />
            </div>

            <x-form.textarea wire:model="description" name="description" />
            <x-form.textarea wire:model="content" name="content" />

            <p><label>Categories</label></p>
            @foreach($categories as $category)
                <x-form.checkbox-row :data="$category" wireName="categoriesArray" wire:key="{{ $category->id }}" />
            @endforeach

            <x-form.submit>Submit</x-form.submit>
        </x-form>

    </div>

</div>
