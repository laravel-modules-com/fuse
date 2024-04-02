@props([
    'level'    => 0,
    'data'     => null,
    'wireName' => null,
    'id'       => 'id',
    'label'    => 'title'
])

<label class="block cursor-pointer">
    <div class="flex gap-2">
    <input
        type="checkbox"
        class="module-checkbox"
        wire:model="{{ $wireName.'.'.$data->$id }}"
        value="{{ $data->$id }}"
    >
        @if ($level > 0) {!! str_repeat("&nbsp;&nbsp;", $level) !!} @endif
        {{ $data->$label }}
    </div>
</label>

@foreach ($data->children as $child)
    <x-form.checkbox-row :data="$child" :level="$level+1" :id="$id" :label="$label" :wireName="$wireName"/>
@endforeach
