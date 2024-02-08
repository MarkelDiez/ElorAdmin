<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ElorChat') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <style>

    </style>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="theme-light">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="logo-container">
            <a href="{{ url('/home') }}">
                <img src="{{ asset('images/logo_elorrieta.png') }}" alt="Logo de la página" class="logo_elorrieta">
            </a>
        </div>
        <div class="container">

            @if (Auth::user() != null && Auth::user()->hasRole('Administrador'))
            <a class="navbar-brand" href="/admin">{{__('AdminPannel')}}</a>
            @endif
            <!-- <a class="navbar-brand" href="{{ url('/admin') }}">{{ config('app.name', 'Laravel') }}
                    </a> -->



            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->

                <!-- Right Side Of Navbar -->

                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                    @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Inicio de sesión') }}</a>
                    </li>
                    @endif
                    @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                {{ __('Cerrar sesión') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>

                    @endguest
                </ul>
            </div>
        </div>
        <div class="menu">
            <button class="btn dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="true">
                <i class="bi bi-gear-fill"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li class="dropdown-item dropdown-toggle dropdown-start">
                    {{__('Language')}}
                    <ul class="dropdown-menu dropdown-submenu dropdown-submenu-left">
                        <li class="dropdown-item"><a href="{{ route('cambiar-idioma', 'eu') }}">Euskera</a></li>
                        <li class="dropdown-item"><a href="{{ route('cambiar-idioma', 'en') }}">Inglés</a></li>
                        <li class="dropdown-item"><a href="{{ route('cambiar-idioma', 'es') }}">Castellano</a></li>
                    </ul>
                </li>

                <li class="dropdown-item dropdown-toggle dropdown-start">
                    {{__('Theme')}}
                    <ul class="dropdown-menu dropdown-submenu dropdown-submenu-left">
                        <li data-i18n="light" class="dropdown-item" onclick="cambiarTema('light')">{{__('Light')}}</li>
                        <li data-i18n="dark" class="dropdown-item" onclick="cambiarTema('dark')">{{__('Dark')}}</li>
                    </ul>
                </li>
                @auth
                <li class="dropdown-item"><a href="{{ route('change.password.form') }}">Cambiar Contraseña</a></li><li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button data-i18n="logout" type="submit" class="dropdown-item">{{__('Logout')}}</button>
                    </form>
                </li>
                @endauth
            </ul>
        </div>

    </nav>
    <div class="app">
        <main class="">
            <div class="row ">
                @yield('content')
            </div>  
        
            <div class="app2">
                @yield('login')
            </div>
        </main>
    </div>
    </div>
    <script src="{{ asset('js/script_menu.js') }}"></script>
    <footer class="d-flex flex-wrap justify-content-center align-items-center py-3 my-4 border-top">
        <p class="col-md-4 mb-0 text-body-secondary ">© 2023 Elorrieta-Errekamari</p>

        <a href="https://www.elorrieta.eus/"><img src="{{ asset('images/title_elorrieta.png') }}"
                alt="Titulo de la empresa" class="title_elorrieta"></a>


    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
<script>
     regar evento de clic a los elementos de cambio de idioma
    d    querySelectorAll('.dropdown-menu .dropdown-item').forEach(item => {
        i        Listener('click', event => {
            c            guage = event.target.innerText;
            // Aq    ir la lógica para cambiar el idioma

        });
    });
</script>
<script>
    // Función parabe    unction cambiarTema(tipoTema) {
    document.documentElement.classList.remove('theme-dark', 'theme-light');
        if (tipoTema === 'dark') {
            document.documentElement.classList.add('theme-dark');
        } else if (tipoTema === 'light') {
            document.documentElement.classList.add('theme-light');
        }
        // Aquí también puedes guardar la preferencia del usuario en localStorage o cookies.
    }
</script>
<script>
    document.addEventListener('od    , function () {
        var languageItems = document.q ueryS        torAll('.change-language');

        languageItems.forEach(function         m) {
            item.addEvent Listener(             function () {
                var lang  = th                ute('data-lang');
                cambiarId                            });
                 
           
</script>