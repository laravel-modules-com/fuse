<div class="grid gap-5 max-w-lg mx-auto lg:grid-cols-3 lg:max-w-none">
    @foreach($posts as $post)
        <div class="flex flex-col rounded-lg shadow-lg overflow-hidden mb-10">

            @if(!empty($post->image))
                <div class="flex-shrink-0">
                    <a href="{{ route('blog.show', $post) }}" class="block">
                        <img class="w-full object-cover rounded-t-lg" src="{{ url($post->image) }}" alt="{{ $post->image_alt }}">
                    </a>
                </div>
            @endif

            <div class="flex-1 bg-indigo-800 p-6 flex flex-col justify-between">
                <div class="flex-1">
                    <p class="text-sm leading-5 font-medium text-primary mb-0">
                        @foreach($post->categories as $category)
                            <a href="{{ route('blog.categories.show', $category) }}">
                                {{ $category->title }}
                                @if (!$loop->last)
                                    |
                                @endif
                            </a>
                        @endforeach
                    </p>
                    <a href="{{ route('blog.show', $post) }}" class="block">
                        <h2 class="mt-2 text-xl leading-7 font-semibold">
                            {{ $post->title }}
                        </h2>

                        <div class="mt-3 text-base leading-6 text-white">
                            {!! Str::limit(strip_tags($post->description), 100) !!}
                        </div>
                    </a>
                </div>
                <div class="mt-6 flex items-center">
                    <div class="flex-shrink-0">
                        @if (!empty($post->author->image))
                            <a href="{{ route('blog.authors.show', $post->author) }}">
                                <img class="w-10 h-10 pr-1 rounded-full" src="{{ url($post->author->image) }}" alt="{{ url($post->author->name) }}">
                            </a>
                        @endif
                    </div>
                    <div class="ml-3">
                        <p class="text-sm mb-0 font-medium text-primary">
                            <a href="{{ route('blog.authors.show', $post->author) }}" class="hover:underline">{{ $post->author?->name }}</a>
                        </p>
                        <div class="flex text-sm text-gray-800 dark:text-gray-200">
                            <time datetime="{{ $post->display_at }}">{{ date('jS M Y g:i A', strtotime($post->display_at)) }}</time>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
