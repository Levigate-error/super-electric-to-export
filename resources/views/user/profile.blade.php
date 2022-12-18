@extends('layouts.app')

@section('content')

    <?php
    $data["breadcrumbs"] = $breadcrumbs;
    $data["csrf"] = csrf_token();
    $data["user"] = Auth::user();
    $data["userResource"] = $userResource;
    $data["recaptcha"] = config('recaptcha.google-recaptcha-site-key');

    if (!empty( Auth::user() )) {
        $data["user_roles"] = Auth::user()->getRoles();
    }
    ?>

<div id="app">
    {!!  ssr('js/pages/profile/profile-server.js')
        ->context('data',$data)
        ->render() !!}
    </div>
@endsection

@push('javascripts')
<script>
        window.__INITIAL_STORE__ = {!! json_encode($data) !!};
    </script>

    <script src="{{ '/js/pages/profile/App.js' }}"></script>
@endpush