@php
    $class = "inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ";

    $class .= " " . match($attributes->get("variant")) {
        default => "bg-primary text-white ring-primary/10",
        'gray' => "bg-gray-200 text-gray-700 shadow-md dark:bg-gray-500 dark:text-gray-300",
        'red' => "bg-red-500 text-red-200 shadow-md dark:bg-red-700 dark:text-red-100",
        'yellow' => "bg-yellow-500 text-yellow-200 shadow-md dark:bg-yellow-600 dark:text-yellow-100",
        'green' => "bg-green-500 text-green-200 shadow-md dark:bg-green-700 dark:text-green-100",
        'blue' => "bg-blue-500 text-blue-200 shadow-md dark:bg-blue-700 dark:text-blue-100",
        'indigo' => "bg-indigo-500 text-indigo-200 shadow-md dark:bg-indigo-700 dark:text-indigo-100",
        'purple' => "bg-purple-500 text-purple-200 shadow-md dark:bg-purple-700 dark:text-purple-100",
        'pink' => "bg-pink-500 text-pink-200 shadow-md dark:bg-pink-700 dark:text-pink-100",
    };
@endphp

<div {{ $attributes->merge(["class" => $class])->except(['variant']) }}>
    <div class="flex items-center">
        {{ $slot }}
    </div>
</div>
