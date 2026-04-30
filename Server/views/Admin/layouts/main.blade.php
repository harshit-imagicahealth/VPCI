<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>@yield('title', 'Admin')</title>
        <link href="{{ asset('public/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/assets/css/select2.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/assets/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />

        {{-- icon not work thats why cdn add --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
            rel="stylesheet" />

        <link rel="stylesheet" href="{{ asset('public/assets/css/admin.css?v=') . time() }}">
        <link rel="stylesheet" href="{{ asset('public/assets/css/form-components.css?v=') . time() }}">

        @stack('styles')
        <style>
            .sidebar-nav-item {
                padding-left: 0% !important;
            }

            /* ── Sidebar Dropdown Menu ── */
            .sidebar-nav-item {
                list-style: none;
            }

            .sidebar-nav-link {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 10px;
                padding: 11px 16px;
                border-radius: 10px;
                cursor: pointer;
                color: var(--primaryThemeColor);
                font-size: 0.875rem;
                font-weight: 500;
                text-decoration: none;
                transition: background .15s, color .15s;
                user-select: none;
                margin-bottom: 5px;
            }

            .sidebar-nav-link:hover {
                background: var(--primaryThemeColor);
                color: #fff;
            }

            .sidebar-nav-link.active {
                background: var(--primaryThemeColor);
                color: #fff;
            }

            .sidebar-nav-link-left {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .sidebar-nav-link i.nav-icon {
                font-size: 16px;
                color: var(--primaryThemeColor);
                flex-shrink: 0;
            }

            .sidebar-nav-link.active i.nav-icon,
            .sidebar-nav-link:hover i.nav-icon {
                color: #fff;
            }

            .sidebar-nav-chevron {
                font-size: 12px;
                color: var(--primaryThemeColor);
                transition: transform .25s ease, color .15s;
                flex-shrink: 0;
            }

            .sidebar-nav-link:hover .sidebar-nav-chevron {
                color: #fff;
            }

            .sidebar-nav-link.open .sidebar-nav-chevron {
                transform: rotate(180deg);
                color: white;
            }

            /* Dropdown children */
            .sidebar-dropdown {
                overflow: hidden;
                max-height: 0;
                transition: max-height .3s ease, opacity .25s ease;
                opacity: 0;
            }

            .sidebar-dropdown.open {
                max-height: 400px;
                opacity: 1;
            }

            .sidebar-dropdown-inner {
                padding: 4px 0 4px 22px;
                display: flex;
                flex-direction: column;
                gap: 2px;
            }

            .sidebar-dropdown-link {
                display: block;
                padding: 8px 14px;
                font-size: 0.855rem;
                font-weight: 6 00;
                color: #94a3b8;
                text-decoration: none;
                border-radius: 8px;
                transition: background .15s, color .15s, padding-left .15s;
                position: relative;
            }

            .sidebar-dropdown-link::before {
                content: '';
                position: absolute;
                left: 0;
                top: 50%;
                transform: translateY(-50%);
                width: 3px;
                height: 0;
                background: var(--primaryThemeColor);
                border-radius: 2px;
                transition: height .2s ease;
            }

            .sidebar-dropdown-link:hover {
                background: rgba(255, 255, 255, .06);
                color: var(--primaryThemeColor);
                padding-left: 18px;
            }

            .sidebar-dropdown-link:hover::before {
                height: 16px;
            }

            .sidebar-dropdown-link.active {
                /* background: var(--primaryThemeColorLight); */
                color: var(--primaryThemeColor);
                font-weight: 500;
                padding-left: 18px;
            }

            .sidebar-dropdown-link.active::before {
                height: 16px;
            }
        </style>

    </head>

    <body>

        {{-- <!-- ═════ SIDEBAR ═════ --> --}}
        <aside id="sidebar">

            <!-- Logo -->
            <a class="sidebar-logo d-flex align-items-center justify-content-center"
                href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('public/assets/images/VPCI.png') }}" alt="" width="90">
            </a>

            <span class="sidebar-underline"></span>

            <!-- Nav -->
            <nav class="sidebar-nav">

                <!-- Dashboard -->
                <a id="nev-menu-item" @class([
                    'nav-item-link',
                    'active' => request()->routeIs('admin.dashboard'),
                ]) href="{{ route('admin.dashboard') }}"
                    data-title="Dashboard">
                    <i class="fa fa-home nav-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>

                <!-- Users -->
                <a id="nev-menu-item" @class([
                    'nav-item-link',
                    'active' => request()->routeIs('admin.users.*'),
                ]) href="{{ route('admin.users.index') }}"
                    data-title="Dashboard">
                    <i class="fa fa-users nav-icon"></i>
                    <span class="nav-text">Users</span>
                </a>

                {{-- <!-- WebCast Connect -->
                <a id="nev-menu-item" @class([
                    'nav-item-link',
                    'active' => request()->routeIs('admin.wc_connect.*'),
                ]) href="{{ route('admin.wc_connect.index') }}"
                    data-title="Dashboard">
                    <i class="fa fa-broadcast-tower nav-icon"></i>
                    <span class="nav-text">WebCast Connect</span>
                </a>

                <!-- WebCast Resources -->
                <a id="nev-menu-item" @class([
                    'nav-item-link',
                    'active' => request()->routeIs('admin.wc_resource.*'),
                ]) href="{{ route('admin.wc_resource.index') }}"
                    data-title="Dashboard">
                    <i class="fa fa-briefcase nav-icon"></i>
                    <span class="nav-text">Resources</span>
                </a>

                <!-- Assment Questions -->
                <a id="nev-menu-item" @class([
                    'nav-item-link',
                    'active' => request()->routeIs('admin.questions.*'),
                ]) href="{{ route('admin.questions.index') }}"
                    data-title="Dashboard">
                    <i class="fa-regular fa-circle-question nav-icon"></i>
                    <span class="nav-text">Assessment Questions</span>
                </a> --}}

                <div class="sidebar-nav-item">
                    {{-- Webcast Connect --}}
                    <div @class([
                        'sidebar-nav-link',
                        'active' =>
                            request()->routeIs('admin.wc_connect.*') ||
                            request()->routeIs('admin.wc_resource.*') ||
                            request()->routeIs('admin.questions.*'),
                    ]) onclick="toggleSidebarDropdown(this)">
                        <div class="sidebar-nav-link-left">
                            <i class="fa fa-cog nav-icon"></i>
                            <span>WebCast Connect</span>
                        </div>
                        <i class="fa fa-chevron-up sidebar-nav-chevron"></i>
                    </div>

                    <div class="sidebar-dropdown">
                        <div class="sidebar-dropdown-inner">
                            <a @class([
                                'sidebar-dropdown-link',
                                'active' => request()->routeIs('admin.wc_connect.*'),
                            ]) href="{{ route('admin.wc_connect.index') }}">
                                <i class="fa fa-broadcast-tower nav-icon"></i> Activity</a>
                            <a @class([
                                'sidebar-dropdown-link',
                                'active' => request()->routeIs('admin.wc_resource.*'),
                            ]) href="{{ route('admin.wc_resource.index') }}">
                                <i class="fa fa-briefcase nav-icon"></i> Activity Resources</a>
                            <a @class([
                                'sidebar-dropdown-link',
                                'active' => request()->routeIs('admin.questions.*'),
                            ]) href="{{ route('admin.questions.index') }}">
                                <i class="fa-regular fa-circle-question nav-icon"></i> Assessment Questions</a>
                        </div>
                    </div>
                </div>

            </nav>

        </aside>

        <!-- ═════ MAIN WRAPPER ═════ -->
        <div id="mainWrapper">
            <div id="floatingAlert" class="floating-alert d-none"></div>

            <!-- HEADER -->
            <header id="topHeader">

                <!-- Toggle -->
                <button class="sidebar-toggle" onclick="toggleSidebar()">
                    <i class="fa fa-bars"></i>
                </button>
                <!-- Breadcrumb -->
                <div class="header-breadcrumb">
                    <h6 id="pageTitle">@yield('header-breadcrumb', 'Dashboard')</h6>
                </div>

                <!-- User -->
                <div id="userMenu" class="user-menu">
                    <div class="user-avatar">
                        {{ strtoupper(collect(explode(' ', Auth::user()?->name ?? 'VPCI'))->map(fn($w) => substr($w, 0, 1))->implode('')) }}
                    </div>

                    <div class="user-info d-none d-sm-flex flex-column">
                        <div class="user-name text-start">
                            {{ Auth::user()?->name ?? (Auth::user()?->email ?? 'VPCI') }}
                        </div>
                        <div class="user-role">{{ Auth::user()?->email }}</div>
                    </div>

                    <i class="fa fa-chevron-down user-chevron"></i>

                    <!-- Dropdown -->
                    <div id="userDropdown" class="user-dropdown">
                        <a class="logout" href="#">
                            <i class="fa fa-right-from-bracket fa-fw"></i> Logout
                        </a>
                    </div>
                </div>

            </header>

            <!-- PAGE CONTENT -->
            <main id="pageContent">

                <!-- Breadcrumb -->
                <div class="header-breadcrumb d-flex align-items-center justify-content-end me-4">
                    <nav class="mb-3" aria-label="breadcrumb">
                        <ol id="breadcrumb" class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    <i class="fa fa-house" style="font-size:.75rem;"></i>
                                </a>
                            </li>
                            @stack('breadcrumbs')
                        </ol>
                    </nav>
                </div>

                @yield('content')

            </main>

            <!-- FOOTER -->
            <footer id="pageFooter">
                <span>© {{ date('Y') }} <strong>VPCI</strong> — A VPCI Digital Learning Division. All rights
                    reserved.</span>
                {{-- <span><a href="#">Privacy Policy</a> &nbsp;·&nbsp; <a href="#">Disclaimer</a></span> --}}
            </footer>

        </div><!-- /mainWrapper -->

        <div id="pageLoader" class="page-loader d-none">
            <div class="loader-content">
                <i class="fa fa-spinner fa-spin"></i>
                <span>Loading...</span>
            </div>
        </div>

        <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
        <script>
            let loader = $("#pageLoader");
            loader.removeClass("d-none");
            setTimeout(() => {
                loader.addClass("d-none");
            }, 1000);
        </script>
        <script src="{{ asset('public/assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('public/assets/js/select2.min.js') }}"></script>
        <script src="{{ asset('public/assets/js/sweetalert2@11.js') }}"></script>
        <script src="{{ asset('public/assets/js/bootstrap-datepicker.min.js') }}"></script>

        <script src="{{ asset('public/assets/js/form-components.js?v=') . time() }}"></script>
        <script src="{{ asset('public/assets/js/admin.js?v=') . time() }}"></script>
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
        <script>
            function toggleSidebarDropdown(trigger) {
                const dropdown = trigger.nextElementSibling;
                const isOpen = dropdown.classList.contains('open');
                // ❌ Remove active from all parent links
                document.querySelectorAll('.sidebar-nav-link').forEach(link => {
                    link.classList.remove('active', 'open');
                });

                /* Close all open dropdowns */
                document.querySelectorAll('.sidebar-dropdown.open').forEach(d => {
                    d.classList.remove('open');
                    d.previousElementSibling.classList.remove('open');
                });

                /* Open clicked one if it was closed */
                if (!isOpen) {
                    dropdown.classList.add('open');
                    trigger.classList.add('active', 'open');
                }
            }

            /* Auto-open dropdown if a child is active on page load */
            document.querySelectorAll('.sidebar-dropdown-link.active').forEach(link => {
                const dropdown = link.closest('.sidebar-dropdown');
                if (dropdown) {
                    dropdown.classList.add('open');
                    dropdown.previousElementSibling.classList.add('open');
                }
            });
        </script>
    </body>

</html>
