<nav>
    <div class="container">
        <div class="logo">
            <a href="/">
                <img src="{{ Vite::asset('resources/images/link.svg') }}">
                <span class="brand-name">Shortme</span>
            </a>
        </div>
        <div class="bars" id="nav_btn"><i class="far fa-bars"></i></div>
        <ul class="list">
            @if (Request::is('dashboard*'))
            <x-navitem href="{{ route('dashboard') }}"><i class="fad fas fa-chart-line"></i> Dashboard</x-navitem>
            <x-navitem href="{{ route('dashboard.myurls') }}"><i class="fad fas fa-link"></i> My Urls</x-navitem>
            @else
                @auth
                    <li class="login">
                        <a href="{{ route('dashboard') }}"><i class="fad fas fa-chart-line"></i> Dashboard</a>
                    </li>
                @else
                    <li class="login">
                        <a href="{{ route('login') }}"><i class="fad fa-sign-in-alt"></i> Login</a>
                    </li>
                @endauth
            @endif
        </ul>
    </div>
</nav>

<div class="theme-switcher light" id="theme-switcher">
    <i class="fas fa-sun"></i>
</div>
