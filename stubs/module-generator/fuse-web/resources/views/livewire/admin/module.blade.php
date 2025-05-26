<div>
    <div class="flex justify-between">

        <h1>{{ __('{Module }') }}</h1>

        <div class="flex space-x-2">

            @can('add_{module_}')
                <x-a variant="primary" size="sm" href="{{ route('admin.{module-}.create') }}">{{ __('Add {Model }') }}</x-a>
            @endcan

        </div>

    </div>

    <div class="card">

        @include('errors.messages')

        <div class="mt-5 mb-5 grid sm:grid-cols-1 md:grid-cols-3 gap-4">

            <div class="col-span-2">
                <x-form.input type="search" name="name" wire:model.live="name" label="none" :placeholder="__('Search {Module }')" />
            </div>

            @if ((@can('delete_{module_}') || @can('export_{module_}') || @can('import_{module_}')))
                <x-dropdown label="Actions">

                    @can('import_{module_}')
                    <x-dropdown.link navigate="off" href="{{ route('admin.{module-}.import') }}">
                        {{ __('Import {Module }') }}
                    </x-dropdown.link>
                    @endcan

                    @if (@can('delete_{module_}') && $this->affected{Module}Count() > 0)
                        <div x-data="{ archiveConfirmation: '' }">
                            <x-modal>
                                <x-slot name="trigger">
                                    <x-dropdown.link navigate="off" href="#" @click="on = true">
                                        {{ __('Archive') }} {{ $this->affected{ModuleCamel}Count() }} {{ __('{Module }') }}
                                    </x-dropdown.link>
                                </x-slot>

                                <x-slot name="modalTitle">
                                    <div class="pt-5">
                                        {{ __('Are you sure you want to archive') }} {{ $this->affected{ModuleCamel}Count() }} {{ __('{Module }?') }}
                                    </div>
                                </x-slot>

                                <x-slot name="content">
                                    <label class="flex flex-col gap-2">
                                        <div>{{ __('Type') }} <span class="font-bold">"confirm"</span> {{ __('to proceed') }}</div>
                                        <input x-model="archiveConfirmation" class="px-3 py-2 border border-slate-300 rounded-lg">
                                    </label>
                                </x-slot>

                                <x-slot name="footer">
                                    <x-button variant="gray" @click="on = false">{{ __('Cancel') }}</x-button>
                                    <x-button variant="red" x-bind:disabled="archiveConfirmation !== 'confirm'" wire:click="archive{ModuleCamel}">{{ __('Archive {Module }') }}</x-button>
                                </x-slot>
                            </x-modal>
                        </div>
                    @endcan

                    @if (@can('export_module}') && $this->affected{ModuleCamel}Count() > 0)
                        <x-dropdown.link navigate="off" href="#" wire:click="export{ModuleCamel}">
                            {{ __('Export ') }} {{ $this->affected{ModuleCamel}Count() }} {{ __('{Module } to CSV') }}
                        </x-dropdown.link>
                    @endcan

                </x-dropdown>
            @endif


        </div>

        <div class="mb-5" x-data="{ isOpen: @if($openFilter || request('openFilter')) true @else false @endif }">

            <button type="button" @click="isOpen = !isOpen" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-t text-grey-700 bg-gray-200 hover:bg-grey-300 dark:bg-gray-700 dark:text-gray-200 transition ease-in-out duration-150">
                <svg class="h-5 w-5 text-gray-500 dark:text-gray-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                {{ __('Advanced Search') }}
            </button>

            <button type="button" wire:click="resetFilters" @click="isOpen = false" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs leading-4 font-medium rounded text-grey-700 bg-gray-200 hover:bg-grey-300 dark:bg-gray-700 dark:text-gray-200 transition ease-in-out duration-150">
                <svg class="h-5 w-5 text-gray-500 dark:text-gray-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                {{ __('Reset form') }}
            </button>

            <div
                    x-show="isOpen"
                    x-transition:enter="transition ease-out duration-100 transform"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75 transform"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="bg-gray-200 dark:bg-gray-700 rounded-b-md p-5"
                    wire:ignore.self>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <x-form.input type="email" id="email" name="email" :label="__('Email')" wire:model.live="email" />
                </div>
            </div>

        </div>

        <div class="overflow-x-scroll">
            <table>
            <thead>
            <tr>
                <th class="w-10"><input type="checkbox" wire:model.live="selectAll" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" /></th>
                <th><a href="#" wire:click="sortBy('name')">{{ __('Name') }}</a></th>
                <th><a href="#" wire:click="sortBy('email')">{{ __('Email') }}</a></th>
                <th>{{ __('Action') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($this->load{Module}() as ${modelCamel})
                <tr wire:key="{{ ${modelCamel}->id }}">
                    <td><input type="checkbox" wire:model.live="selected" value="{{ ${modelCamel}->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" /></td>
                    <td>{{ ${modelCamel}->name }}</td>
                    <td>{{ ${modelCamel}->email }}</td>
                    <td>
                        <div class="flex space-x-2">

                                @can('view_{module_}')
                                    <x-a href="{{ route('admin.{module-}.show', ${modelCamel}) }}">{{ __('View') }}</x-a>
                                @endcan

                                @can('edit_{module_}')
                                    <x-a href="{{ route('admin.{module-}.edit', ${modelCamel}) }}">{{ __('Edit') }}</x-a>
                                @endcan

                                @can('delete_{module_}')
                                    <div x-data="{ confirmation: '' }">
                                    <x-modal>
                                        <x-slot name="trigger">
                                            <x-a navigate="off" href="#" @click="on = true">{{ __('Delete') }}</x-a>
                                        </x-slot>

                                        <x-slot name="modalTitle">
                                            <div class="pt-5">
                                                {{ __('Are you sure you want to delete') }}: <b>{{ ${modelCamel}->name }}</b>
                                            </div>
                                        </x-slot>

                                        <x-slot name="content">
                                            <label class="flex flex-col gap-2">
                                                <div>{{ __('Type') }} <span class="font-bold">"{{ ${modelCamel}->name }}"</span> {{ __('to confirm') }}</div>
                                                <input x-model="confirmation" class="px-3 py-2 border border-slate-300 rounded-lg">
                                            </label>
                                        </x-slot>

                                        <x-slot name="footer">
                                            <x-button variant="gray" @click="on = false">{{ __('Cancel') }}</x-button>
                                            <x-button variant="red" x-bind:disabled="confirmation !== '{{ ${modelCamel}->name }}'" wire:click="delete{modelCamel}('{{ ${modelCamel}->id }}')">{{ __('Delete {Model }') }}</x-button>
                                        </x-slot>
                                    </x-modal>
                                    </div>
                                @endcan
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
            </table>
        </div>

        {{ $this->load{Module}()->links() }}

    </div>

</div>
