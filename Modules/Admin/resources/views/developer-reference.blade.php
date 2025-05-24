<x-layouts.app>
@section('title', 'Developer Reference')

<div class="md:flex">

    <!-- Sidebar with links (sticky on scroll) -->
    <div class="md:w-1/4 p-5 md:sticky top-0 h-full">
        <ul class="md:fixed overflow-x-auto space-y-2">
            <li><a class="text-primary" href="#basestyles">Base Styles</a></li>
            <li><a class="text-primary" href="#primaryColors">Primary Colors</a></li>
            <li><a class="text-primary" href="#error">Error</a></li>
            <li><a class="text-primary" href="#forms">Forms</a></li>
            <li><a class="text-primary" href="#alerts">Alerts</a></li>
            <li><a class="text-primary" href="#links">Links</a></li>
            <li><a class="text-primary" href="#badges">Badges</a></li>
            <li><a class="text-primary" href="#buttons">Buttons</a></li>
            <li><a class="text-primary" href="#dropdown">Dropdown</a></li>
            <li><a class="text-primary" href="#modals">Modals</a></li>
            <li><a class="text-primary" href="#confirmmodals">Confirm Modals</a></li>
            <li><a class="text-primary" href="#tabs">Tabs</a></li>
        </ul>
    </div>

    <!-- Main content -->
    <div class="md:w-3/4 p-5">
        <p>All styles are powered by TailwindCSS, having said that you may want to reuse style in easy ways. There are generally 2 options. Create a blade component or apply a CSS style.</p>

        <p>{{ config('app.name') }} provides a series or reusable CSS classes made up from TailwindCSS classes.</p>

        @include('admin::docs.base-styles')
        @include('admin::docs.primary-colour')
        @include('admin::docs.error')
        @include('admin::docs.forms')
        @include('admin::docs.alerts')
        @include('admin::docs.links')
        @include('admin::docs.badges')
        @include('admin::docs.buttons')
        @include('admin::docs.dropdown')
        @include('admin::docs.modals')
        @include('admin::docs.tabs')
    </div>

</div>

</x-layouts.app>
