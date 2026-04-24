<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register()
    {
        $cities = collect(config('citys'))->groupBy('state')->sortKeys()->map(fn($items) => $items->sortBy('name')->values());
        return view('Frontend.Auth.register', compact('cities'));
    }

    public function registerPost(Request $request)
    {
        try {

            // ✅ Validation
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'email' => 'required|email|unique:users,email',
                'firstName' => 'required',
                'lastName' => 'required',
                'degree' => 'required',
                'hospital' => 'required',
                'state' => 'required',
                'city' => 'required',
                'pincode' => 'required|digits:6',
                'mobile' => 'required|digits:10|unique:users,mobile',
                'password' => [
                    'required',
                    'min:8',
                    'regex:/[A-Z]/',
                    'regex:/[a-z]/',
                    'regex:/[0-9]/',
                    'regex:/[@$!%*#?&]/',
                    'confirmed',
                ],
                'password_confirmation' => 'required|same:password'
            ], [
                'email.required' => 'Email is required.',
                'email.unique' => 'Email already exists.',
                'firstName.required' => 'First Name is required.',
                'lastName.required' => 'Last Name is required.',
                'degree.required' => 'Degree is required.',
                'hospital.required' => 'Hospital Name is required.',
                'state.required' => 'State is required.',
                'city.required' => 'City is required.',
                'pincode.required' => 'Pincode is required.',
                'pincode.digits' => 'Pincode must be 6 digits.',
                'mobile.required' => 'Mobile is required.',
                'mobile.unique' => 'Mobile already exists.',
                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 8 characters.',
                'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
                'password.confirmed' => 'Password does not match confirm password.',
                'password_confirmation.required' => 'Confirm Password is required.',
                'password_confirmation.same' => 'Confirm Password does not match password.',
            ]);

            if ($validator->fails()) {
                // dd($validator->errors());
                return redirect()->back()
                    ->withErrors($validator->errors())
                    ->withInput();
            }

            DB::beginTransaction();

            // ✅ Create User
            $user = User::create([
                'title' => $request->title,
                'name' => $request->firstName . ' ' . $request->lastName,
                'first_name' => $request->firstName,
                'last_name' => $request->lastName,
                'email' => $request->email,
                'degree' => $request->degree,
                'hospital' => $request->hospital,
                'state' => $request->state,
                'city' => $request->city,
                'pincode' => $request->pincode,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
            ]);

            DB::commit();

            Auth::login($user);

            // ✅ Success Response
            Session::flash('success', 'Registration Successful.');
            return redirect()->route('home');
        } catch (\Illuminate\Validation\ValidationException $e) {

            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {

            DB::rollBack();
            Log::error($e->getMessage());

            return redirect()->back()
                ->with('error', 'Something Went Wrong. Please Try Again.')
                ->withInput();

            // 🔥 For debugging (optional)
            // dd($e->getMessage());
        }
    }
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard'); // changed rouete from dashboard to home
        }
        return view('Frontend.Auth.login');
    }

    public function loginPost(Request $request)
    {
        $validator = Validator::make($request->only(['email', 'password']), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email format.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
        ]);
        if ($validator->fails()) {
            return redirect()->route('login')
                ->withErrors($validator->errors())
                ->withInput();
        }

        // $user = User::where('email', $request->email)->first();

        // if (!$user) {
        //     Session::flash('error', 'InValid Email Or Password!');
        //     return redirect()->route('login')->withInput();
        // }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            Session::flash('success', 'Login Successful.');
            return redirect()->route('home');
        } else {
            Session::flash('error', 'InCorrect Email Or Password!');
            return redirect()->route('login')->withInput();
        }

        // Auth::login($user);
    }



    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
