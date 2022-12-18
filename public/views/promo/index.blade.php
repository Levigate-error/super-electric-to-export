@extends('layouts.app')

@section('content')

<div id="app">

    {!!  ssr('js/pages/promo/promo-server.js')
        ->context('data',$data)
        ->render() !!}
    </div>
@endsection

@push('javascripts')
<script>
        window.__INITIAL_STORE__ = {!! $data !!};
    </script>

    <script src="{{ '/js/pages/promo/App.js' }}"></script>
@endpush


