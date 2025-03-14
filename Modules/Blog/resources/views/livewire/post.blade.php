@section('title', $post->title)

@section('meta')
<meta itemprop="name" content="{{ $post->title }}">
<meta itemprop="description" content="{!! strip_tags(Str::limit($post->description, 100)) !!}">
@if (!empty($post->image))
<meta itemprop="image" content="{{ url($post->image) }}">
@endif
<meta name='description' content='{!! strip_tags(Str::limit($post->description, 100)) !!}'>
<meta property="article:published_time" content="{{ $post->created_at }}" />
<meta property="article:modified_time" content="{{ $post->updated_at }}" />
<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url($post->slug) }}">
<meta property="og:title" content="{{ $post->title }}">
<meta property="og:description" content="{!! strip_tags(Str::limit($post->description, 100)) !!}">
@if (!empty($post->image))
    <meta property="og:image" content="{{ url(trim($post->image)) }}">
@endif
<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@dcblogdev">
<meta name="twitter:creator" content="@dcblogdev">
<meta name="twitter:url" content="{{ url($post->slug) }}">
<meta name="twitter:title" content="{{ $post->title }}">
<meta name="twitter:description" content="{!! strip_tags(Str::limit($post->description, 100)) !!}">
@if (!empty($post->image))
    <meta name="twitter:image" content="{{ url(trim($post->image)) }}">
@endif
<link rel="canonical" href='{{ url($post->slug) }}'>
<link rel="webmention" href='https://webmention.io/dcblog.dev/webmention'>
<link rel="pingback" href="https://webmention.io/dcblog.dev/xmlrpc" />
<link rel="pingback" href="https://webmention.io/webmention?forward={{ url($post->slug) }}" />
@stop

<div class="container max-w-screen-lg pb-16 mx-auto">

    <div class="overflow-hidden mb-10 px-8 py-4 rounded-lg ">

        <h1 class="text-indigo-500 text-4xl text-center">{{ $post->title }}</h1>

        <div class="flex items-center mt-6 mb-6">

            <div class="flex-shrink-0">
                @if (!empty($post->author?->image))
                    <a href="{{ url('author/'.$post->author?->slug) }}">
                        <img class="w-10 h-10 rounded-full" src="{{ url($post->author?->image) }}" alt="">
                    </a>
                @endif
            </div>

            <div class="ml-3">
                <p class="text-sm font-medium text-primary mb-0">
                    <a href="{{ url('author/'.$post->author?->slug) }}" class="hover:underline">{{ $post->author?->name }}</a>
                </p>
                <div class="flex text-sm leading-5 text-gray-500 dark:text-gray-200">
                    <time datetime="{{ $post->display_at }}">{{ date('jS M Y h:i A', strtotime($post->display_at)) }}</time>
                </div>
            </div>

        </div>

        <article class="mx-auto">

            @auth
                <a href="{{ route('admin.blog.posts.edit', $post) }}">Edit</a>
            @endauth

            <p>
                @foreach($post->categories as $category)
                    <a href="{{ route('blog.categories.show', $category) }}" class="bg-primary text-gray-200 text-sm p-2 rounded">{{ $category->title }}</a>
                @endforeach
            </p>

            @if($toc)
                <div id="toc" class="my-5 p-5 border border-gray-500 rounded-lg">
                    <h2>Table of Contents</h2>
                    {!! $toc !!}
                </div>
            @endif

            <div id="mainContent">
                {!! $content !!}
            </div>

        </article>

        <div class='flex flex-wrap mt-10 -mx-2'>

            <div class="w-full p-2 md:w-1/2">

                @if (isset($previous))
                <div class="bg-primary p-2 rounded h-15">
                    <a href="{{ route('blog.show', $previous) }}" class="text-white">
                        <div>
                            <div class="font-bold">
                                Previous Post
                            </div>
                            <div class="text-sm">
                                {{ $previous->title }}
                            </div>
                        </div>
                    </a>
                </div>
                @endif

            </div>

            <div class="w-full p-2 md:w-1/2">
                @if (isset($next))
                <div class="bg-primary p-2 rounded h-15">
                    <a href="{{ route('blog.show', $next) }}" class="text-white">
                        <div class="text-right">
                            <div class="font-bold">
                                Next Post
                            </div>
                            <div class="text-sm">
                                {{ $next->title }}
                            </div>
                        </div>
                    </a>
                </div>
                @endif
            </div>

        </div>

{{--        <div class="mt-5">--}}
{{--            <script src="https://utteranc.es/client.js"--}}
{{--                    repo="dcblogdev/dcblogcomments"--}}
{{--                    issue-term="pathname"--}}
{{--                    theme="github-light"--}}
{{--                    crossorigin="anonymous"--}}
{{--                    async>--}}
{{--            </script>--}}
{{--        </div>--}}

    </div>

</div>
