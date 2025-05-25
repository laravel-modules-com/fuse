
@php
    $navigationManager = app(\App\Services\NavigationManager::class);
@endphp

@foreach($navigationManager->getSections() as $section)
    @if(strpos($section, 'navigation.') === 0 && $navigationManager->hasItems($section))
        @php
            $sectionTitle = str_replace('navigation.', '', $section);
            $sectionTitle = ucwords(str_replace('.', ' ', $sectionTitle));
        @endphp

        <x-nav.divider>{{ __($sectionTitle) }}</x-nav.divider>

        @foreach($navigationManager->getItems($section) as $item)
            @if(empty($item['permission']) || auth()->user()->can($item['permission']))
                <x-nav.link route="{{ $item['route'] }}" icon="{{ $item['icon'] }}">
                    {{ __($item['title']) }}
                </x-nav.link>
            @endif
        @endforeach
    @endif
@endforeach
