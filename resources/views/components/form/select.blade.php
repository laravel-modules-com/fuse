@props([
    'data' => [],
    'required' => '',
    'name' => '',
    'id' => '',
    'placeholder' => '',
    'label' => ''
])

@if ($label === 'none')

@elseif ($label === '')
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

<div class="mb-5">
    @if ($label !='none')
        <label for='{{ $name }}' class='block mb-2 font-bold text-sm mb-2 text-gray-600 dark:text-gray-200'>{{ $label }} @if ($required != '') <span aria-hidden="true" class="error">*</span>@endif</label>
    @endif
    <select
        name='{{ $name }}'
        id='{{ $name }}'
        {{ $required }}
        {{ $attributes->merge([
            'class' => implode(' ', [
                'dark:bg-gray-500 dark:text-gray-200 p-1 w-full rounded-md
                py-2 px-3
                sm:text-sm
                border
                focus:outline-none focus:border-blue-500',
                $errors->has($name) ? 'border-red-500' : 'border-gray-300',
            ])
        ]) }}
        @if(isset($errors))
            @error($name)
                aria-invalid="true"
                aria-description="{{ $message }}"
            @enderror
        @endif
        {{ $attributes }}
    >
        @if ($placeholder != '')
           <option value=''>{{ $placeholder }}</option>
        @endif
        @if (count($data) > 0)
            @foreach($data as $key => $value)
                <option value='{{ $key }}' @if ($key == $slot) selected @endif>{{ $value }}</option>
            @endforeach
        @endif
        {{ $slot }}
    </select>
    @error($name)
        <p class="text-red-500 dark:text-red-300" aria-live="assertive">{{ $message }}</p>
    @enderror
</div>
