@section('title', 'Categories')
<div>
    <div class="md:flex justify-between">

        <h1>{{ __('Categories') }}</h1>

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
                <x-form.input type="search" name="title" wire:model.blur="title" label="none" placeholder="Search Categories" />
            </div>

            @if (can('add_blog_categories'))
                <div class="md:w-1/5 pl-10">
                    <livewire:blog::admin.categories.add-category/>
                </div>
            @endif
        </div>

        <div class="mb-5" x-data="{ isOpen: @if($openFilter || request('openFilter')) true @else false @endif }">

            <button type="button" @click="isOpen = !isOpen" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-t text-grey-700 bg-gray-200 hover:bg-grey-300 dark:bg-gray-700 dark:text-gray-200 transition ease-in-out duration-150">
                <svg class="h-5 w-5 text-gray-500 dark:text-gray-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Advanced Search
            </button>

            <button type="button" wire:click="resetFilters" @click="isOpen = false" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs leading-4 font-medium rounded text-grey-700 bg-gray-200 hover:bg-grey-300 dark:bg-gray-700 dark:text-gray-200 transition ease-in-out duration-150">
                <svg class="h-5 w-5 text-gray-500 dark:text-gray-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                    class="bg-gray-200 dark:bg-gray-700 rounded-b-md p-5"
                    wire:ignore.self>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
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
                <th><a href="#" wire:click.prevent="sortBy('updated_at')">Updated At</a></th>
                <th><a href="#" wire:click.prevent="sortBy('created_at')">Created At</a></th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($this->categories() as $category)
                @include('blog::livewire.admin.categories.table-row', ['category' => $category])
            @endforeach
            </tbody>
            </table>
        </div>

        {{ $this->categories()->links() }}

    </div>
</div>
