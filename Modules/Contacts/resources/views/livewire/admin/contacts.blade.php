<div>
    <div class="flex justify-between">

        <h1>{{ __('Contacts') }}</h1>

        <div class="flex space-x-2">

            @can('add_contacts')
                <x-a variant="primary" size="sm" href="{{ route('admin.contacts.create') }}">{{ __('Add Contact') }}</x-a>
            @endcan

        </div>

    </div>

    <div class="card">

        @include('errors.messages')

        <div class="mt-5 mb-5 grid sm:grid-cols-1 md:grid-cols-3 gap-4">

            <div class="col-span-2">
                <x-form.input type="search" name="name" wire:model.live="name" label="none" :placeholder="__('Search Contacts')" />
            </div>

            @if ((@can('delete_contacts') || @can('export_contacts') || @can('import_contacts')))
                <x-dropdown label="Actions">

                    @can('import_contacts')
                    <x-dropdown.link navigate="off" href="{{ route('admin.contacts.import') }}">
                        {{ __('Import contacts') }}
                    </x-dropdown.link>
                    @endcan

                    @if (@can('delete_contacts') && $this->affectedContactsCount() > 0)
                        <div x-data="{ archiveConfirmation: '' }">
                            <x-modal>
                                <x-slot name="trigger">
                                    <x-dropdown.link navigate="off" href="#" @click="on = true">
                                        {{ __('Archive') }} {{ $this->affectedContactsCount() }} {{ __('contacts') }}
                                    </x-dropdown.link>
                                </x-slot>

                                <x-slot name="modalTitle">
                                    <div class="pt-5">
                                        {{ __('Are you sure you want to archive') }} {{ $this->affectedContactsCount() }} {{ __('contacts?') }}
                                    </div>
                                </x-slot>

                                <x-slot name="content">
                                    <label class="flex flex-col gap-2">
                                        <div>{{ __('Type') }} <span class="font-bold">"confirm"</span> {{ __('to proceed') }}</div>
                                        <input autofocus x-model="archiveConfirmation" class="px-3 py-2 border border-slate-300 rounded-lg">
                                    </label>
                                </x-slot>

                                <x-slot name="footer">
                                    <x-button variant="gray" @click="on = false">{{ __('Cancel') }}</x-button>
                                    <x-button variant="red" x-bind:disabled="archiveConfirmation !== 'confirm'" wire:click="archiveContacts">{{ __('Archive contacts') }}</x-button>
                                </x-slot>
                            </x-modal>
                        </div>
                    @endcan

                    @if (@can('export_contacts') && $this->affectedContactsCount() > 0)
                        <x-dropdown.link navigate="off" href="#" wire:click="exportContacts">
                            {{ __('Export ') }} {{ $this->affectedContactsCount() }} {{ __('contacts to CSV') }}
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
                <th class="w-10">
                    <input type="checkbox"
                           wire:model.live="selectAll"
                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                </th>
                <th><a href="#" wire:click="sortBy('name')">{{ __('Name') }}</a></th>
                <th><a href="#" wire:click="sortBy('email')">{{ __('Email') }}</a></th>
                <th>{{ __('Action') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($this->contacts() as $contact)
                <tr wire:key="{{ $contact->id }}">
                    <td>
                        <input type="checkbox"
                               wire:model.live="selected"
                               value="{{ $contact->id }}"
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                    </td>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>
                        <div class="flex space-x-2">

                                @can('view_contacts')
                                    <x-a href="{{ route('admin.contacts.show', $contact) }}">{{ __('View') }}</x-a>
                                @endcan

                                @can('edit_contacts')
                                    <x-a href="{{ route('admin.contacts.edit', $contact) }}">{{ __('Edit') }}</x-a>
                                @endcan

                                @can('delete_contacts')
                                    <div x-data="{ confirmation: '' }">
                                    <x-modal>
                                        <x-slot name="trigger">
                                            <x-a navigate="off" href="#" @click="on = true">{{ __('Delete') }}</x-a>
                                        </x-slot>

                                        <x-slot name="modalTitle">
                                            <div class="pt-5">
                                                {{ __('Are you sure you want to delete') }}: <b>{{ $contact->name }}</b>
                                            </div>
                                        </x-slot>

                                        <x-slot name="content">
                                            <label class="flex flex-col gap-2">
                                                <div>{{ __('Type') }} <span class="font-bold">"{{ $contact->name }}"</span> {{ __('to confirm') }}</div>
                                                <input autofocus x-model="confirmation" class="px-3 py-2 border border-slate-300 rounded-lg">
                                            </label>
                                        </x-slot>

                                        <x-slot name="footer">
                                            <x-button variant="gray" @click="on = false">{{ __('Cancel') }}</x-button>
                                            <x-button variant="red" x-bind:disabled="confirmation !== '{{ $contact->name }}'" wire:click="deleteContact('{{ $contact->id }}')">{{ __('Delete Contact') }}</x-button>
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

        {{ $this->contacts()->links() }}

    </div>

</div>
