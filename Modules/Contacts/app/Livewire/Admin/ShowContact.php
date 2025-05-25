<?php

namespace Modules\Contacts\Livewire\Admin;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Modules\Contacts\Models\Contact;

class ShowContact extends Component
{
    public Contact $contact;

    public function mount(Contact $contact): void
    {
        $this->contact = $contact;
    }

    public function render(): View
    {
        abort_if_cannot('view_contacts');

        return view('contacts::livewire.admin.show-contact');
    }
}
