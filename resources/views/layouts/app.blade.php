<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config("app.name", "Laravel") }}</title>
        <!-- Styles -->

        <link href="{{ asset('css/app.css') }}" rel="stylesheet" />

        <!--Test-->
        @include('components.common.metrika')

        <style type="text/css">
            .ant-menu-item.menu-subitem:nth-child(2) {display:none;}
        </style>
    </head>
    <body>
        <div id="laravel-app">
            @if (Session::get('email_verified'))
            <div style="    text-align: center; padding: 10px 0; background: #f5f5f5;">
                <svg class="svg-icon" width="20" height="20"  style="margin: -5px 7px 0 0;">
                    <path fill="#ed1b24" d="M10.219,1.688c-4.471,0-8.094,3.623-8.094,8.094s3.623,8.094,8.094,8.094s8.094-3.623,8.094-8.094S14.689,1.688,10.219,1.688 M10.219,17.022c-3.994,0-7.242-3.247-7.242-7.241c0-3.994,3.248-7.242,7.242-7.242c3.994,0,7.241,3.248,7.241,7.242C17.46,13.775,14.213,17.022,10.219,17.022 M15.099,7.03c-0.167-0.167-0.438-0.167-0.604,0.002L9.062,12.48l-2.269-2.277c-0.166-0.167-0.437-0.167-0.603,0c-0.166,0.166-0.168,0.437-0.002,0.603l2.573,2.578c0.079,0.08,0.188,0.125,0.3,0.125s0.222-0.045,0.303-0.125l5.736-5.751C15.268,7.466,15.265,7.196,15.099,7.03"></path>
                </svg> {{ __('auth.email-verified') }}
            </div>
            @endif

            @if (Session::get('email_resent'))
            <div style="    text-align: center; padding: 10px 0; background: #f5f5f5;">
                <svg class="svg-icon" width="20" height="20"  style="margin: -5px 7px 0 0;">
                    <path fill="#ed1b24" d="M10.219,1.688c-4.471,0-8.094,3.623-8.094,8.094s3.623,8.094,8.094,8.094s8.094-3.623,8.094-8.094S14.689,1.688,10.219,1.688 M10.219,17.022c-3.994,0-7.242-3.247-7.242-7.241c0-3.994,3.248-7.242,7.242-7.242c3.994,0,7.241,3.248,7.241,7.242C17.46,13.775,14.213,17.022,10.219,17.022 M15.099,7.03c-0.167-0.167-0.438-0.167-0.604,0.002L9.062,12.48l-2.269-2.277c-0.166-0.167-0.437-0.167-0.603,0c-0.166,0.166-0.168,0.437-0.002,0.603l2.573,2.578c0.079,0.08,0.188,0.125,0.3,0.125s0.222-0.045,0.303-0.125l5.736-5.751C15.268,7.466,15.265,7.196,15.099,7.03"></path>
                </svg> {{ __('auth.email_resent') }}
            </div>
            @endif

            <main  id="main-container">
                @yield('content')
            </main>
        </div>

        @stack('javascripts')
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
    </body>
</html>
