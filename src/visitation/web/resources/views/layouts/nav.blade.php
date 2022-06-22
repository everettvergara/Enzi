
<div class="sidebar-header">
    {{--  <div class="px-2">
        <img class="text-center" src="{{ asset('images/logo/logo.png') }}" style="width: 100%;">
    </div>  --}}
</div> 

@guest
@else
    <div class="px-2">
        <div class="text-center">
            <img class="text-center" src="{{ asset('images/profiles/' . $auth_user->image_path) }}" style="
                width: 64px;
                border-radius: 50%;
                background-color: #dddddd;
            ">
        </div>
        <div class="mt-2 text-center">
            <span class="text-dark " style="font-size: .8rem">{{ Auth::user()->name }}</span>
        </div>
    </div>
@endguest

<ul class="nav flex-column" id="nav_accordion">
        <!-- Authentication Links -->
        <ul class="list-unstyled components fl-nav">
        
        @foreach ($instructions as $instruction)
            @if ($instruction['dom'] == "ul")
                @if (array_key_exists('class', $instruction) && $instruction['class'] == "first")
                    <ul class="nav flex-column" >    
                @else
                    <ul class="submenu collapse">
                @endif
            @elseif ($instruction['dom'] == "li")
                @if (array_key_exists('class', $instruction))
                        <li class="nav-item has-submenu "><a class="nav-link font-awesome-icons is_accordion" href="#">{{ $instruction['menu_name'] }}</a>
                        
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ isset($instruction['url']) ? route($instruction['url'].'.index'):'#' }}">{{ $instruction['menu_name'] }}</a>
                @endif
            @elseif ($instruction['dom'] == "/li")
                    </li>
            @elseif ($instruction['dom'] == "/ul")
                    </ul>
            @else
                    <div>unsupported tag</div>
            @endif
        @endforeach
        
        @guest
        @if (Route::has('login'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
        @endif

        {{--  @if (Route::has('register'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
        @endif  --}}
    @else
    <li class="nav-item">
        <a class='nav-link' href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </li>
    <li class="nav-item">
        <a class='nav-link' href="{{ route('users.edit', ['user' => Auth::id()]) }}" >
            Account Profile
        </a>
    </li>
    <li class="nav-item">
        <a class='nav-link' href="{{ route('users.edit-pw', ['user' => Auth::id()]) }}" >
            Change Password
        </a>
    </li>

    @endguest
    </ul>
</ul>
