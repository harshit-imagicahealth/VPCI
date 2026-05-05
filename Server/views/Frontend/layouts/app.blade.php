<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>@yield('title', 'Pro-talk | Let`s Talk Nutrition')</title>
        <link href="{{ asset('public/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/assets/css/select2.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/assets/css/swiper.css') }}" rel="stylesheet" />
        {{-- icon not work thats why cdn add --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
            rel="stylesheet" />

        <link rel="stylesheet" href="{{ asset('public/assets/css/style.css') }}">
        @stack('styles')
    </head>

    <body>

        <!-- NAVBAR -->
        <nav id="mainNavbar" class="navbar navbar-expand-lg fixed-top">
            <div class="d-flex align-items-center justify-content-between w-100">

                <!-- Logo -->
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img class="img-fluid nav-logo" src="{{ asset('public/assets/images/VPCI.png') }}" width="100">
                </a>

                <!-- Toggle Button -->
                <button type="button" class="navbar-toggler" data-bs-toggle="offcanvas"
                    data-bs-target="#mobileSidebar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Desktop Menu -->
                <div class="navbar-collapse d-none d-lg-flex collapse">
                    <ul class="navbar-nav me-auto">
                        @guest
                            <li class="nav-item">
                                <a href="{{ route('home') }}" @class(['nav-link', 'active' => request()->routeIs('home')])>
                                    Home
                                </a>
                            </li>
                        @endguest

                        <li class="nav-item">
                            <a href="{{ route('about-us') }}" @class(['nav-link', 'active' => request()->routeIs('about-us')])>
                                About Us
                            </a>
                        </li>
                        @auth('web')
                            <li class="nav-item">
                                <a href="{{ route('live-session') }}" @class(['nav-link', 'active' => request()->routeIs('live-session')])>
                                    <i class="fa fa-broadcast-tower me-2"></i>Live
                                    Session
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('webinars.assessment') }}" @class([
                                    'nav-link',
                                    'active' => request()->routeIs('webinars.assessment.*'),
                                ])>
                                    Assessment
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
                    <img class="img-fluid nav-logo" src="{{ asset('public/assets/images/VPCI.png') }}" width="100">
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>

            <div class="offcanvas-body">
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a href="{{ route('home') }}" @class(['nav-link', 'active' => request()->routeIs('home')])>
                                Home
                            </a>
                        </li>
                    @endguest

                    <li class="nav-item">
                        <a href="{{ route('about-us') }}" @class(['nav-link', 'active' => request()->routeIs('about-us')])>
                            About Us
                        </a>
                    </li>
                    @auth('web')
                        <li class="nav-item">
                            <a href="{{ route('live-session') }}" @class(['nav-link', 'active' => request()->routeIs('live-session')])>
                                <i class="fa fa-broadcast-tower me-2"></i>Live Session
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('webinars.assessment') }}" @class([
                                'nav-link',
                                'active' => request()->routeIs('webinars.assessment'),
                            ])>
                                Assessment
                            </a>
                        </li>
                    @endauth
                </ul>

                <div class="d-flex flex-column mt-3 gap-2">
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

        <section class="main_section">
            <div id="floatingAlert" class="floating-alert d-none"></div>
            @yield('main')
        </section>

        <!-- FOOTER -->
        <footer class="footer-about">
            <div class="container">

                <!-- LEFT CONTENT -->
                <div class="mb-4">
                    <div class="row align-items-start about-box w-100 h-100 align-items-center mx-auto">
                        {{-- <div class="col-md-7 border-right">
                            <h2>About ACE</h2>
                            <p class="text-muted">
                                ACE is a structured 3-month academic initiative featuring expert-led modules.
                                pre-learning material, and concise post-session summaries, delivered through a
                                dedicated
                                microsite.
                            </p>
                            <p class="text-muted">
                                The program comprises 6 focused modules led by distinguished faculty, ensuring
                                clinically
                                relevant and evidence-based insights.
                            </p>
                            <p class="text-muted">
                                Upon successful completion & assessment, participants will receive
                                <strong>certification from Vallabhbhai Patel Chest Institute (VPCI).</strong>
                            </p>
                        </div> --}}
                        <div class="col-md-12">
                            <img class="img-fluid" src="{{ asset('public/assets/images/Footer(20).png') }}"
                                alt="VPCI" width="100%">

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

        <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('public/assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('public/assets/js/select2.min.js') }}"></script>
        <script src="{{ asset('public/assets/js/sweetalert2@11.js') }}"></script>
        <script src="{{ asset('public/assets/js/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('public/assets/js/script.js?v=') . time() }}"></script>
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
