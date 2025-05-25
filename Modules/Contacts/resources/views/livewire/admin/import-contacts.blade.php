<div>
    <div class="flex justify-between">
        <h1>{{ __('Import Contacts') }}</h1>
        <div class="flex space-x-2">
            <x-a variant="secondary" size="sm" href="{{ route('admin.contacts.index') }}">{{ __('Back to Contacts') }}</x-a>
        </div>
    </div>

    <div class="card">
        @include('errors.messages')

        <div class="mb-5">
            <div class="flex items-center">
                <div class="flex-1">
                    <ol class="flex items-center w-full">
                        <li class="flex items-center {{ $step >= 1 ? 'text-blue-600 dark:text-blue-500' : 'text-gray-500 dark:text-gray-400' }}">
                            <span class="flex items-center justify-center w-5 h-5 mr-2 text-xs border {{ $step >= 1 ? 'border-blue-600 dark:border-blue-500' : 'border-gray-500 dark:border-gray-400' }} rounded-full shrink-0">
                                1
                            </span>
                            {{ __('Upload CSV') }}
                            <svg class="w-3 h-3 mx-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4"/>
                            </svg>
                        </li>
                        <li class="flex items-center {{ $step >= 2 ? 'text-blue-600 dark:text-blue-500' : 'text-gray-500 dark:text-gray-400' }}">
                            <span class="flex items-center justify-center w-5 h-5 mr-2 text-xs border {{ $step >= 2 ? 'border-blue-600 dark:border-blue-500' : 'border-gray-500 dark:border-gray-400' }} rounded-full shrink-0">
                                2
                            </span>
                            {{ __('Map Fields') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>

        @if($step == 1)
            <div class="mb-5">
                <h2 class="text-lg font-medium mb-4">{{ __('Upload CSV File') }}</h2>
                <p class="mb-4">{{ __('Upload a CSV file containing contact information. The file should have headers in the first row.') }}</p>
                <p class="mb-4">{{ __('Required fields: Name, Email') }}</p>

                <div class="mb-4">
                    <div
                        x-data="{ isUploading: false, progress: 0 }"
                        x-on:livewire-upload-start="isUploading = true"
                        x-on:livewire-upload-finish="isUploading = false"
                        x-on:livewire-upload-error="isUploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress"
                    >
                        <label for="csvFile" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('CSV File') }}</label>
                        <input type="file" id="csvFile" wire:model="csvFile" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">

                        <!-- Progress Bar -->
                        <div x-show="isUploading" class="mt-2">
                            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                <div class="bg-blue-600 h-2.5 rounded-full" x-bind:style="'width: ' + progress + '%'"></div>
                            </div>
                            <p class="text-sm text-gray-500 mt-1" x-text="'Uploading: ' + progress + '%'"></p>
                        </div>

                        @error('csvFile') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex justify-end">
                    <x-button type="button" wire:click="$refresh" variant="secondary" class="mr-2">{{ __('Reset') }}</x-button>
                </div>
            </div>
        @endif

        @if($step == 2)
            <div class="mb-5">
                <h2 class="text-lg font-medium mb-4">{{ __('Map Fields') }}</h2>
                <p class="mb-4">{{ __('Map the columns from your CSV file to the required contact fields.') }}</p>

                <div class="mb-4">
                    <h3 class="text-md font-medium mb-2">{{ __('Field Mapping') }}</h3>

                    @foreach($requiredFields as $field)
                        <div class="mb-3">
                            <label for="mapping_{{ $field }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ ucfirst($field) }} <span class="text-red-500">*</span>
                            </label>
                            <select id="mapping_{{ $field }}" wire:model="fieldMapping.{{ $field }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">{{ __('Select CSV column') }}</option>
                                @foreach($headers as $index => $header)
                                    <option value="{{ $index }}">{{ $header }}</option>
                                @endforeach
                            </select>
                            @error('fieldMapping.'.$field) <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    @endforeach
                </div>

                <div class="mb-4">
                    <h3 class="text-md font-medium mb-2">{{ __('Preview') }}</h3>
                    <p class="mb-2">{{ __('Total rows to import:') }} {{ $totalRows }}</p>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    @foreach($headers as $header)
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ $header }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                                @foreach($csvData as $row)
                                    <tr>
                                        @foreach($row as $cell)
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $cell }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex justify-between">
                    <x-button type="button" wire:click="back" variant="secondary">{{ __('Back') }}</x-button>
                    <x-button type="button" wire:click="startImport" variant="primary">{{ __('Start Import') }}</x-button>
                </div>
            </div>
        @endif
    </div>
</div>
