
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Komdigital | Build. Market. Grow.')</title>

    <meta name="description"
          content="@yield('description', 'Digital services and professional training by Komdigital.')">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    >

    @stack('styles')
</head>

<body>

    <header>
        <div class="container navbar">

            <a href="{{ route('home') }}" class="logo">
                KOMDIGITAL
            </a>

          
            <button
                class="menu-toggle"
                id="menuToggle"
                type="button"
                aria-label="Open navigation menu"
                aria-expanded="false"
                aria-controls="mainNav"
            >
                <span></span>
                <span></span>
                <span></span>
            </button>



            <nav id="mainNav">

                <a href="{{ route('home') }}"
                class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    Home
                </a>

                <a href="{{ route('home') }}#services">
                    What We Do
                </a>

                <a href="{{ route('courses') }}"
                class="{{ request()->routeIs('courses') ? 'active' : '' }}">
                    Courses
                </a>

                <a href="{{ route('home') }}#contact">
                    Contact
                </a>

                <a href="{{ route('register') }}" class="nav-cta">
                    Get Started
                </a>

                @auth
                    @if (auth()->user()->role === 'admin')

                        <a href="{{ route('admin.dashboard') }}"
                        class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            Dashboard
                        </a>

                        <a href="{{ route('admin.registrations.index', ['status' => 'pending']) }}"
                        class="{{ request()->routeIs('admin.registrations.*') ? 'active' : '' }}">

                            Registrations

                            @if ($pendingRegistrationsCount > 0)
                                <span class="pending-badge">
                                    {{ $pendingRegistrationsCount }}
                                </span>
                            @endif

                        </a>

                        <a href="{{ route('admin.contact-messages.index') }}"
                        class="{{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}">

                            Contact Messages

                            @if ($unreadContactMessagesCount > 0)
                                <span class="unread-badge">
                                    {{ $unreadContactMessagesCount }}
                                </span>
                            @endif

                        </a>

                        <!-- <a href="{{ route('admin.categories.index') }}"
                        class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            Categories
                        </a> -->

                        <form method="POST" action="{{ route('logout') }}" class="nav-logout-form">
                            @csrf
                            <button type="submit" class="nav-logout">
                                Logout
                            </button>
                        </form>

                    @endif
                @endauth

            </nav>




        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <button
        type="button"
        id="scrollTop"
        class="scroll-top"
        aria-label="Scroll to top"
        title="Back to top"
    >
        ↑
    </button>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} Komdigital. All rights reserved.</p>
            <p>Build. Market. Grow.</p>
        </div>
    </footer>


    <script>
    document.addEventListener('DOMContentLoaded', function () {

        // MOBILE NAVIGATION
        const menuToggle = document.getElementById('menuToggle');
        const mainNav = document.getElementById('mainNav');

        menuToggle.addEventListener('click', function () {

            mainNav.classList.toggle('show');

            const isOpen = mainNav.classList.contains('show');

            menuToggle.setAttribute('aria-expanded', isOpen);

            menuToggle.setAttribute(
                'aria-label',
                isOpen ? 'Close navigation menu' : 'Open navigation menu'
            );

        });

        // CLOSE MOBILE MENU AFTER CLICKING A LINK
        mainNav.querySelectorAll('a').forEach(function (link) {

            link.addEventListener('click', function () {

                mainNav.classList.remove('show');

                menuToggle.setAttribute('aria-expanded', 'false');

                menuToggle.setAttribute(
                    'aria-label',
                    'Open navigation menu'
                );

            });

        });


        // SCROLL TO TOP
        const scrollTop = document.getElementById('scrollTop');

        window.addEventListener('scroll', function () {

            if (window.scrollY > 300) {
                scrollTop.classList.add('show');
            } else {
                scrollTop.classList.remove('show');
            }

        });

        // SCROLL BACK TO TOP WHEN BUTTON IS CLICKED
        scrollTop.addEventListener('click', function () {

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });

        });

    });
    </script>

    @stack('scripts')
</body>
</html>
