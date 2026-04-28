@extends('Frontend.layouts.app')
@section('title', 'Login')

@push('styles')
    <style>

    </style>
@endpush

@section('main')
    {{-- <div class="auth-container">
        <div class="auth-card">

            <h3 class="mb-4 text-center">Login</h3>

            <form>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" placeholder="Enter email" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" placeholder="Enter password" class="form-control">
                </div>

                <button class="btn btn-primary w-100">Login</button>

                <p class="mt-3 text-center">
                    Don't have an account? <a href="#">Register</a>
                </p>
            </form>

        </div>
    </div> --}}
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

            <form id="loginForm" action="{{ route('login.post') }}" method="post">
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
                            class="form-control" value="" />
                        <i id="togglePass" class="fa fa-eye toggle-eye"></i>
                    </div>
                    <small id="error-password" class="text-danger error mb-2"></small>
                </div>

                <button type="submit" class="btn btn-primary-theme mt-2"
                    style="text-transform:uppercase;letter-spacing:1px;">Login</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // defaultvalue set for the test
            // $('#loginEmail').val('test@example.com');
            // $('#loginPass').val('Test@123');

            let valid = true;
            const togglePass = (id, eye) => {
                const inp = document.getElementById(id);
                if (inp.type === 'password') {
                    inp.type = 'text';
                    eye.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    inp.type = 'password';
                    eye.classList.replace('fa-eye-slash', 'fa-eye');
                }
            }
            $('#togglePass').click(function() {
                togglePass('loginPass', this);
            });
            const error = (id, msg) => {
                const inp = document.getElementById(id);
                inp.classList.add('is-invalid');
                document.getElementById('error-' + id).innerHTML = msg;
            }
            $('#loginForm').submit(function(e) {
                e.preventDefault();
                let loginEmail = $('#loginEmail').val();
                let loginPass = $('#loginPass').val();
                if (!loginEmail || loginEmail == '') {
                    error('loginEmail', 'Enter email address');
                    valid = false;
                }
                if (!loginPass || loginPass == '') {
                    console.log(loginPass, 'password');
                    $('#error-password').text('Enter password');
                    valid = false;
                }
                if (valid) {
                    this.submit();
                }
            });
        });
    </script>
@endpush
