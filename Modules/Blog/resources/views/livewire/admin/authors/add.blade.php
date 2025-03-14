<div>
    <x-modal>
        <x-slot name="trigger">
            <button class="btn btn-primary" @click="on = true">Create Author</button>
        </x-slot>

        <x-slot name="title">Create Author</x-slot>

        <x-slot name="content">

            @include('errors.success')

            <div class="h-60 overflow-scroll">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-form.input wire:model="name" label="Title" name="name" required />
                        <x-form.input wire:model="slug" label="Slug" name="slug" required />
                        <x-form.input wire:model="facebook" label="Facebook" name="facebook" />
                        <x-form.input wire:model="instagram" label="Instagram" name="instagram" />
                         <x-form.input wire:model="twitter" label="Twitter" name="twitter" />
                    </div>
                    <div>
                        <x-form.input wire:model="github" label="Github" name="github" />
                        <x-form.input wire:model="youtube" label="YouTube" name="youtube" />
                        <x-form.input wire:model="linkedin" label="LinkedIn" name="linkedin" />
                        <div>
                            <x-form.input type="file" wire:model="image" label="Image" name="image" />
                            @if ($image)
                                <p>Image Preview:</p>
                                <p><img style="height: 200px;" src="{{ $image->temporaryUrl() }}"></p>
                            @endif
                        </div>
                    </div>
                </div>

                <x-form.textarea wire:model="bio" label="Bio" name="bio" rows="5" />
            </div>

        </x-slot>

        <x-slot name="footer">
            <button @click="on = false">Close</button>
            <button class="btn btn-primary" wire:click="store">Add Author</button>
        </x-slot>
    </x-modal>
</div>
