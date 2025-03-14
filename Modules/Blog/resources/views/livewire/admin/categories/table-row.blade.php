<tr>
    <td>
        {{ $category->title }}
    </td>
    <td>
        {{ $category->updated_at->format('jS M Y') }}<br>
        {{ $category->updated_at->format('H:i A') }}
    </td>
    <td>
        {{ $category->created_at->format('jS M Y') }}<br>
        {{ $category->created_at->format('H:i A') }}
    </td>
    <td>
        <div class="flex space-x-2">
            @if(can('edit_blog_categories'))
                <livewire:blog::admin.categories.edit-category :category="$category" :wire:key="$category->id" />
            @endif

            @if(can('delete_blog_categories'))
                <x-modal>
                    <x-slot name="trigger">
                        <a href="#" @click="on = true">Delete</a>
                    </x-slot>

                    <x-slot name="title">Confirm Delete</x-slot>

                    <x-slot name="content">
                        <div class="text-center">
                            Are you sure you want to delete: <b>{{ $category->title }}</b>
                        </div>
                    </x-slot>

                    <x-slot name="footer">
                        <button @click="on = false">Cancel</button>
                        <button class="btn btn-red" wire:click="deleteCategory('{{ $category->id }}')">Delete Category</button>
                    </x-slot>
                </x-modal>
            @endif
        </div>
    </td>
</tr>