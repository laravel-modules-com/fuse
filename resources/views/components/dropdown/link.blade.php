@props([
    'navigate' => 'on',
])
<a @if($navigate === 'on') wire:navigate @endif {{ $attributes->merge(['class' => 'block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:text-gray-200 dark:hover:bg-gray-600 focus:outline-none']) }}>{{ $slot }}</a>
