@extends('layouts.app')

    <?php
    $product["breadcrumbs"] = $breadcrumbs;
    $product["user"] = Auth::user();
    $product['userResource'] = $userResource;
    $product["csrf"] = csrf_token();
    $data["recaptcha"] = config('recaptcha.google-recaptcha-site-key');

    if (!empty( Auth::user() )) {
        $product["user_roles"] = Auth::user()->getRoles();
    }
    ?>
@section('content')
    <div id="app">
        {!! ssr('js/pages/product/product-server.js')
        ->context('product', $product)
        ->render() !!}
    </div>
@endsection

@push('javascripts')
<script>
    window.__USER__ =  {!! json_encode(Auth::user()) !!};
        window.__INITIAL_STORE__ = {!! json_encode($product) !!};
    </script>

    <script src="{{ '../../js/pages/product/App.js' }}"></script>
@endpush
