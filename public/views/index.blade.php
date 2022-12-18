@extends('layouts.app')

    <?php
    $data["user"] = Auth::user();
    $data['userResource'] = $userResource;
    $data["csrf"] = csrf_token();
    $data["recaptcha"] = config('recaptcha.google-recaptcha-site-key');
    if (!empty( Auth::user() )) {
        $data["user_roles"] = Auth::user()->getRoles();
    }
    ?>

@section('content')
    <div id="app">
        {!! ssr('js/pages/home/home-server.js')
        ->context('data', $data)
        ->render() !!}
    </div>
@endsection

@push('javascripts')
    <script>
        window.__INITIAL_STORE__ = {!! json_encode($data) !!};
    </script>

    <script src="{{ 'js/pages/home/App.js' }}"></script>
@endpush
