<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
<title>{{env('APP_NAME')}}</title>
<link rel="shortcut icon" class="favicon_preview" href="{{ getSingleMedia(imageSession('get'),'favicon',null) }}" />

<link rel="stylesheet" href="{{ secure_asset('css/swiper-bundle.min.css') }}">
<link rel="stylesheet" href="{{ secure_asset('css/landing-page.min.css') }}">
<link rel="stylesheet" href="{{ secure_asset('css/landing-page-rtl.min.css') }}">
<link rel="stylesheet" href="{{ secure_asset('css/landing-page.min.css') }}">
<link rel="stylesheet" href="{{ secure_asset('css/landing-page-custom.min.css') }}">
<link rel="stylesheet" href="{{ secure_asset('vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
<link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="assert_url" content="{{ URL::to('') }}" />

<meta name="baseUrl" content="{{env('APP_URL')}}" />
@php
        $currentLang = app()->getLocale();
        $langFolderPath = resource_path("lang/$currentLang");
        $filePaths = \File::files($langFolderPath);
    @endphp

    @foreach ($filePaths as $filePath)
        @php
            $fileName = pathinfo($filePath, PATHINFO_FILENAME);
        @endphp
        <script>
            window.localMessagesUpdate = {
                ...window.localMessagesUpdate,
                "{{ $fileName }}": @json(require($filePath))
            };
        </script>
    @endforeach





