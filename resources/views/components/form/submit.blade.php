<x-button
    type="submit"
    id="submit"
    {{ $attributes->merge([
        'class' => 'btn btn-primary disabled:cursor-not-allowed disabled:opacity-75 mt-5'
    ]) }}
>
    {{ $slot }}
</x-button>
