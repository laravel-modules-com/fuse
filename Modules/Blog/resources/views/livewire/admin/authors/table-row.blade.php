<tr>
    <td>{{ $author->name }}</td>
    <td>{{ $author->posts->count() }}</td>
    <td>
        {{ $author->updated_at->format('jS M Y') }}<br>
        {{ $author->updated_at->format('H:i A') }}
    </td>
    <td>
        {{ $author->created_at->format('jS M Y') }}<br>
        {{ $author->created_at->format('H:i A') }}
    </td>
    <td>
        <div class="flex space-x-2">
            @if(can('edit_blog_authors'))
                <livewire:blog::admin.authors.edit-author :author="$author" :wire:key="$author->id" />
            @endif

            @if(can('delete_blog_authors'))
                <x-modal>
                    <x-slot name="trigger">
                        <a href="#" @click="on = true">Delete</a>
                    </x-slot>

                    <x-slot name="title">Confirm Delete</x-slot>

                    <x-slot name="content">
                        <div class="text-center">
                            Are you sure you want to delete: <b>{{ $author->name }}</b>
                        </div>
                    </x-slot>

                    <x-slot name="footer">
                        <button @click="on = false">Cancel</button>
                        <button class="btn btn-red" wire:click="deleteAuthor('{{ $author->id }}')">Delete Author</button>
                    </x-slot>
                </x-modal>
            @endif
        </div>
    </td>
</tr>