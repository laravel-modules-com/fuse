<div>
    @can('view_users')
        <p>
            <x-a href="{{ route('admin.users.index') }}">{{ __('Users') }}</x-a>
            <span class="dark:text-gray-200">- {{ __('Edit User') }}</span>
        </p>
    @endcan

    <div class="md:flex">

        <div class="md:w-1/5 p-5 md:sticky top-0 h-full">
            <ul class="md:fixed overflow-x-auto space-y-2">
                <li><a class="text-primary" href="#profile">Profile</a></li>
                <li><a class="text-primary" href="#changepassword">Change Password</a></li>
                <li><a class="text-primary" href="#2fa">2FA</a></li>
                @can('edit_roles')
                    <li><a class="text-primary" href="#adminsettings">Admin Settings</a></li>
                    <li><a class="text-primary" href="#roles">Roles</a></li>
                @endcan
            </ul>
        </div>

        <div class="md:w-4/5 p-5">
            <livewire:users::admin.edit.profile :user="$user"/>
            <livewire:users::admin.edit.change-password :user="$user"/>
            <livewire:users::admin.edit.two-factor-authentication :user="$user"/>

            @can('edit_roles')
                <livewire:users::admin.edit.admin-settings :user="$user"/>
                <livewire:users::admin.edit.roles :user="$user"/>
            @endcan
        </div>
    </div>

</div>
