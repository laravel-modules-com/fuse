<x-layouts.app>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col md:flex-row">
                        <!-- Sidebar Navigation -->
                        <div class="w-full md:w-64 flex-shrink-0 mb-6 md:mb-0 md:mr-6">
                            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Documentation</h3>

                                <nav class="space-y-1">
                                    @foreach($navigation as $title => $item)
                                        @if(isset($item['children']))
                                            <div class="mb-2">
                                                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-1">{{ $title }}</h4>
                                                <div class="pl-4 space-y-1">
                                                    @foreach($item['children'] as $childTitle => $child)
                                                        <a href="{{ $child['url'] }}"
                                                           class="block text-sm {{ $child['active'] ? 'text-blue-600 dark:text-blue-400 font-medium' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">
                                                            {{ $childTitle }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            <a href="{{ $item['url'] }}"
                                               class="block text-sm {{ $item['active'] ? 'text-blue-600 dark:text-blue-400 font-medium' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">
                                                {{ $title }}
                                            </a>
                                        @endif
                                    @endforeach
                                </nav>
                            </div>
                        </div>

                        <!-- Main Content -->
                        <div class="flex-1">
                            <div class="prose dark:prose-invert max-w-none">
                                {!! $html !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
