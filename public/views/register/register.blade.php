@extends('layouts.app')

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
