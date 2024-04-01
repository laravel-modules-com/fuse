@section('title', __('System Settings'))
<div>
    <h1>{{ __('System Settings') }}</h1>

    <livewire:settings::admin.application-settings/>
    <livewire:settings::admin.security-settings/>
</div>
