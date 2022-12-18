@extends('layouts.app')

@section('content')

    <?php
    $data["breadcrumbs"] = $breadcrumbs;
    $data["csrf"] = csrf_token();
    $data["user"] = Auth::user();
    $data["userCategories"] = $userCategories;
    $data['userResource'] = $userResource;
    $data["userLoyalties"] = $userLoyalties;
    $data["recaptcha"] = config('recaptcha.google-recaptcha-site-key');
    $data["loyaltyId"] = $loyaltyId ?? 0;

    if (!empty( Auth::user() )) {
        $data["user_roles"] = Auth::user()->getRoles();
    }
    ?>

<div id="app">
    {!!  ssr('js/pages/loyality/loyality-server.js')
        ->context('data',$data)
        ->render() !!}
    </div>
@endsection

@push('javascripts')
<script>
        window.__INITIAL_STORE__ = {!! json_encode($data) !!};
    </script>

    <script src="{{ '/js/pages/loyality/App.js' }}"></script>
@endpush


