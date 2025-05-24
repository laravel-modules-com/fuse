@use(Modules\Roles\Models\Permission)
<div
    x-data="{
        init() {
            this.$watch('$wire.permissions', () => {
                this.updateAllToggles();
            });

            this.$nextTick(() => {
                this.updateAllToggles();
            });
        },

        toggleAll(checked) {
            if (checked) {
                const allPermissions = [];
                document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
                    allPermissions.push(checkbox.value);
                });
                $wire.set('permissions', allPermissions);
            } else {
                $wire.set('permissions', []);
            }
        },

        toggleModule(module, checked) {
            const moduleCheckboxes = document.querySelectorAll(`.permission-checkbox[data-module='${module}']`);
            const currentPermissions = [...$wire.permissions];
            let newPermissions = [...currentPermissions];

            moduleCheckboxes.forEach(checkbox => {
                const value = checkbox.value;

                if (checked && !newPermissions.includes(value)) {
                    newPermissions.push(value);
                } else if (!checked && newPermissions.includes(value)) {
                    newPermissions = newPermissions.filter(item => item !== value);
                }
            });

            $wire.set('permissions', newPermissions);
        },

        updateAllToggles() {
            this.updateGlobalToggle();
            this.updateModuleToggles();
        },

        updateGlobalToggle() {
            // Get all permission checkboxes and their values
            const allCheckboxes = document.querySelectorAll('.permission-checkbox');
            const allCheckboxValues = Array.from(allCheckboxes).map(checkbox => checkbox.value);

            // Get the current permissions from the Livewire component
            const currentPermissions = $wire.permissions || [];

            // Count how many of the current permissions are actually in our checkbox list
            const validCheckedValues = currentPermissions.filter(value => allCheckboxValues.includes(value));

            const globalToggle = document.getElementById('toggle-all-permissions');
            if (globalToggle) {
                // Only check the global toggle if ALL checkboxes are checked
                globalToggle.checked = allCheckboxes.length > 0 && validCheckedValues.length === allCheckboxes.length;
                globalToggle.indeterminate = validCheckedValues.length > 0 && validCheckedValues.length < allCheckboxes.length;
            }
        },

        updateModuleToggles() {
            document.querySelectorAll('.toggle-module').forEach(moduleToggle => {
                const module = moduleToggle.dataset.module;

                // Get all checkboxes for this module and their values
                const moduleCheckboxes = document.querySelectorAll(`.permission-checkbox[data-module='${module}']`);
                const moduleCheckboxValues = Array.from(moduleCheckboxes).map(checkbox => checkbox.value);

                // Get the current permissions from the Livewire component
                const currentPermissions = $wire.permissions || [];

                // Count how many of the current permissions are in this module
                const validCheckedModuleValues = currentPermissions.filter(value => moduleCheckboxValues.includes(value));

                // Only check the module toggle if all checkboxes in the module are checked
                moduleToggle.checked = moduleCheckboxes.length > 0 && validCheckedModuleValues.length === moduleCheckboxes.length;
                moduleToggle.indeterminate = validCheckedModuleValues.length > 0 && validCheckedModuleValues.length < moduleCheckboxes.length;
            });
        }
    }"
>
    <p class="mb-5">
        <x-a href="{{ route('admin.settings.roles.index') }}">{{ __('Roles') }}</x-a>
        <span class="dark:text-gray-200">- {{ __('Edit Role') }}</span>
    </p>

    <div class="float-right">
        <span class="error">*</span>
        <span class="dark:text-gray-200"> = {{ __('required') }}</span>
    </div>

    <div class="clearfix"></div>

    <x-form wire:submit="update" method="put">

        <div class="row">

            <div class="md:w-1/2">
                @if ($role->name === 'admin')
                    <x-form.input wire:model.live="label" :label="__('Role')" name='label' disabled />
                @else
                    <x-form.input wire:model.live="label" :label="__('Role')" name='label' required />
                @endif
            </div>

        </div>

        @if ($role->name !== 'admin')
            <div class="mb-4">
                <label class="flex items-center gap-2 font-semibold cursor-pointer">
                    <input
                        type="checkbox"
                        id="toggle-all-permissions"
                        class="form-checkbox"
                        x-on:change="toggleAll($event.target.checked)"
                    >
                    {{ __('Toggle All Permissions') }}
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($modules as $module)
                <div class="card relative">
                    <div class="flex items-center justify-between mb-2">
                        <h3>{{ $module }}</h3>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input
                                type="checkbox"
                                class="toggle-module form-checkbox"
                                data-module="{{ $module }}"
                                x-on:change="toggleModule('{{ $module }}', $event.target.checked)"
                            >
                            <span class="text-sm">{{ __('Toggle All') }}</span>
                        </label>
                    </div>
                    @foreach (Permission::where('module', $module)->orderby('name')->get() as $perm)
                        <label class="block cursor-pointer">
                            <div class="flex gap-2">
                            <input
                                type="checkbox"
                                class="permission-checkbox"
                                data-module="{{ $module }}"
                                wire:model="permissions"
                                value="{{ $perm->name }}"
                            >
                                {{ $perm->label }}
                            </div>
                        </label>
                    @endforeach
                </div>
            @endforeach
            </div>

        @endif

        <x-button class="mt-5">{{ __('Update Role') }}</x-button>

    </x-form>

</div>
