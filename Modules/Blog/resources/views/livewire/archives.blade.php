@section('title', 'Archives')

<div id="mainContent" class="mx-auto max-w-2xl">

    <a name="top"></a>
    <h1>Archives</h1>

    <article id="mainContent" class="mx-auto">
        <ul>
            @foreach($archives as $row)
                <li><a href='#{{ $row->year }}'>{{ $row->year }}</a></li>
            @endforeach
        </ul>


        @foreach($archives as $row)
            <a name="{{ $row->year }}"></a>
            <h2 class="py-5">
                {{ $row->year }}
                <div class="text-sm">
                    <a href='#top'>TOP</a>
                </div>
            </h2>

            @php
                $posts = Modules\Blog\Models\Post::whereYear('display_at', $row->year)->date()->order()->get();
            @endphp

            @foreach($posts as $post)
                <p><a href='{{ route('blog.show', $post) }}'>{{ $post->title }}</a></p>
            @endforeach

        @endforeach
    </article>

</div>

