<div>
    <x-modal>
        <x-slot name="trigger">
            <button class="btn btn-primary" @click="on = true">Create Category</button>
        </x-slot>

        <x-slot name="title">Create Category</x-slot>

        <x-slot name="content">

            @include('errors.success')

            <x-form.input wire:model="title" label="Title" name="title" required />

            <x-form.select label="Parent Category" wire:model="parentId" name="parentId">
                <option>None</option>
                @foreach($categories as $category)
                    <x-form.select-option-row :data="$category" />
                @endforeach
            </x-form.select>

        </x-slot>

        <x-slot name="footer">
            <button @click="on = false">Close</button>
            <button class="btn btn-primary" wire:click="store">Add Category</button>
        </x-slot>
    </x-modal>
</div>
