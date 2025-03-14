@section('title', 'A Laravel and PHP Blog')
@section('meta')
    <meta name='description'
          content='A Laravel and PHP Blog talking about Laravel, Livewire, AlpineJs and related stacks'>

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->full() }}">
    <meta property="og:title" content="A Laravel and PHP Blog - {{ config('app.name') }}">
    <meta property="og:description"
          content="A Laravel and PHP Blog talking about Laravel, Livewire, AlpineJs and related stacks">
    <meta property="og:image" content="{{ url('/') }}/social.png">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:creator" content="@dcblogdev"/>
    <meta name="twitter:url" content="{{ url()->full() }}">
    <meta name="twitter:title" content="A Laravel and PHP Blog - {{ config('app.name') }}">
    <meta name="twitter:description"
          content="A Laravel and PHP Blog talking about Laravel, Livewire, AlpineJs and related stacks">
    <meta name="twitter:image" content="{{ url('/') }}/social.png">
@stop

<div>


    @if (request()->path() == config('blog.prefix'))
        <div class="container px-8 pb-12 mx-auto mb-12 max-w-4xl">

            <div class="py-5 mx-auto text-center">

                <img class="mx-auto mb-8 w-40 h-40 rounded-full border-4 border-primary-200"
                     src="{{ url('images/david-carr.png') }}" alt="David Carr - Laravel Developer">

                <div class="block px-4 w-full">
                    <h1 class="mb-2 text-4xl font-semibold dark:text-primary-200 md:text-5xl lg:text-6xl text-primary-900">
                        Hi, I’m David Carr</h1>

                    <p class="pt-3 mb-8 text-xl font-light text-gray-600 font-body dark:text-gray-100">
                        A <strong>PHP Developer</strong> <br>
                        I love to use the <strong>TALL</strong> stack (<a href="https://tailwindcss.com"
                                                                          target="_blank">Tailwind CSS</a>, <a
                                href="https://alpinejs.dev/" target="_blank">Alpine.js</a>, <a
                                href="https://laravel.com" target="_blank">Laravel</a>, and <a
                                href="http://laravellivewire.com/" target="_blank">Laravel Livewire</a>)
                    </p>

                    <p class="pt-3 mb-8 text-xl font-light text-gray-600 font-body dark:text-gray-100">
                        I enjoy writing tutorials and working on <a href="{{ url('docs') }}">Open Source
                            packages</a>.<br>
                        I also write <a href="{{ url('books') }}">books</a>.

                            <?php /*I'm writing a new book <a href="https://laraveltestingcookbook.com/">Laravel Testing Cookbook</a>, This book focuses on testing covering both PestPHP and PHPUnit.*/ ?>
                    </p>

                    <p class="pt-3 mb-8 text-xl font-light text-gray-600 font-body dark:text-gray-100">
                        I am dedicated to enhancing PHP development by maintaining existing projects and creating new
                        ones. If your business benefits from my work, please consider <a
                                href="https://github.com/sponsors/dcblogdev">sponsoring me</a> to support ongoing
                        development.
                    </p>

                    <div class="flex justify-center items-center mt-10">
                        <a href="https://twitter.com/dcblogdev" class="ml-6 text-white hover:text-gray-300">
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                            </svg>
                        </a>

                        <a href="https://github.com/dcblogdev" class="ml-6 text-white hover:text-gray-300">
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                      d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </a>

                        <a href="https://www.youtube.com/c/dcblogdev" class="ml-6 text-white hover:text-gray-300">
                            <svg class="w-10 h-10" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 16 16">
                                <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z"/>
                            </svg>
                        </a>

                        <a href="https://www.linkedin.com/in/dcblogdev/" class="ml-6 text-white hover:text-gray-300">
                            <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                 fill="currentColor" viewBox="0 0 16 16">
                                <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z"/>
                            </svg>
                        </a>

                        <a href="{{ url('feed') }}" class="ml-6 text-white hover:text-gray-300">
                            <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 11a9 9 0 0 1 9 9"></path>
                                <path d="M4 4a16 16 0 0 1 16 16"></path>
                                <circle cx="5" cy="19" r="1"></circle>
                            </svg>
                        </a>
                    </div>

                </div>

            </div>

        </div>


        {{--        @include('layouts.front.sponsors')--}}


        <section class="container px-8 pb-12 mx-auto mb-12 max-w-4xl text-center">
            <div class="flex flex-col justify-between sm:items-center lg:items-start lg:flex-row">
                <div class="relative mb-4 lg:mb-0">
                    <h2 class="text-3xl font-extrabold text-primary-900 dark:text-primary-300 xl:text-4xl">Subscribe to
                        my newsletter</h2>
                    <p class="mt-2 text-gray-200 text-md">Subscribe and get my books and product announcements.</p>
                </div>

                <div>
                    <form action="https://dev.us7.list-manage.com/subscribe/post?u=57ecba7264469df2ce902d4c6&amp;id=64154093c4"
                          method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form"
                          target="_blank" novalidate class="mt-4 validate sm:flex sm:max-w-md">
                        <input aria-label="Email address" name="EMAIL" id="mce-EMAIL" type="email" required
                               class="px-5 py-3 w-full text-base leading-6 placeholder-gray-500 text-gray-900 bg-white rounded-md border border-gray-300 transition duration-150 ease-in-out appearance-none focus:outline-none focus:placeholder-gray-400 focus:border-blue-300 focus:shadow-outline"
                               placeholder="Enter your email">
                        <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3 sm:flex-shrink-0">
                            <button class="flex justify-center items-center px-5 py-3 w-full text-base font-medium leading-6 text-white bg-indigo-600 rounded-md border border-transparent transition duration-150 ease-in-out hover:bg-indigo-500 focus:outline-none focus:shadow-outline">
                                Subscribe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <h2 class="mb-5">Latest Posts</h2>

    @else
        <div class="mx-auto">
            <h1 class="mb-5">
                {{ $pageTitle ?? '' }}
            </h1>
        </div>

    @endif

    @include('blog::livewire.postItems', ['posts' => $posts])

    <p class="text-center"><a href="{{ route('blog.posts.index') }}" class="btn btn-primary">See all posts</a></p>

</div>
