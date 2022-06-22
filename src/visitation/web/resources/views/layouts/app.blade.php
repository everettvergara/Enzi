<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>{{ env('SITE_NAME') }}</title>
    <!-- Scripts -->
   {{--  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>  --}}
   <script src="{{ asset('js/bootstrap_5_0_1.bundle.min.js') }}" ></script> 
   <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/alerts.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ url('css/reset.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{--  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">  --}}
    <link href="{{ asset('css/bootstrap_5_0_1.min.css') }}" rel="stylesheet" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    @yield('head')
    <link rel="stylesheet" type="text/css" href="{{ url('css/default.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/nav.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/header.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/body.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/footer.css') }}">
    
</head>
<body>
    <div id="app" class="vh-100">
            <main class="d-flex flex-row h-100 fl-wrapper">
                <nav id="test" class="sidebar shadow ">
                    @nav
                    @endnav
                </nav>
                <div class="content">
                    <nav class="navbar navbar-expand-md navbar-white bg-secondary">
                        <div class="d-flex">
                            <button id="sidebarCollapse" class="navbar-toggler d-inline" type="button" aria-label="Toggle navigation">
                                <i class="fa-solid fa-bars text-white"></i>
                            </button>
                            <span class="navbar-brand ml-3 text-white">
                                @yield('title', 'DASHBOARD') 
                            </span>
                        </div>
                    </nav>
                    <div class="pt-4 ml-3 mr-3">
                        @switch(true)
                            @case(session()->has('status'))
                                @alerts([
                                    'show' => 'show',
                                ])
                                {{ session()->get('status') }}
                                @endalerts
                                @break
                            @case(session()->has('alert'))
                                @alerts([
                                    'show' => 'show',
                                    'type' => 'danger',
                                ])
                                {{ session()->get('alert') }}
                                @endalerts
                                @break
                            @case($errors->any())
                                @errors
                                @enderrors
                                @break
                            @default
                        @endswitch
                        
                        @yield('content')
                    </div>
                </div> 
            </main>
    </div>
</body>
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function(){
  document.querySelectorAll('.sidebar .nav-link').forEach(function(element){
    element.addEventListener('click', function (e) {
      let nextEl = element.nextElementSibling;
      let parentEl  = element.parentElement;	
        if(nextEl) {
            e.preventDefault();	
            let mycollapse = new bootstrap.Collapse(nextEl);
            if(nextEl.classList.contains('show')){
              mycollapse.hide();
            } else {
                mycollapse.show();
                // find other submenus with class=show
                var opened_submenu = parentEl.parentElement.querySelector('.submenu.show');
                // if it exists, then close all of them
                if(opened_submenu){
                  new bootstrap.Collapse(opened_submenu);
                }
            }
        }
    }); // addEventListener
  }) // forEach
}); 
// DOMContentLoaded  end
</script>

@yield('scripts')
</html>
