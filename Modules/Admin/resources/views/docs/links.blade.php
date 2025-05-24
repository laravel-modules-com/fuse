<div class="card">
    <h2><a name="links">{{ __('Links') }}</a></h2>

    <x-tabs name="preview">
        <x-tabs.header>
            <x-tabs.link name="preview">{{ __('Preview') }}</x-tabs.link>
            <x-tabs.link name="code">{{ __('Code') }}</x-tabs.link>
        </x-tabs.header>

        <x-tabs.div name="preview">

            <p>{{ __('The') }} <code>x-a</code> {{ __('component is a styled anchor tag that supports the same color variants and sizes as the button component.') }}</p>

            <p>{{ __('Passing a variant will change the background color of the link. The available variants are: gray, red, yellow, green, blue, indigo, purple, pink, and link.') }}</p>
            <p>{{ __('Primary is the default variant.') }}</p>

            <x-a href="#">{{ __('Link') }}</x-a>
            <x-a href="#" size="sm" variant="primary">{{ __('Primary') }}</x-a>
            <x-a href="#" size="sm" variant="gray">{{ __('Gray') }}</x-a>
            <x-a href="#" size="sm" variant="red">{{ __('Red') }}</x-a>
            <x-a href="#" size="sm" variant="yellow">{{ __('Yellow') }}</x-a>
            <x-a href="#" size="sm" variant="green">{{ __('Green') }}</x-a>
            <x-a href="#" size="sm" variant="blue">{{ __('Blue') }}</x-a>
            <x-a href="#" size="sm" variant="indigo">{{ __('Indigo') }}</x-a>
            <x-a href="#" size="sm" variant="purple">{{ __('Purple') }}</x-a>
            <x-a href="#" size="sm" variant="pink">{{ __('Pink') }}</x-a>

            <div class="mt-4">
                <p class="mt-5">{{ __('Sizes') }}:</p>
                <x-a href="#" variant="primary">{{ __('Default') }}</x-a>
                <x-a href="#" variant="primary" size="xs">{{ __('Extra Small') }}</x-a>
                <x-a href="#" variant="primary" size="sm">{{ __('Small') }}</x-a>
                <x-a href="#" variant="primary" size="lg">{{ __('Large') }}</x-a>
                <x-a href="#" variant="primary" size="xl">{{ __('Extra Large') }}</x-a>
            </div>
        </x-tabs.div>

        <x-tabs.div name="code">
            <pre><code class="language-php">@php echo htmlentities('<x-a href="#">Primary</x-a>
<x-a href="#" variant="gray">Gray</x-a>
<x-a href="#" variant="red">Red</x-a>
<x-a href="#" variant="yellow">Yellow</x-a>
<x-a href="#" variant="green">Green</x-a>
<x-a href="#" variant="blue">Blue</x-a>
<x-a href="#" variant="indigo">Indigo</x-a>
<x-a href="#" variant="purple">Purple</x-a>
<x-a href="#" variant="pink">Pink</x-a>
<x-a href="#" variant="link">Link Style</x-a>') @endphp</code></pre>

            <p class="mt-4">You can also specify different sizes:</p>

            <pre><code class="language-php">@php echo htmlentities('<x-a href="#" size="xs">Extra Small</x-a>
<x-a href="#" size="sm">Small</x-a>
<x-a href="#">Default</x-a>
<x-a href="#" size="lg">Large</x-a>
<x-a href="#" size="xl">Extra Large</x-a>') @endphp</code></pre>

            <p class="mt-4">By default, links include <code>wire:navigate</code> for SPA navigation. You can disable this with the navigate prop:</p>

            <pre><code class="language-php">@php echo htmlentities('<x-a href="#" :navigate="false">Link without wire:navigate</x-a>') @endphp</code></pre>
        </x-tabs.div>
    </x-tabs>
</div>
