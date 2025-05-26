<div>
    <div class="flex justify-between">
        <p>
            <x-a href="{{ route('admin.{module-}.index') }}">{{ __('{Model }') }}</x-a>
            <span class="dark:text-gray-200">- {{ __('Update {Model }') }}</span>
        </p>
    </div>

    <div class="card">
        <div class="flex justify-between">
            <h2 class="mb-5">{{ __('Update {Model }') }}</h2>
            <div>
                <span class="error">*</span>
                <span class="dark:text-gray-200"> = {{ __('required') }}</span>
            </div>
        </div>

        <x-form wire:submit="update">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-form.input wire:model="name" :label="__('Name')" name='name' required />
                <x-form.input wire:model="email" :label="__('Email')" name='email' required />
            </div>

            <x-button class="mt-5">{{ __('Update {Model }') }}</x-button>

            @include('errors.messages')
        </x-form>
    </div>
</div>
