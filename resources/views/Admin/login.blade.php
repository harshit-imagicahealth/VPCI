<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Login </title>
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
            rel="stylesheet" />
        <style>
            :root {
                --primaryThemeColor: #085ea5;
                --primaryThemeColorHover: color-mix(in srgb,
                        var(--primaryThemeColor) 80%,
                        black);
                --primaryThemeColorDark: #161c42;
                --primaryThemeColorLight: #2a337a;
                --sidebarWidth: 255px;
                --sidebarCollapsed: 72px;
                --headerHeight: 64px;
                --accentColor: var(--primaryThemeColor);
                --lightBg: #eef1f8;
                --inputBg: #edf0f7;
                --borderRadius: 8px;
                --font: "Poppins", sans-serif;
                --bodyBg: #f0f2f8;
                --cardBg: #ffffff;
                --textMuted: #8a93b2;
            }

            * {
                font-family: var(--font);
            }

            body {
                background: #f0f2f8;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 30px 16px;
            }

            /*Auth login  card css */
            .auth-container {
                max-height: fit-content;
                width: 100%;
                max-width: 520px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: transparent;
                padding-block: 4rem;
            }

            .auth-card {
                background: #fff;
                border-radius: 14px;
                padding: 38px 36px;
                width: 100%;
                /* max-width: 620px; */
                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08);
            }

            .auth-card h2 {
                font-weight: 700;
                color: #1a1a1a;
                margin-bottom: 4px;
            }

            .auth-card .underline {
                width: 36px;
                height: 3px;
                background: var(--accentColor);
                border-radius: 2px;
                margin-bottom: 28px;
            }

            /* inputs */
            .form-control,
            .form-select {
                background: var(--inputBg);
                border: 1.5px solid transparent;
                border-radius: var(--borderRadius);
                padding: 10px 14px;
                font-size: 0.9rem;
                color: #333;
                transition:
                    border-color 0.2s,
                    background 0.2s;
            }

            .form-control:focus,
            .form-select:focus {
                background: #fff;
                border-color: var(--primaryThemeColor);
                box-shadow: none;
            }

            .form-label {
                font-size: 0.82rem;
                font-weight: 600;
                color: #555;
                margin-bottom: 5px;
            }

            /* password toggle */
            .pass-wrap {
                position: relative;
            }

            .pass-wrap .toggle-eye {
                position: absolute;
                right: 12px;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
                color: #999;
                font-size: 0.9rem;
            }

            .pass-wrap .toggle-eye:hover {
                color: var(--primaryThemeColor);
            }

            /* strength bar */
            .strength-bar {
                height: 5px;
                border-radius: 4px;
                background: #e0e0e0;
                margin-top: 8px;
                overflow: hidden;
            }

            .strength-bar .fill {
                height: 100%;
                border-radius: 4px;
                transition:
                    width 0.4s,
                    background 0.4s;
                width: 0%;
            }

            .strength-label {
                font-size: 0.75rem;
                font-weight: 600;
                margin-top: 4px;
            }

            /* rules */
            .pw-rules {
                list-style: none;
                padding: 0;
                margin: 8px 0 0;
            }

            .pw-rules li {
                font-size: 0.76rem;
                color: #999;
                margin-bottom: 3px;
            }

            .pw-rules li i {
                margin-right: 5px;
            }

            .pw-rules li.ok {
                color: #22a762;
            }

            .pw-rules li.ok i::before {
                content: "\f058";
            }

            .pw-rules li:not(.ok) i::before {
                content: "\f057";
            }

            /* btn */
            .btn-primary-theme {
                background: var(--primaryThemeColor);
                color: #fff;
                border: none;
                border-radius: var(--borderRadius);
                padding: 10px 32px;
                font-weight: 600;
                font-size: 0.9rem;
                letter-spacing: 0.5px;
                transition: background 0.2s;
            }

            .btn-primary-theme:hover {
                background: var(--primaryThemeColorHover);
                color: #fff;
            }

            .auth-footer {
                font-size: 0.84rem;
                color: #aaa;
                margin-top: 22px;
            }

            .auth-footer a {
                color: var(--accentColor);
                font-weight: 600;
                text-decoration: none;
            }

            .auth-footer a:hover {
                text-decoration: underline;
            }
        </style>
    </head>

    <body>

        <!-- ══ LOGIN ══ -->
        <div class="auth-container">
            <div id="loginPage" class="auth-card">
                <h2>Login</h2>
                <div class="underline"></div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ol class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ol>
                    </div>
                @endif

                <form id="loginForm" action="{{ route('admin.login.post') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" id="loginEmail" name="email" placeholder="Enter email address"
                            class="form-control" value="{{ old('email') }}" />
                        <small id="error-loginEmail" class="text-danger error mb-2"></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="pass-wrap">
                            <input type="password" id="loginPass" name="password" placeholder="Enter password"
                                class="form-control" value="{{ old('password') }}" />
                            <i id="togglePass" class="fa fa-eye toggle-eye"></i>
                        </div>
                        <small id="error-password" class="text-danger error mb-2"></small>
                    </div>

                    <button type="submit" class="btn btn-primary-theme mt-2"
                        style="text-transform:uppercase;letter-spacing:1px;">Login</button>
                </form>
            </div>
        </div>

        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/admin.js?v=') . time() }}"></script>
    </body>

</html>
