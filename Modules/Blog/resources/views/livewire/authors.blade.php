<div>
    <h1 class="py-5">Authors</h1>

    <ul class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        @foreach($authors as $author)
            <li class="col-span-1 flex flex-col text-center bg-indigo-800 border border-gray-200 rounded-lg shadow">
                <div class="flex-1 flex flex-col p-8">
                    <a href="{{ route('blog.authors.show', $author->author) }}">
                        @if ($author->author->image !='')
                            <a href="{{ route('blog.authors.show', $author->author) }}">
                                <img class="w-32 h-32 flex-shrink-0 mx-auto rounded-full" src="{{ url($author->author->image) }}" alt="{{ $author->author->name }}">
                            </a>
                        @endif

                        <h3 class="mt-6 text-gray-900 text-sm leading-5 font-medium">
                            {{ $author->author->name }}
                        </h3>
                    </a>
                </div>
            </li>
        @endforeach
    </ul>
</div>
