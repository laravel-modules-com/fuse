<div class="card">
    <h2><a name="buttons">{{ __('Buttons') }}</a></h2>

    <x-tabs name="preview">
        <x-tabs.header>
            <x-tabs.link name="preview">{{ __('Preview') }}</x-tabs.link>
            <x-tabs.link name="code">{{ __('Code') }}</x-tabs.link>
        </x-tabs.header>

        <x-tabs.div name="preview">

            <p>{{ __('Passing a variant will change the background color of the alert. The available variants are: gray, red, yellow, green, blue, indigo, purple, pink, link.') }}</p>
            <p>{{ __('Primary is the default variant.') }}</p>

            <p>{{ __('Colours') }}:</p>
            <x-button>{{ __('Primary') }}</x-button>
            <x-button variant="gray">{{ __('Gray') }}</x-button>
            <x-button variant="red">{{ __('Red') }}</x-button>
            <x-button variant="yellow">{{ __('Yellow') }}</x-button>
            <x-button variant="green">{{ __('Green') }}</x-button>
            <x-button variant="blue">{{ __('Blue') }}</x-button>
            <x-button variant="indigo">{{ __('Indigo') }}</x-button>
            <x-button variant="purple">{{ __('Purple') }}</x-button>
            <x-button variant="pink">{{ __('Pink') }}</x-button>
            <x-button variant="link">{{ __('Link') }}</x-button>

            <p class="mt-5">{{ __('Sizes') }}:</p>
            <x-button size="xs">{{ __('XS') }}</x-button>
            <x-button size="sm">{{ __('SM') }}</x-button>
            <x-button>{{ __('Default') }}</x-button>
            <x-button size="lg">{{ __('LG') }}</x-button>
            <x-button size="xl">{{ __('XL') }}</x-button>

        </x-tabs.div>

        <x-tabs.div name="code">
            <pre><code class="language-php">@php echo htmlentities('<x-button>Primary</x-button>
<x-button variant="gray">Gray</x-button>
<x-button variant="red">Red</x-button>
<x-button variant="yellow">Yellow</x-button>
<x-button variant="green">Green</x-button>
<x-button variant="blue">Blue</x-button>
<x-button variant="indigo">Indigo</x-button>
<x-button variant="purple">Purple</x-button>
<x-button variant="pink">Pink</x-button>
<x-button variant="link">Link</x-button>') @endphp</code></pre>
        </x-tabs.div>
    </x-tabs>
</div>
