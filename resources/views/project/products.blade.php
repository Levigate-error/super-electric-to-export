@extends('layouts.app')

@section('content')

    <?php
    $data["project"] = $project;
    $data["projectCategories"] = $projectCategories;
    $data["breadcrumbs"] = $breadcrumbs;
    $data["csrf"] = csrf_token();
    $data['userResource'] = $userResource;
    $data["recaptcha"] = config('recaptcha.google-recaptcha-site-key');

    $data["user"] = Auth::user();
    if (!empty( Auth::user() )) {
        $data["user_roles"] = Auth::user()->getRoles();
    }
    ?>

    <div id="app">
    {!!  ssr('js/pages/project-products/project-products-server.js')
        ->context('data', $data)
        ->render() !!}
    </div>
@endsection

@push('javascripts')
<script>
        window.__INITIAL_STORE__ = {!! json_encode($data) !!};
    </script>

    <script src="{{ '/js/pages/project-products/App.js' }}"></script>
@endpush
