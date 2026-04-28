@extends('Frontend.layouts.app')
@section('title', 'Register')

@push('styles')
    <style>

    </style>
@endpush

@section('main')
    <!-- ══ REGISTER ══ -->
    <div class="auth-container">
        <div id="registerPage" class="auth-card auth-card-register">
            <h2>Register</h2>
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

            <form id="registerForm" action="{{ route('register.post') }}" method="POST">
                @csrf
                <div class="row g-3">

                    <!-- Title -->
                    <div class="col-12">
                        <label class="form-label">Title</label>
                        @php
                            $titles = ['Mr', 'Mrs', 'Ms', 'Dr'];
                        @endphp

                        <select id="title" name="title" class="form-select form-control">
                            <option value="" disabled {{ old('title') ? '' : 'selected' }}>Select Title</option>

                            @foreach ($titles as $item)
                                <option value="{{ $item }}" {{ old('title') == $item ? 'selected' : '' }}>
                                    {{ $item }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-title" class="text-danger error"></small>
                    </div>

                    <!-- Email -->
                    <div class="col-12">
                        <label class="form-label">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter email address"
                            class="form-control" value="{{ old('email') }}" />
                        <small id="error-email" class="text-danger error"></small>
                    </div>

                    <!-- First & Last Name -->
                    <div class="col-sm-6">
                        <label class="form-label">First Name</label>
                        <input type="text" id="firstName" name="firstName" placeholder="Enter First name"
                            class="form-control" value="{{ old('firstName') }}" />
                        <small id="error-firstName" class="text-danger error"></small>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">Last Name</label>
                        <input type="text" id="lastName" name="lastName" placeholder="Enter Last name"
                            class="form-control" value="{{ old('lastName') }}" />
                        <small id="error-lastName" class="text-danger error"></small>
                    </div>

                    <!-- Degree -->
                    <div class="col-12">
                        <label class="form-label">Degree</label>
                        <input type="text" id="degree" name="degree" placeholder="e.g. B.Sc Nutrition, M.D."
                            class="form-control" value="{{ old('degree') }}" />
                        <small id="error-degree" class="text-danger error"></small>
                    </div>

                    <!-- Hospital / Clinic -->
                    <div class="col-12">
                        <label class="form-label">Hospital / Clinic Name</label>
                        <input type="text" id="hospital" name="hospital" placeholder="Enter hospital or clinic name"
                            class="form-control" value="{{ old('hospital') }}" />
                        <small id="error-hospital" class="text-danger error"></small>
                    </div>

                    <!-- State -->
                    <div class="col-sm-6">
                        <label class="form-label">State</label>
                        <select id="state" name="state" class="form-control">
                            <option value="">Select State</option>
                            @foreach ($cities as $state => $cityList)
                                <option value="{{ $state }}" {{ old('state') == $state ? 'selected' : '' }}>
                                    {{ $state }}</option>
                            @endforeach
                        </select>
                        <small id="error-state" class="text-danger"></small>
                    </div>

                    <!-- City -->
                    <div class="col-sm-6">
                        <label class="form-label">City</label>
                        <input type="text" id="city" name="city" placeholder="Enter city name"
                            class="form-control" maxlength="50">
                        {{-- <select id="city" name="city" class="form-control">
                            <option value="">Select City</option>
                        </select> --}}
                        <small id="error-city" class="text-danger"></small>
                    </div>

                    <!-- Pincode & Mobile -->
                    <div class="col-sm-6">
                        <label class="form-label">Pincode</label>
                        <input type="number" id="pincode" name="pincode" placeholder="6-digit pincode"
                            class="form-control" maxlength="6" value="{{ old('pincode') }}" />
                        <small id="error-pincode" class="text-danger error"></small>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">Mobile No.</label>
                        <input type="number" id="mobile" name="mobile" placeholder="10-digit mobile"
                            class="form-control" maxlength="10" value="{{ old('mobile') }}" />
                        <small id="error-mobile" class="text-danger error"></small>
                    </div>

                    <!-- Password -->
                    <div class="col-12">
                        <label class="form-label">Password</label>
                        <div class="pass-wrap">
                            <input type="password" id="regPass" name="password" placeholder="Create password"
                                class="form-control no-error" oninput="checkStrength(this.value)"
                                value="{{ old('password') }}" />
                            <i class="fa fa-eye toggle-eye" onclick="togglePass('regPass', this)"></i>
                        </div>
                        <small id="error-password" class="text-danger error"></small><br>

                        {{-- <label class="form-label">Confirm Password</label>
                        <div class="pass-wrap">
                            <input type="password" id="confirmPass" name="password_confirmation"
                                placeholder="Re-enter password" class="form-control no-error" oninput="checkMatch()"
                                value="{{ old('password_confirmation') }}" />
                            <i class="fa fa-eye toggle-eye" onclick="togglePass('confirmPass', this)"></i>
                        </div>
                        <small id="error-confirmPass" class="text-danger error mb-2"></small>

                        <!-- Match label -->
                        <div id="matchLabel" class="strength-label mt-1"></div>

                        <!-- Strength bar -->
                        <div class="strength-bar mt-2">
                            <div id="strengthFill" class="fill"></div>
                        </div>
                        <div id="strengthLabel" class="strength-label" style="color:#aaa;">Enter a password</div>
                        <!-- Rules -->
                        <ul id="pwRules" class="pw-rules">
                            <li id="r-len"><i class="fa-regular fa-circle-xmark"></i> At least 8 characters</li>
                            <li id="r-upper"><i class="fa-regular fa-circle-xmark"></i> One uppercase letter</li>
                            <li id="r-lower"><i class="fa-regular fa-circle-xmark"></i> One lowercase letter</li>
                            <li id="r-num"><i class="fa-regular fa-circle-xmark"></i> One number</li>
                            <li id="r-special"><i class="fa-regular fa-circle-xmark"></i> One special character (!@#$...)
                            </li>
                        </ul> --}}
                    </div>

                </div><!-- /row -->

                <button type="submit" id="registerBtn" class="btn btn-primary-theme register-btn mt-2">Register</button>
            </form>

            <p class="auth-footer mb-0">
                Already Have An Account? <a href="{{ route('login') }}">Login Here</a>
            </p>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- state & city selection script --}}
    <script>
        $(document).ready(function() {

            // Your PHP array → convert to JS
            const cities = @json($cities);

            // Initialize Select2
            $('#state').select2({
                placeholder: "Select State",
                width: '100%'
            });

            // $('#city').select2({
            //     placeholder: "Select City",
            //     width: '100%'
            // });

            // // Initially empty city
            // $('#city').html('<option value="">Select City</option>');

            // On state change
            // $('#state').on('change', function() {

            //     let state = $(this).val();
            //     let cityDropdown = $('#city');

            //     // Reset city
            //     cityDropdown.html('<option value="">Select City</option>');

            //     if (state && cities[state]) {

            //         cities[state].forEach(function(city) {
            //             cityDropdown.append(
            //                 `<option value="${city.name}">${city.name}</option>`
            //             );
            //         });

            //     }

            //     // Refresh Select2
            //     cityDropdown.trigger('change');
            // });

        });
    </script>
    {{-- register password strength & toggle password --}}
    <script>
        function togglePass(id, icon) {
            const inp = document.getElementById(id);
            if (inp.type === 'password') {
                inp.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                inp.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // function checkStrength(val) {
        //     const rules = {
        //         'r-len': val.length >= 8,
        //         'r-upper': /[A-Z]/.test(val),
        //         'r-lower': /[a-z]/.test(val),
        //         'r-num': /[0-9]/.test(val),
        //         'r-special': /[^A-Za-z0-9]/.test(val),
        //     };
        //     let score = Object.values(rules).filter(Boolean).length;
        //     Object.entries(rules).forEach(([id, ok]) => {
        //         document.getElementById(id).classList.toggle('ok', ok);
        //     });
        //     const fill = document.getElementById('strengthFill');
        //     const label = document.getElementById('strengthLabel');
        //     const map = [{
        //             w: '0%',
        //             c: '#e0e0e0',
        //             t: ''
        //         },
        //         {
        //             w: '20%',
        //             c: '#e8292b',
        //             t: 'Very Weak'
        //         },
        //         {
        //             w: '40%',
        //             c: '#f7941d',
        //             t: 'Weak'
        //         },
        //         {
        //             w: '60%',
        //             c: '#ffc107',
        //             t: 'Fair'
        //         },
        //         {
        //             w: '80%',
        //             c: '#4caf50',
        //             t: 'Strong'
        //         },
        //         {
        //             w: '100%',
        //             c: '#22a762',
        //             t: 'Very Strong'
        //         },
        //     ];
        //     fill.style.width = map[score].w;
        //     fill.style.background = map[score].c;
        //     label.style.color = map[score].c;
        //     label.textContent = map[score].t || (val ? 'Very Weak' : 'Enter a password');
        // }

        // function checkMatch() {
        //     const p = document.getElementById('regPass').value;
        //     const c = document.getElementById('confirmPass').value;
        //     const lbl = document.getElementById('matchLabel');
        //     if (!c) {
        //         lbl.textContent = '';
        //         return;
        //     }
        //     if (p === c) {
        //         lbl.style.color = '#22a762';
        //         lbl.textContent = '✓ Passwords match';
        //     } else {
        //         lbl.style.color = '#e8292b';
        //         lbl.textContent = '✗ Passwords do not match';
        //     }
        // }
    </script>
    {{-- form submit script --}}
    <script>
        $(document).ready(function() {
            let cities = @json($cities);
            // console.log(cities);
            // $('[name="title"]').val('Mr').trigger('change');

            // $('[name="email"]').val('test@example.com');
            // $('[name="firstName"]').val('Jonathan');
            // $('[name="lastName"]').val('Smith');
            // $('[name="degree"]').val('MBBS');
            // $('[name="hospital"]').val('HP City Hospital');
            // $('[name="pincode"]').val('395006');
            // $('[name="mobile"]').val('9876543210');

            // // $('[name="password"]').val('Alergy_Ace');
            // let defaultState = "Gujarat";
            // let defaultCity = "Surat";

            // // Set state
            // $('#state').val(defaultState).trigger('change');
            // $('#city').val(defaultCity);



            $("#registerForm").on("submit", function(e) {
                e.preventDefault();

                $(".error").text(""); // clear old errors

                let valid = true;

                function setError(id, msg) {
                    let input = document.querySelector(`[name="${id}"]`);
                    if (input && !input.classList.contains('no-error')) {
                        input.classList.add("is-invalid"); // add error class
                    }
                    $("#error-" + id).text(msg);
                    valid = false;
                }

                let title = $("#title").val();
                let email = $("#email").val().trim();
                let firstName = $("#firstName").val().trim();
                let lastName = $("#lastName").val().trim();
                let degree = $("#degree").val().trim();
                let hospital = $("#hospital").val().trim();
                let pincode = $("#pincode").val().trim();
                let mobile = $("#mobile").val().trim();
                let password = $("#regPass").val();
                // let confirmPass = $("#confirmPass").val();
                let state = $("#state").val();
                let city = $("#city").val();

                if (!title) setError("title", "Select Title.");

                if (!email) {
                    setError("email", "Email Required.");
                } else if (!/^\S+@\S+\.\S+$/.test(email)) {
                    setError("email", "Invalid Email Address.");
                }

                if (!firstName) setError("firstName", "Enter First Name.");
                if (!lastName) setError("lastName", "Enter Last Name.");

                if (!degree) setError("degree", "Enter Degree Name.");
                if (!hospital) setError("hospital", "Enter Hospital Name.");
                if (!state) setError("state", "Select State Name.");
                if (!city) setError("city", "Select City Name.");

                if (!/^[0-9]{6}$/.test(pincode)) {
                    setError("pincode", "6 Digit Pincode Required.");
                }

                if (!/^[0-9]{10}$/.test(mobile)) {
                    setError("mobile", "Enter 10 Digit Mobile Number.");
                }

                if (!password) setError("password", "Enter Password.");
                if (password != "Alergy_Ace") setError("password", "Password must be Alergy_Ace.");
                // if (!confirmPass) setError("confirmPass", "Enter Confirm Password.");

                // Password Strength
                // if (password && (
                //         password.length < 8 ||
                //         !/[A-Z]/.test(password) ||
                //         !/[a-z]/.test(password) ||
                //         !/[0-9]/.test(password) ||
                //         !/[^A-Za-z0-9]/.test(password)
                //     )) {
                //     setError("password", "Password Is Not Strong.");
                // }

                // if (password !== confirmPass) {
                //     setError("confirmPass", "Passwords Do Not Match.");
                // }

                if (valid) {
                    this.submit();
                }
            });

        });
    </script>
@endpush
