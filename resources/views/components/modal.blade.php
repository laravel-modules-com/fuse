@props([
    'modalTitle' => '',
    'content' => '',
    'footer' => '',
    'height' => 'sm:w-full md:w-1/2' // Ensures full width on small screens
])

<div x-data="{
        on: false,
        open() {
            this.on = true;
            document.body.classList.add('overflow-hidden');
        },
        close() {
            this.on = false;
            document.body.classList.remove('overflow-hidden');
        }
    }" x-on:close-modal.window="close()">

    <!-- Trigger -->
    {{ $trigger }}

    <!-- Background Overlay -->
    <div class="fixed inset-0 bg-gray-500 opacity-75 z-50"
         x-show="on"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
    ></div>

    <!-- Modal Container -->
    <div class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
         x-show="on"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         @keydown.escape.window="close()"
         @click.away="false"
    >
        <div class="relative bg-white dark:bg-gray-600 dark:text-gray-200 rounded-lg shadow-xl w-full max-w-md sm:max-w-lg md:max-w-xl {{ $height }}"
             role="dialog" aria-modal="true" aria-labelledby="modal-headline"
        >
            <div class="flex flex-col max-h-screen overflow-y-auto">
                <!-- Header -->
                <header class="text-center mb-4 px-6 pt-6">
                    <h2 class="text-lg font-semibold" id="modal-headline">{{ $modalTitle }}</h2>
                </header>

                <!-- Content -->
                <main class="mb-4 px-6">
                    {{ $content }}
                </main>

                <!-- Footer -->
                <footer class="p-4 mt-4 bg-slate-100 dark:bg-gray-500">
                    <div class="flex justify-end gap-4">
                        {{ $footer }}
                    </div>
                </footer>

                <!-- Close Button -->
                <div class="absolute top-0 right-0 pt-4 pr-4">
                    <button type="button" @click="close()" class="bg-gray-50 text-gray-600 rounded-lg p-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                        <span class="sr-only">Close modal</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
