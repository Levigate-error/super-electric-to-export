@component('mail::message')
    @slot('title')
        @component('mail::title', ['title' => $title])
        @endcomponent
    @endslot

    @component('mail::content', [
        'subTitle' => $subTitle,
        'text' => $text,
        'buttonUrl' => $buttonUrl,
        'buttonTitle' => $buttonTitle,
    ])
    @endcomponent
@endcomponent
