<div>
    @can('view_users')
        <p>
            <x-a href="{{ route('admin.users.index') }}">{{ __('Users') }}</x-a>
            <span class="dark:text-gray-200">- {{ __('Edit User') }}</span>
        </p>
    @endcan

    <livewire:users::admin.edit.profile :user="$user"/>
    <livewire:users::admin.edit.change-password :user="$user"/>
    <livewire:users::admin.edit.two-factor-authentication :user="$user"/>

    @can('edit_roles')
        <livewire:users::admin.edit.admin-settings :user="$user"/>
        <livewire:users::admin.edit.roles :user="$user"/>
    @endcan
</div>
