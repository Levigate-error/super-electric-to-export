@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url'), 'title' => $title])
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}
@endcomponent
