<script src="{{ url('js/ckeditor5.js') }}"></script>

@props([
    'name' => '',
    'label' => '',
    'required' => false,
    'livewire' => false,
])

@if ($label == '')
    @php
        //remove underscores from name
        $label = str_replace('_', ' ', $name);
        //detect subsequent letters starting with a capital
        $label = preg_split('/(?=[A-Z])/', $label);
        //display capital words with a space
        $label = implode(' ', $label);
        //uppercase first letter and lower the rest of a word
        $label = ucwords(strtolower($label));
    @endphp
@endif
<div wire:ignore class="my-5">
    @if ($label !='none')
        <x-form.label :$label :$required :$name />
    @endif
    <textarea
        x-data
        x-init="
            ClassicEditor
                .create($refs.item, {
                simpleUpload: {
                    uploadUrl: '{{ url('admin/image-upload') }}'
                }
                })
                .then(editor => {
                    @if($livewire)
                        editor.model.document.on('change:data', () => {
                            @this.set('{{ $name }}', editor.getData());
                        });
                    @endif
                })
                .catch(error => {
                    console.error(error);
                });
        "
        x-ref="item"
        {{ $attributes }}
    >
        {{ $slot }}
    </textarea>
</div>
@error($name)
    <p class="text-red-500 dark:text-red-300" aria-live="assertive">{{ $message }}</p>
@enderror
