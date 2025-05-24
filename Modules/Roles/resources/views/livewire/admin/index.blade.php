<div>
    <div class="flex justify-between">

        <h1>{{ __('Roles') }}</h1>

        <div>
            @can('add_roles')
                <livewire:roles::admin.create @added="$refresh"/>
            @endcan
        </div>

    </div>

    @include('errors.messages')

    <div class="card">

        <x-alert>
            <x-heroicon-c-information-circle class="size-6 sm:size-5 mr-2 sm:mr-1.5 flex-shrink-0" />
            <span class="flex-1">
                {{ __("By default, only admin roles have full access. Additional roles will need permissions applied by editing the roles below.") }}
            </span>
        </x-alert>

        <div class="grid sm:grid-cols-1 md:grid-cols-4 gap-4">

            <div class="col-span-2">
                <x-form.input type="search" id="roles" name="name" wire:model.live="name" label="none" :placeholder="__('Search Roles')" />
            </div>

        </div>

        <table>
            <thead>
            <tr>
                <th>
                    <a class="link" href="#" wire:click.prevent="sortBy('name')">{{ __('Name') }}</a>
                </th>
                <th>
                {{ __('Action') }}
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($this->roles() as $role)
            <tr>
                <td>{{ $role->label }}</td>
                <td>
                    <div class="flex space-x-2">

                        @can('edit_roles')
                            <x-a href="{{ route('admin.settings.roles.edit', ['role' => $role->id]) }}">{{ __('Edit') }}</x-a>
                        @endcan

                        @if ($role->name !== 'admin')
                            @can('delete_roles')
                                <div x-data="{ confirmation: '' }">
                                    <x-modal>
                                        <x-slot name="trigger">
                                            <x-a navigate="off" @click="on = true">{{ __('Delete') }}</x-a>
                                        </x-slot>

                                        <x-slot name="modalTitle">
                                            <div class="pt-5">
                                                {{ __('Are you sure you want to delete') }}: <b>{{ $role->label }}</b>
                                            </div>
                                        </x-slot>

                                        <x-slot name="content">
                                            <label class="flex flex-col gap-2">
                                                <div>{{ __('Type') }} <span class="font-bold">"{{ $role->label }}"</span> {{ __('to confirm') }}</div>
                                                <input autofocus x-model="confirmation" class="px-3 py-2 border border-slate-300 rounded-lg">
                                            </label>
                                        </x-slot>

                                        <x-slot name="footer">
                                            <x-button variant="gray" @click="on = false">{{ __('Cancel') }}</x-button>
                                            <x-button variant="red" x-bind:disabled="confirmation !== '{{ $role->label }}'" wire:click="deleteRole('{{ $role->id }}')">{{ __('Delete Role') }}</x-button>
                                        </x-slot>
                                    </x-modal>
                                    </div>
                            @endcan
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
            </tbody>
        </table>

        {{ $this->roles()->links() }}

    </div>

</div>
