<div class="card">
    <h2><a name="links">Links</a></h2>

    <x-tabs name="preview">
        <x-tabs.header>
            <x-tabs.link name="preview">Preview</x-tabs.link>
            <x-tabs.link name="code">Code</x-tabs.link>
        </x-tabs.header>

        <x-tabs.div name="preview">
            <x-a href="#">Primary</x-a>
            <x-a href="#" variant="gray">Gray</x-a>
            <x-a href="#" variant="red">Red</x-a>
            <x-a href="#" variant="yellow">Yellow</x-a>
            <x-a href="#" variant="green">Green</x-a>
            <x-a href="#" variant="blue">Blue</x-a>
            <x-a href="#" variant="indigo">Indigo</x-a>
            <x-a href="#" variant="purple">Purple</x-a>
            <x-a href="#" variant="pink">Pink</x-a>
            <x-a href="#" variant="link">Link Style</x-a>

            <div class="mt-4">
                <x-a href="#" size="xs">Extra Small</x-a>
                <x-a href="#" size="sm">Small</x-a>
                <x-a href="#">Default</x-a>
                <x-a href="#" size="lg">Large</x-a>
                <x-a href="#" size="xl">Extra Large</x-a>
            </div>
        </x-tabs.div>

        <x-tabs.div name="code">
            <p>The <code>x-a</code> component is a styled anchor tag that supports the same color variants and sizes as the button component.</p>

            <p>Passing a variant will change the background color of the link. The available variants are: gray, red, yellow, green, blue, indigo, purple, pink, and link.</p>
            <p>Primary is the default variant.</p>

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
