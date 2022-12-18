@extends('layouts.app')

@section('content')


<?php
 
    $data['userResource'] = $userResource;
    $data['news'] = $news;
    $data["recaptcha"] = config('recaptcha.google-recaptcha-site-key');
    $data["breadcrumbs"] = $breadcrumbs;
    $data["csrf"] = csrf_token();

    ?>

    <div id="app">
    {!! ssr('js/pages/news-list/news-list-server.js')
        ->context('data', $data) 
        ->render() !!}    </div>
@endsection

@push('javascripts')
<script>
        window.__INITIAL_STORE__ = {!! json_encode($data) !!};
       
    </script>

    <script src="{{ 'js/pages/news-list/App.js' }}"></script>
@endpush


