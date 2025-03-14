<div>
    <div class="md:flex justify-between">

        <h1>{{ __('Posts') }}</h1>

        <div class="mt-5 md:mt-0">
            @if (can('view_blog_posts'))
                <a class="btn btn-primary" wire:navigate href="{{ route('admin.blog.index') }}">{{ __('Manage Posts') }}</a>
            @endif

            @if (can('view_blog_categories'))
                <a class="btn btn-primary" wire:navigate href="{{ route('admin.blog.categories.index') }}">{{ __('Manage Categories') }}</a>
            @endif

            @if (can('view_blog_authors'))
                <a class="btn btn-primary" wire:navigate href="{{ route('admin.blog.authors.index') }}">{{ __('Manage Authors') }}</a>
            @endif
        </div>

    </div>

    @include('errors.flash')

    <div class="card">

        <div class="flex w-full">

            <div class="w-4/5">
                <x-form.input type="search" name="title" wire:model.blur="title" label="none" placeholder="Search Posts" />
            </div>

            @if (can('add_blog_posts'))
                <div class="md:w-1/5 pl-10">
                    <a class="btn btn-primary" wire:navigate href="{{ route('admin.blog.posts.create') }}">{{ __('Create Post') }}</a>
                </div>
            @endif
        </div>

        <div class="mb-5" x-data="{ isOpen: @if($openFilter || request('openFilter')) true @else false @endif }">

            <button type="button" @click="isOpen = !isOpen" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-t text-grey-700 bg-gray-200 hover:bg-grey-300 dark:bg-gray-700 dark:text-gray-200 transition ease-in-out duration-150">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Advanced Search
            </button>

            <button type="button" wire:click="resetFilters" @click="isOpen = false" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs leading-4 font-medium rounded text-grey-700 bg-gray-200 hover:bg-grey-300 dark:bg-gray-700 dark:text-gray-200 transition ease-in-out duration-150">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Reset form
            </button>

            <div
                    x-show="isOpen"
                    x-transition:enter="transition ease-out duration-100 transform"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75 transform"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="p-5 bg-gray-200 dark:bg-gray-700 rounded-b-md"
                    wire:ignore.self>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                    <x-form.daterange id="displayAt" name="displayAt" label="Display Date Range" wire:model.lazy="displayAt" />
                    <x-form.daterange id="updatedAt" name="updatedAt" label="Updated Date Range" wire:model.lazy="updatedAt" />
                    <x-form.daterange id="createdAt" name="createdAt" label="Created Date Range" wire:model.lazy="createdAt" />
                </div>
            </div>

        </div>

        <div class="overflow-x-scroll">
            <table>
                <thead>
                    <tr>
                        <th><a href="#" wire:click.prevent="sortBy('title')">Title</a></th>
                        <th><a href="#" wire:click.prevent="sortBy('user_id')">Author</a></th>
                        <th><a href="#" wire:click.prevent="sortBy('display_at')">Display At</a></th>
                        <th><a href="#" wire:click.prevent="sortBy('updated_at')">Updated At</a></th>
                        <th><a href="#" wire:click.prevent="sortBy('created_at')">Created At</a></th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($this->posts() as $post)
                    <tr>
                        <td>{{ Str::limit($post->title, 50) }}</td>
                        <td>{{ $post->author->name ?? '' }}</td>
                        <td>
                            {{ $post->display_at->format('jS M Y') }}<br>
                            {{ $post->display_at->format('H:i A') }}
                        </td>
                        <td>
                            {{ $post->updated_at->format('jS M Y') }}<br>
                            {{ $post->updated_at->format('H:i A') }}
                        </td>
                        <td>
                            {{ $post->created_at->format('jS M Y') }}<br>
                            {{ $post->created_at->format('H:i A') }}
                        </td>
                        <td>
                            <div class="flex space-x-2">
                                @if(can('edit_blog_posts'))
                                    <a href="{{ route('admin.blog.posts.edit', $post) }}">Edit</a>
                                @endif

                                @if(can('delete_blog_posts'))
                                    <x-modal>
                                        <x-slot name="trigger">
                                            <a href="#" @click="on = true">Delete</a>
                                        </x-slot>

                                        <x-slot name="title">Confirm Delete</x-slot>

                                        <x-slot name="content">
                                            <div class="text-center">
                                                Are you sure you want to delete: <b>{{ $post->title }}</b>
                                            </div>
                                        </x-slot>

                                        <x-slot name="footer">
                                            <button @click="on = false">Cancel</button>
                                            <button class="btn btn-red" wire:click="deletePost('{{ $post->id }}')">Delete Post</button>
                                        </x-slot>
                                    </x-modal>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{ $this->posts()->links() }}

    </div>
</div>
