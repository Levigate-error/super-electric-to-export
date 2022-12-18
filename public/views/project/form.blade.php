@extends('layouts.app')


@section('content')
<?php
            // dd($project);
            $data = isset($project) ? [
                "attributes" => $attributes,
                "statuses" => $statuses,
                "project" => $project,
                'breadcrumbs' => $breadcrumbs,
                ] : [
                "attributes" => $attributes,
                "statuses" => $statuses,
                'breadcrumbs' => $breadcrumbs,
                ];
                $data["recaptcha"] = config('recaptcha.google-recaptcha-site-key');

            $data["csrf"] = csrf_token();
            $data['userResource'] = $userResource;

            $data["user"] = Auth::user();
            if (!empty( Auth::user() )) {
                $data["user_roles"] = Auth::user()->getRoles();
            }
        ?>
    <div id="app">
        {!! ssr('js/pages/project-form/project-form-server.js')
        ->context('data', $data)
        ->render() !!}

    </div>
@endsection

<!-- $project --------  Если есть то редактирование  -->

@push('javascripts')
    <script>
        window.__INITIAL_STORE__ = {!! json_encode($data) !!};
    </script>

    <script src="{{ '/js/pages/project-form/App.js' }}"></script>
@endpush