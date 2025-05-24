<div class="card">
    <h2><a name="error">{{ __('Error') }}</a></h2>
    <p>.error {{ __('use error class to apply red text.') }}</p>

    <x-tabs name="preview">
        <x-tabs.header>
            <x-tabs.link name="preview">{{ __('Preview') }}</x-tabs.link>
            <x-tabs.link name="code">{{ __('Code') }}</x-tabs.link>
        </x-tabs.header>

        <x-tabs.div name="preview">
            <p class="error">{{ __('Paragraph') }}</p>
        </x-tabs.div>

        <x-tabs.div name="code">
            <pre><code class="language-php">@php echo htmlentities('<p class="error">Paragraph</p>') @endphp</code></pre>
        </x-tabs.div>
    </x-tabs>
</div>
