<div class="max-w-8xl px-3 mt-1 mx-auto">
    <form action="#" method="get">
        <div class="text-gray-900 rounded-md max-w-md m-auto">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input wire:model.live.debounce.500ms="search" type="search" class="w-full py-1 pl-10 rounded-md bg-white text-gray-900 focus:outline-none border" placeholder="Search blog posts">
            </div>
        </div>

        @if (strlen($search) > 2)
            <ul class="absolute z-50 mt-2 text-sm text-gray-700 bg-white border border-gray-300 divide-y divide-gray-200 rounded-md dark:bg-gray-500 dark:text-gray-200 dark:border-gray-400 w-96">
                @forelse ($posts as $post)
                        <li class="p-1">
                            <a href="{{ route('blog.show', $post) }}" class="flex items-center px-4 py-4 transition duration-150 ease-in-out text-white hover:text-black hover:bg-gray-200">{{ $post->title }}</a>
                        </li>
                @empty
                    <li class="px-4 py-4">No results found for "{{ $search }}"</li>
                @endforelse
            </ul>
        @endif
    </form>
</div>
