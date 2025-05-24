<?php

use Illuminate\Support\Facades\Blade;

test('renders with default props', function () {
    $rendered = Blade::render('<x-a href="#">Link Text</x-a>');

    expect($rendered)
        ->toContain('href="#"')
        ->toContain('wire:navigate')
        ->toContain('Link Text');
});

test('renders without wire:navigate when navigate is false', function () {
    $rendered = Blade::render('<x-a href="#" :navigate="false">Link Text</x-a>');

    expect($rendered)
        ->toContain('href="#"')
        ->not->toContain('wire:navigate')
        ->toContain('Link Text');
});

test('renders with different variants', function ($variant, $expectedClass) {
    $rendered = Blade::render('<x-a href="#" variant="'.$variant.'">Link Text</x-a>');

    expect($rendered)
        ->toContain($expectedClass);
})->with([
    ['gray', 'bg-gray-200'],
    ['red', 'bg-red-500'],
    ['yellow', 'bg-yellow-500'],
    ['green', 'bg-green-500'],
    ['blue', 'bg-blue-500'],
    ['indigo', 'bg-indigo-500'],
    ['purple', 'bg-purple-500'],
    ['pink', 'bg-pink-500'],
    ['link', 'text-primary'],
]);

test('renders with different sizes', function ($size, $expectedClass) {
    $rendered = Blade::render('<x-a href="#" size="'.$size.'">Link Text</x-a>');

    expect($rendered)
        ->toContain($expectedClass);
})->with([
    ['xs', 'px-2 py-1 text-sm'],
    ['sm', 'px-3 py-2 text-sm'],
    ['lg', 'px-6 py-3'],
    ['xl', 'px-8 py-4'],
    ['icon', 'size-10'],
]);

test('merges classes correctly', function () {
    $rendered = Blade::render('<x-a href="#" class="custom-class">Link Text</x-a>');

    expect($rendered)
        ->toContain('class="')
        ->toContain('custom-class');
});

test('passes through other attributes', function () {
    $rendered = Blade::render('<x-a href="#" id="my-link" data-test="value">Link Text</x-a>');

    expect($rendered)
        ->toContain('id="my-link"')
        ->toContain('data-test="value"');
});
