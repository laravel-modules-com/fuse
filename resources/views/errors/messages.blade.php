@foreach (session('flash_notification', collect())->toArray() as $message)
    @if($message['level'] === 'danger' || $message['level'] === 'info')
        <div class="alert alert-{{ $message['level'] }}" role="alert">
            {!! $message['message'] !!}
        </div>
    @else
        <div x-data="{ show: true }"
             x-show="show"
             x-transition
             x-init="setTimeout(() => show = false, 2000)"
             class="alert alert-{{ $message['level'] }}"
             role="alert"
        >
            {!! $message['message'] !!}
        </div>
    @endif
@endforeach

@if (session('message'))
    <div>
        {{ session('message') }}
    </div>
@endif

@session('success')
    <div class="alert alert-green">
        {{ $value }}
    </div>
@endsession

@session('status')
    <div class="alert alert-yellow">
        {{ $value }}
    </div>
@endsession
