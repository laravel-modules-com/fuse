<div class="card">
    <h2><a name="badges">{{ __('Badge') }}</a></h2>

    <x-tabs name="preview">
        <x-tabs.header>
            <x-tabs.link name="preview">{{ __('Preview') }}</x-tabs.link>
            <x-tabs.link name="code">{{ __('Code') }}</x-tabs.link>
        </x-tabs.header>

        <x-tabs.div name="preview">

            <p>{{ __('Passing a variant will change the background color of the alert. The available variants are: gray, red, yellow, green, blue, indigo, purple, pink.') }}</p>
            <p>{{ __('Primary is the default variant.') }}</p>

            <x-badge>{{ __('Primary') }}</x-badge>
            <x-badge variant="gray">{{ __('Gray') }}</x-badge>
            <x-badge variant="red">{{ __('Red') }}</x-badge>
            <x-badge variant="yellow">{{ __('Yellow') }}'</x-badge>
            <x-badge variant="green">{{ __('Green') }}</x-badge>
            <x-badge variant="blue">{{ __('Blue') }}</x-badge>
            <x-badge variant="indigo">{{ __('Indigo') }}</x-badge>
            <x-badge variant="purple">{{ __('Purple') }}</x-badge>
            <x-badge variant="pink">{{ __('Pink') }}</x-badge>
        </x-tabs.div>

        <x-tabs.div name="code">
            <pre><code class="language-php">@php echo htmlentities('<x-badge>Primary</x-badge>
<x-badge variant="gray">Gray</x-badge>
<x-badge variant="red">Red</x-badge>
<x-badge variant="yellow">Yellow</x-badge>
<x-badge variant="green">Green</x-badge>
<x-badge variant="blue">Blue</x-badge>
<x-badge variant="indigo">Indigo</x-badge>
<x-badge variant="purple">Purple</x-badge>
<x-badge variant="pink">Pink</x-badge>') @endphp</code></pre>
        </x-tabs.div>
    </x-tabs>
</div>
