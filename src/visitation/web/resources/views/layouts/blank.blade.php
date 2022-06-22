<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>"{{ env('SITE_NAME') }}"</title>
    <!-- Scripts -->
    {{--  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>  --}}
    <script src="{{ asset('js/bootstrap_5_0_1.bundle.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/errors.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" media="all">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ url('css/reset.css') }}" media="all">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" media="all">
    {{--  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous" media="all">  --}}
    <link href="{{ asset('css/bootstrap_5_0_1.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" media="all" />
    
    <link rel="stylesheet" type="text/css" href="{{ url('css/default.css') }}" media="all">
    <link rel="stylesheet" type="text/css" href="{{ url('css/nav.css') }}" media="all">
    <link rel="stylesheet" type="text/css" href="{{ url('css/header.css') }}" media="all">
    <link rel="stylesheet" type="text/css" href="{{ url('css/body.css') }}" media="all">
    <link rel="stylesheet" type="text/css" href="{{ url('css/footer.css') }}" media="all">

    @yield('head')
</head>
<body>
    <div id="app" class="vh-100">
        <main class="d-flex flex-row h-100 fl-wrapper">
            <div class="content">
                @yield('content')
            </div> 
        </main>
    </div>
</body>