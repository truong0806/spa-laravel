<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="baseUrl" content="{{env('APP_URL')}}" />
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="shortcut icon" class="site_favicon_preview" href="{{ getSingleMedia(imageSession('get'),'favicon',null) }}" />
        
       <!-- Fonts -->
       <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">

        <!-- Styles -->
<link rel="stylesheet" href="{{ secure_asset('css/backend.css') }}">
<link rel="stylesheet" href="{{ secure_asset('css/fronted-custom.css') }}">



    </head>
    <body class=" " >

        <div class="wrapper">
            {{ $slot }}
        </div>
         @include('partials._scripts')
    </body>
</html>
