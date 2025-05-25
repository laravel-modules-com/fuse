<div>
    <div class="flex justify-between">
        <p>
            <x-a href="{{ route('admin.contacts.index') }}">{{ __('Contacts') }}</x-a>
            <span class="dark:text-gray-200">- {{ $contact->name }}</span>
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 lg:gap-6">
        <div>
            <div class="card">

                <div class="text-center">
                    <h2 class="mb-0">{{ $contact->name }}</h2>

                    @if(can('edit_contacts'))
                        <p><x-a variant="primary" size="sm" href="{{ route('admin.contacts.edit', $contact->id) }}">{{ __('Edit') }}</x-a></p>
                    @endif

                </div>

                <div class="mt-5 text-left">
                    <div class="flex border-b pb-2">
                        <i class="pt-1 pr-1 fa fa-envelope"></i>
                        <div style="width:200px; overflow: scroll">{{ $contact->email }}</div>
                    </div>
                </div>

           </div>
        </div>
    </div>

</div>
