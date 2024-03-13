<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <!--begin::Fonts-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
        <!--end::Fonts-->

        <!--begin::Global Theme Styles(used by all pages)-->
        <link href="{{ asset('metronic/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('metronic/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('metronic/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
        <!--end::Global Theme Styles-->

        <!--begin::Layout Themes(used by all pages)-->
        <link href="{{ asset('metronic/css/themes/layout/header/base/light.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('metronic/css/themes/layout/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('metronic/css/themes/layout/brand/dark.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('metronic/css/themes/layout/aside/dark.css') }}" rel="stylesheet" type="text/css" />
        <!--end::Layout Themes-->

        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />

        <link rel="shortcut icon" href="{{ asset('metronic/media/logos/favicon.ico') }}" />
    </head>
    <body class="font-sans antialiased bg-light">
        {{ $slot }}
    </body>
</html>
