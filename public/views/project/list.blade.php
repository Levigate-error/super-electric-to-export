@extends('layouts.app')

@section('content')

    <?php
    $data["breadcrumbs"] = $breadcrumbs;
    $data["projects"] = $projects;
    $data["statuses"] = $statuses;
    $data["csrf"] = csrf_token();
    $data['userResource'] = $userResource;
    $data["recaptcha"] = config('recaptcha.google-recaptcha-site-key');

    $data["user"] = Auth::user();
    if (!empty( Auth::user() )) {
        $data["user_roles"] = Auth::user()->getRoles();
    }
    ?>

    <div id="app">
        {!! ssr('js/pages/projects-list/list-server.js')
        ->context('data', $data)
        ->render() !!}

        

    </div>
@endsection

@push('javascripts')
    <script>
        window.__INITIAL_STORE__ = {!! json_encode($data) !!};
    </script>

    <script src="{{ '/js/pages/projects-list/App.js' }}"></script>
@endpush


