<nav>
    <div class="container">
        <div class="logo">
            <a href="#">
                <img src="{{ Vite::asset('resources/images/link.svg') }}">
                <span class="brand-name">Shortme</span>
            </a>
        </div>
        <div class="bars" id="nav_btn"><i class="far fa-bars"></i></div>
        <ul class="list">
            <li class="login">
                <a href="{{ route('login') }}"><i class="fad fa-sign-in-alt"></i>Login</a>
            </li>
        </ul>
    </div>
</nav>

<div class="theme-switcher light" id="theme-switcher">
    <i class="fas fa-sun"></i>
</div>
