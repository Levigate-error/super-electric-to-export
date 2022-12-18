@extends('layouts.app')

@php
    $data["breadcrumbs"] = $breadcrumbs;
    $data["csrf"] = csrf_token();
    $data["user"] = Auth::user();
    $data["userCategories"] = $userCategories;
    $data['userResource'] = $userResource;
    $data["userLoyalties"] = $userLoyalties;
    $data["recaptcha"] = config('recaptcha.google-recaptcha-site-key');
    if (!empty( Auth::user() )) {
        $data["user_roles"] = Auth::user()->getRoles();
    }
@endphp

@section('content')
<div id="app">
    {!!  ssr('js/pages/inspiria/inspiria-server.js')
        ->context('data',$data)
        ->render() !!}
    </div>
@endsection

@push('javascripts')
    <script>
        window.__INITIAL_STORE__ = {!! json_encode($data) !!};
    </script>

    <script src="{{ '/js/pages/inspiria/App.js' }}"></script>
@endpush


