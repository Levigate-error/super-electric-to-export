@extends('layouts.app')

@section('content')

    <?php
    $data["breadcrumbs"] = $breadcrumbs;
    $data["user"] = Auth::user();
    $data['userResource'] = $userResource;
    $data["csrf"] = csrf_token();
    $data["recaptcha"] = config('recaptcha.google-recaptcha-site-key');

    if (!empty( Auth::user() )) {
        $data["user_roles"] = Auth::user()->getRoles();
    }
    ?>

    <div id="app">
        {!! ssr('js/pages/catalog/catalog-server.js')
        ->context('data', $data)
        ->render() !!}
    </div>
@endsection

@push('javascripts')
    <script>
        window.__USER__ =  {!! json_encode(Auth::user()) !!};
        window.__INITIAL_STORE__ = {!! json_encode($data) !!};
       
    </script>

    <script src="{{ 'js/pages/catalog/App.js' }}"></script>
@endpush
