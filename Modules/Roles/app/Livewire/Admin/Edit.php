<?php

declare(strict_types=1);

namespace Modules\Roles\Livewire\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;
use Modules\Roles\Models\Permission;
use Modules\Roles\Models\Role;

#[Title('Edit Role')]
class Edit extends Component
{
    public ?Role $role = null;

    public string $label = '';

    /**
     * @var array<string>
     */
    public array $permissions = [];

    /**
     * @return array<string, array<int, Unique|string>>
     */
    protected function rules(): array
    {
        return [
            'label' => [
                'required',
                'string',
                Rule::unique('roles')->ignore($this->role->id),
            ],
        ];
    }

    /**
     * @var array<string, string>
     */
    protected array $messages = [
        'label.required' => 'Role is required',
    ];

    public function mount(Role $role): void
    {
        $this->role = Role::where('id', $role->id)->firstOrFail();

        $this->label = $this->role->label ?? '';

        if (isset($this->role->permissions)) {
            foreach ($this->role->permissions as $perm) {
                /** @var Permission $perm */
                $this->permissions[] = $perm->name;
            }
        }
    }

    public function render(): View
    {
        abort_if_cannot('edit_roles');

        $modules = Permission::select('module')->distinct()->orderBy('module')->pluck('module');

        return view('roles::livewire.admin.edit', compact('modules'));
    }

    /**
     * @throws ValidationException
     */
    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function update(): Redirector|RedirectResponse
    {
        $this->validate();

        $this->role->label = $this->label;
        $this->role->name = strtolower(str_replace(' ', '_', $this->label));

        if ($this->permissions) {
            $this->role->syncPermissions($this->permissions);
        }

        $this->role->save();

        add_user_log([
            'title' => 'updated role '.$this->label,
            'link' => route('admin.settings.roles.edit', ['role' => $this->role->id]),
            'reference_id' => $this->role->id,
            'section' => 'Roles',
            'type' => 'Update',
        ]);

        flash('Role updated')->success();

        return redirect()->route('admin.settings.roles.index');
    }
}
