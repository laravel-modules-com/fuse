@section('title', 'Posts')
<div class="text-white">
    @include('blog::livewire/postItems', ['posts' => $posts])

    {!! $posts->links() !!}
</div>