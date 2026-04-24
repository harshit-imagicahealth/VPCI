<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>@yield('title', 'Admin')</title>
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />

        {{-- icon not work thats why cdn add --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
            rel="stylesheet" />

        <link rel="stylesheet" href="{{ asset('assets/css/admin.css?v=') . time() }}">
        <link rel="stylesheet" href="{{ asset('assets/css/form-components.css?v=') . time() }}">

        @stack('styles')

    </head>

    <body>

        {{-- <!-- ═════ SIDEBAR ═════ --> --}}
        <aside id="sidebar">

            <!-- Logo -->
            <a class="sidebar-logo d-flex align-items-center justify-content-center"
                href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('assets/images/VPCI.png') }}" alt="" width="90">
            </a>

            <span class="sidebar-underline"></span>

            <!-- Nav -->
            <nav class="sidebar-nav">

                <!-- Dashboard -->
                <a id="nev-menu-item" @class([
                    'nav-item-link',
                    'active' => request()->routeIs('admin.dashboard'),
                ]) href="{{ route('admin.dashboard') }}"
                    data-title="Dashboard" data-subitems="[]">
                    <i class="fa fa-gauge nav-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>

                <!-- Users -->
                <a id="nev-menu-item" @class([
                    'nav-item-link',
                    'active' => request()->routeIs('admin.users.*'),
                ]) href="{{ route('admin.users.index') }}"
                    data-title="Dashboard" data-subitems="[]">
                    <i class="fa fa-gauge nav-icon"></i>
                    <span class="nav-text">Users</span>
                </a>
                <!-- Category -->
                <a id="nev-menu-item" @class([
                    'nav-item-link',
                    'active' => request()->routeIs('admin.category.*'),
                ]) href="{{ route('admin.category.index') }}"
                    data-title="Dashboard" data-subitems="[]">
                    <i class="fa fa-gauge nav-icon"></i>
                    <span class="nav-text">Category</span>
                </a>
                <!-- WebCast Connect -->
                <a id="nev-menu-item" @class([
                    'nav-item-link',
                    'active' => request()->routeIs('admin.wc_connect.*'),
                ]) href="{{ route('admin.wc_connect.index') }}"
                    data-title="Dashboard" data-subitems="[]">
                    <i class="fa fa-gauge nav-icon"></i>
                    <span class="nav-text">WebCast Connect</span>
                </a>

                {{-- <!-- Dropdown Trigger -->
                <a class="nav-item-link dropdownManu" href="#" data-target="usersDropdown">
                    <i class="fa fa-users nav-icon"></i>
                    <span class="nav-text">Users</span>
                    <i class="fa fa-chevron-down nav-arrow"></i>
                </a>

                <!-- Dropdown Content -->
                <div id="usersDropdown" class="nav-dropdown">
                    <a class="nav-item-link" href="#">
                        <i class="fa fa-user-plus nav-icon"></i>
                        <span class="nav-text">Add User</span>
                    </a>
                    <a class="nav-item-link" href="#">
                        <i class="fa fa-list-ul nav-icon"></i>
                        <span class="nav-text">Manage Users</span>
                    </a>
                </div> --}}

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
                    <h6 id="pageTitle">Dashboard</h6>
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

        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script>
            let loader = $("#pageLoader");
            loader.removeClass("d-none");
            setTimeout(() => {
                loader.addClass("d-none");
            }, 1000);
        </script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/select2.min.js') }}"></script>
        <script src="{{ asset('assets/js/sweetalert2@11.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>

        <script src="{{ asset('assets/js/form-components.js?v=') . time() }}"></script>
        <script src="{{ asset('assets/js/admin.js?v=') . time() }}"></script>
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
