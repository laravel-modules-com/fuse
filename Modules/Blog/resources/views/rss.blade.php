<?=
/* Using an echo tag here so the `<? ... ?>` won't get parsed as short tags */
'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <atom:link href="{{ url('rss') }}" rel="self" type="application/rss+xml" />
        <title>{{ config('app.name') }} RSS Feed</title>
        <link>{{ url('/') }}</link>
        <description>{{ config('app.name') }} RSS Feed</description>
        <language>EN</language>

        @foreach($posts as $post)
            @php
            $post->title = stripslashes($post->title);
            $post->slug = stripslashes($post->slug);

            $post->description = str_replace("&nbsp;", " ", $post->description);

            if ($post->image !='') {
                $img = "<img src='".url($post->image)."' alt='".$post->title."' width='600'>";
            } else {
                $img = null;
            }

            @endphp

            <item>
                <title>{{ $post->title }}</title>
                <link>{{ route('blog.show', $post) }}</link>
                <description><![CDATA[{!! $img !!} {!! $post->description !!}]]></description>
                <guid>{{ route('blog.show', $post) }}</guid>
                <pubDate>{{ date('D, d M Y H:i:s', strtotime($post->display_at)) }} GMT</pubDate>
                <atom:link href="{{ route('blog.show', $post) }}" rel="self" type="application/rss+xml"/>
            </item>
        @endforeach
    </channel>
</rss>
