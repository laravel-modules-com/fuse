<?php

namespace Modules\Contacts\Livewire\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\Contacts\Models\Contact;

class EditContact extends Component
{
    public Contact $contact;

    public string $name = '';

    public string $email = '';

    public function mount(Contact $contact): void
    {
        $this->contact = $contact;
        $this->name = $contact->name;
        $this->email = $contact->email;
    }

    /**
     * @return array<string, array<int, string>>
     */
    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:contacts,email,'.$this->contact->id,
            ],
        ];
    }

    public function render(): View
    {
        abort_if_cannot('edit_contacts');

        return view('contacts::livewire.admin.edit-contact');
    }

    public function update(): Redirector
    {
        $validated = $this->validate();
        $this->contact->update($validated);

        add_user_log([
            'title' => 'Updated contact '.$this->name,
            'reference_id' => $this->contact->id,
            'link' => route('admin.contacts.show', ['contact' => $this->contact->id]),
            'section' => 'Contacts',
            'type' => 'Update',
        ]);

        flash('Contact Updated!')->success();

        return redirect()->route('admin.contacts.index');
    }
}
