<header>
    <div class="container">
        @if (Route::has('login'))
        <nav aria-label="Navegación Principal">
            <a href="{{ route('home') }}" class="logo logo-image-container">
                <img src="{{ asset('images/corpo-logo.jpg') }}" alt="Logo CORPO" class="site-logo">
            </a>

            <ul class="nav-links">
               {{--   <li><a href="{{ route('home') }}">Inicio</a></li>
                <li><a href="{{ route('classes') }}">Clases</a></li>
                <li><a href="{{ route('schedules') }}">Horarios</a></li>
                <li><a href="{{ route('prices') }}">Tarifas</a></li>
                <li><a href="{{ route('contact') }}">Contacto</a></li> --}}
                <!--li class="nav-login"><a href="{{ route('login') }}">Login</a></li-->
            </ul>


            {{-- <a href="{{ route('trial') }}" class="cta-button hide-on-mobile-nav">¡Prueba Gratis!</a> --}}

            <button class="menu-toggle" aria-controls="nav-links" aria-expanded="false">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>
           @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                    @else
                        <a 
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth


        </nav>
       @endif


    </div>
</header>
