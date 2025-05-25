<?php

declare(strict_types=1);

namespace Modules\Contacts\Livewire\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\Contacts\Models\Contact;
use Illuminate\Contracts\View\View;

use function add_user_log;
use function flash;
use function redirect;
use function route;
use function view;

#[Title('Create Contact')]
class CreateContact extends Component
{
    public string $name = '';

    public string $email = '';

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
                'unique:contacts,email',
            ],
        ];
    }

    public function render(): View
    {
        abort_if_cannot('add_contacts');

        return view('contacts::livewire.admin.create-contact');
    }

    public function create(): Redirector
    {
        $validated = $this->validate();
        $contact = Contact::create($validated);

        add_user_log([
            'title' => 'Created contact '.$this->name,
            'reference_id' => $contact->id,
            'link' => route('admin.contacts.show', ['contact' => $contact->id]),
            'section' => 'Contacts',
            'type' => 'Create',
        ]);

        flash('Contact Created!')->success();

        return redirect()->route('admin.contacts.index');
    }
}
