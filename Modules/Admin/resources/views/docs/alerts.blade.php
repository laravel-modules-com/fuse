<div class="card">
    <h2><a name="alerts">{{ __('Alerts') }}</a></h2>

    <x-tabs name="preview">
        <x-tabs.header>
            <x-tabs.link name="preview">{{ __('Preview') }}</x-tabs.link>
            <x-tabs.link name="code">{{ __('Code') }}</x-tabs.link>
        </x-tabs.header>

        <x-tabs.div name="preview">

            <p>{{ __('Passing a variant will change the background color of the alert. The available variants are: gray, red, yellow, green, blue, indigo, purple, pink.') }}</p>
            <p>{{ __('Primary is the default variant.') }}</p>

            <x-alert>{{ __('Primary') }}</x-alert>
            <x-alert variant="gray">{{ __('Gray') }}</x-alert>
            <x-alert variant="red">{{ __('Red') }}</x-alert>
            <x-alert variant="yellow">{{ __('Yellow') }}</x-alert>
            <x-alert variant="green">{{ __('Green') }}</x-alert>
            <x-alert variant="blue">{{ __('Blue') }}</x-alert>
            <x-alert variant="indigo">{{ __('Indigo') }}</x-alert>
            <x-alert variant="purple">{{ __('Purple') }}</x-alert>
            <x-alert variant="pink">{{ __('Pink') }}</x-alert>
        </x-tabs.div>

        <x-tabs.div name="code">
            <pre><code class="language-php">@php echo htmlentities('<x-alert>Primary</x-alert>
<x-alert variant="gray">Gray</x-alert>
<x-alert variant="red">Red</x-alert>
<x-alert variant="yellow">Yellow</x-alert>
<x-alert variant="green">Green</x-alert>
<x-alert variant="blue">Blue</x-alert>
<x-alert variant="indigo">Indigo</x-alert>
<x-alert variant="purple">Purple</x-alert>
<x-alert variant="pink">Pink</x-alert>') @endphp</code></pre>
        </x-tabs.div>
    </x-tabs>
</div>
