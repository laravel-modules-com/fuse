<div>
    <h1 class="py-5">{{ __('Categories') }}</h1>

    <ul class="grid grid-cols-1 gap-5 sm:gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($categories as $category)
            <li class="flex items-center col-span-1 overflow-hidden bg-indigo-800 border border-gray-200 rounded-md shadow-sm">
                <div class="flex-1 px-4 py-2 truncate">
                    <a href="{{ route('blog.categories.show', $category) }}" class="text-sm font-medium leading-5 transition duration-150 ease-in-out">{{ $category->title }}</a>
                    <p class="text-sm leading-5 text-white">{{ $category->posts->count() }} {{ __('Posts') }}</p>
                </div>
            </li>
        @endforeach
    </ul>
</div>
