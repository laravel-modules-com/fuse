<x-layouts.app>
@section('title', __('Developer Reference'))

<div class="md:flex">

    <div class="md:w-1/4 p-5 md:sticky top-0 h-full">
        <ul class="md:fixed overflow-x-auto space-y-2">
            <li><a class="text-primary" href="#basestyles">{{ __('Base Styles') }}</a></li>
            <li><a class="text-primary" href="#primaryColors">{{ __('Primary Colors') }}</a></li>
            <li><a class="text-primary" href="#error">{{ __('Error') }}</a></li>
            <li><a class="text-primary" href="#forms">{{ __('Forms') }}</a></li>
            <li><a class="text-primary" href="#alerts">{{ __('Alerts') }}</a></li>
            <li><a class="text-primary" href="#links">{{ __('Links') }}</a></li>
            <li><a class="text-primary" href="#badges">{{ __('Badges') }}</a></li>
            <li><a class="text-primary" href="#buttons">{{ __('Buttons') }}</a></li>
            <li><a class="text-primary" href="#dropdown">{{ __('Dropdown') }}</a></li>
            <li><a class="text-primary" href="#modals">{{ __('Modals') }}</a></li>
            <li><a class="text-primary" href="#confirmmodals">{{ __('Confirm Modals') }}</a></li>
            <li><a class="text-primary" href="#tabs">{{ __('Tabs') }}</a></li>
        </ul>
    </div>

    <div class="md:w-3/4 p-5">
        <p>{{ __('All styles are powered by TailwindCSS, having said that you may want to reuse style in easy ways. There are generally 2 options. Create a blade component or apply a CSS style.') }}</p>

        <p>{{ config('app.name') }} {{ __('provides a series or reusable CSS classes made up from TailwindCSS classes.') }}</p>

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
