<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>@yield('title', 'Pro-talk | Let`s Talk Nutrition')</title>
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />
        {{-- icon not work thats why cdn add --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
            rel="stylesheet" />

        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        @stack('styles')
    </head>

    <body>

        <!-- NAVBAR -->
        <nav id="mainNavbar" class="navbar navbar-expand-lg fixed-top">
            <div class="d-flex align-items-center justify-content-between w-100">

                <!-- Logo -->
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img class="img-fluid nav-logo" src="{{ asset('assets/images/VPCI.png') }}" width="100">
                </a>

                <!-- Toggle Button -->
                <button type="button" class="navbar-toggler" data-bs-toggle="offcanvas"
                    data-bs-target="#mobileSidebar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Desktop Menu -->
                <div class="navbar-collapse d-none d-lg-flex collapse">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" @class(['nav-link', 'active' => request()->routeIs('home')])>
                                Home
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('about-us') }}" @class(['nav-link', 'active' => request()->routeIs('about-us')])>
                                About Us
                            </a>
                        </li>
                        @auth('web')
                            <li class="nav-item">
                                <a href="{{ route('live-session') }}" @class(['nav-link', 'active' => request()->routeIs('live-session')])>
                                    <i class="fa fa-broadcast-tower me-2" style="color:var(--primaryThemeColor)"></i>Live
                                    Session
                                </a>
                            </li>
                        @endauth
                    </ul>

                    <div class="d-flex align-items-center gap-2">
                        @guest
                            <a class="btn btn-login" href="{{ route('login') }}">Log In</a>
                            <a class="btn btn-register" href="{{ route('register') }}">Register</a>
                        @endguest
                        @auth
                            <a id="btnLogout" class="btn btn-logout" href="{{ route('logout') }}">
                                <i class="fa fa-right-from-bracket me-1"></i>Logout
                            </a>
                        @endauth
                    </div>
                </div>

            </div>
        </nav>

        <!-- MOBILE SIDEBAR -->
        <div id="mobileSidebar" class="offcanvas offcanvas-end" tabindex="-1">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">
                    <img class="img-fluid nav-logo" src="{{ asset('assets/images/logo.svg') }}" width="150">
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>

            <div class="offcanvas-body">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" @class(['nav-link', 'active' => request()->routeIs('home')])>
                            Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('about-us') }}" @class(['nav-link', 'active' => request()->routeIs('about-us')])>
                            About Us
                        </a>
                    </li>
                </ul>

                <div class="d-flex flex-column mt-3 gap-2">
                    <a class="btn btn-login" href="{{ route('login') }}">Log In</a>
                    <a class="btn btn-register" href="{{ route('register') }}">Register</a>
                    <a id="btnLogout" class="btn btn-logout d-none" href="{{ route('logout') }}">
                        <i class="fa fa-right-from-bracket me-1"></i>Logout
                    </a>
                </div>
            </div>
        </div>

        <section class="main_section">
            <div id="floatingAlert" class="floating-alert d-none"></div>
            @yield('main')
        </section>

        <!-- FOOTER -->
        <footer>

            <!-- SECTION 1 -->
            <div class="footer-top align-content-center">
                <div class="container">
                    <div class="row g-4 justify-content-center">

                        <div class="col-xl-6 col-lg-6 col-sm-6">
                            <div class="footer-brand-box">
                                <img src="{{ asset('assets/images/footer.png') }}" width="150" />
                            </div>

                            <p class="fw-semibold mb-1 text-white" style="font-size:.78rem;letter-spacing:.8px;">
                                REGISTERED OFFICE.
                            </p>

                            <p class="footer-address">
                                3rd Floor, Kalpataru Inspire,<br>
                                Highway, off Western<br>
                                Express Highway, Shanti Nagar,<br>
                                Vakola, Santacruz East,<br>
                                Mumbai, Maharashtra 400055<br>

                                {{-- <a href="mailto:protalk@sunpharma.com">protalk@sunpharma.com</a> --}}
                            </p>

                            <div class="footer-social mt-3">
                                <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                                <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                                <a href="#"><i class="fa-brands fa-youtube"></i></a>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-sm-6 footer-links">
                            <div class="fw-bolder fs-2 text-white">Protalk</div>
                            <a href="#">Webcast Connect</a>
                            <a href="#">Resource</a>
                            <a href="#">Contact Us</a>
                            <a href="#">Privacy Policy</a>
                        </div>

                    </div>
                </div>
            </div>

            <!-- SECTION 2 -->
            <div class="footer-bottom-wrapper">
                <div class="footer-container">
                    <div class="footer-bottom d-sm-flex justify-content-between align-items-center">
                        <p class="fs-6 mb-0 text-wrap">
                            VPCI Digital Learning is a structured educational platform offering expert-led modules, live
                            discussions, and evidence-based insights to support continuous medical learning and improved
                            clinical outcomes.
                        </p>

                        <div class="d-flex mt-md-0 align-items-center justify-content-end mt-2 gap-3">
                            <button id="goTopBtn" class="go-top-btn">
                                <i class="fa-solid fa-arrow-up"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </footer>

        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/select2.min.js') }}"></script>
        <script src="{{ asset('assets/js/script.js') }}"></script>
        @if (session()->has('success'))
            <script>
                $(document).ready(function() {
                    showAlert(@json(session('success')), "success");
                });
            </script>
        @endif

        @if (session()->has('error'))
            <script>
                $(document).ready(function() {
                    showAlert(@json(session('error')), "error");
                });
            </script>
        @endif
        @stack('scripts')
    </body>

</html>
