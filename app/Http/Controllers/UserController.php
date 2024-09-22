<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewRegistedAccount;

class UserController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return view('panels.dashboard');
        } else {
            return view('panels.login');
        }
    }
    public function checkIfExist(Request $request)
    {
        $response = ['exists' => false];

        if ($request->switch == 1) {
            $usernameExists = User::where('username', $request->username)->exists();
            if ($usernameExists) {
                $response['exists'] = true;
                $response['field'] = 'username';
                return response()->json($response);
            }
        }
        if ($request->switch == 2) {
            $emailExists = User::where('email', $request->email)->exists();
            if ($emailExists) {
                $response['exists'] = true;
                $response['field'] = 'email';
                return response()->json($response);
            }
        }

        return response()->json($response);
    }
    public function signUp(Request $request)
    {
        try {
            // Validate input fields
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username',
                'email' => 'required|email',
                'password' => 'required|string|min:8',
                'telephone' => 'required|string|max:15',
                'addressLine1' => 'required|string|max:255',
                'addressLine2' => 'nullable|string|max:255',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'zip' => 'required|string|max:10',
            ]);

            // Sanitize inputs to remove any unwanted HTML tags
            $validatedData['name'] = strip_tags($validatedData['name']);
            $validatedData['username'] = strip_tags($validatedData['username']);
            $validatedData['email'] = filter_var($validatedData['email'], FILTER_SANITIZE_EMAIL);
            $validatedData['telephone'] = strip_tags($validatedData['telephone']);
            $validatedData['addressLine1'] = strip_tags($validatedData['addressLine1']);
            $validatedData['addressLine2'] = strip_tags($validatedData['addressLine2']);
            $validatedData['city'] = strip_tags($validatedData['city']);
            $validatedData['state'] = strip_tags($validatedData['state']);
            $validatedData['zip'] = strip_tags($validatedData['zip']);

            // Hash the password
            $hashedPassword = Hash::make($request->password);

            // Create and save the new user
            $user = new User();
            $user->name = $validatedData['name'];
            $user->username = $validatedData['username'];
            $user->email = $validatedData['email'];
            $user->password = $hashedPassword;
            $user->save();

            // Create and save the user address
            $userAddress = new Address();
            $userAddress->user_id = $user->id;
            $userAddress->telephone = $validatedData['telephone'];
            $userAddress->address_line1 = $validatedData['addressLine1'];
            $userAddress->address_line2 = $validatedData['addressLine2'] ?? null;
            $userAddress->city = $validatedData['city'];
            $userAddress->state_province = $validatedData['state'];
            $userAddress->zipcode = $validatedData['zip'];
            $userAddress->save();

            // Log the user in
            Auth::login($user);

            // Send registration email
            Mail::to($user->email)->send(new NewRegistedAccount($user));

            // Return success response
            return response()->json([
                'redirect' => route('dashboard'),
                'message' => 'Registration successful. Redirecting...'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            return view('panels.dashboard');
        }

        return back()->withErrors(['message' => 'Invalid login credentials.']);
    }


    public function logout()
    {
        Auth::logout();
        return view('panels.login');
    }
}
