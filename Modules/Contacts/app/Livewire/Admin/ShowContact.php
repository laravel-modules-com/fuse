<?php

declare(strict_types=1);

namespace Modules\Contacts\Livewire\Admin;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;
use Modules\Contacts\Models\Contact;

use function abort_if_cannot;
use function view;

#[Title('View Contact')]
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
