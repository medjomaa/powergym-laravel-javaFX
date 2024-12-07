<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuthManager extends Controller
{
    // Show dashboard view
    public function showDashboard()
    {
        return view('produit'); // Replace with your actual dashboard view
    }

    // Show login form
    public function login()
    {
        return view('login'); // Assuming your login view is in 'view/login.blade.php'
    }

    // Show registration form
    public function registration()
    {
        return view('registration'); // Assuming your registration view is in 'view/registration.blade.php'
    }

    // Handle login form submission
    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->is_suspended) {
                return redirect()->back()->withErrors([
                    'email' => 'Your account has been suspended. Please contact the administrator.',
                ]);
            }

            return redirect()->intended(route('home')); // Assuming 'home' is the route name for your dashboard
        }

        return redirect()->back()->withInput($request->only('email'))->withErrors([
            'email' => 'Login failed. Please check your username and password and try again.',
        ]);
    }

    // Handle registration form submission
    public function registrationPost(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Add validation for the image
        ]);

        if ($request->hasFile('profile_image')) {
            $imageName = time().'.'.$request->profile_image->extension();  
            $request->profile_image->storeAs('public/profile_images', $imageName);
            $profileImagePath = 'profile_images/' . $imageName;
        } else {
            $profileImagePath = null; // Or set a default image path
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_image' => $profileImagePath, // Save the image path
        ]);

        if (!$user) {
            return redirect(route('registration'))->with("error", "Registration failed, please try again.");
        }

        return redirect(route('login'))->with("success", "Registration successful, please log in to access the app.");
    }

    // Logout user
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }

    // Show forgot password form
    public function showForgotPasswordForm()
    {
        return view('auth.email'); // Assuming 'auth/email.blade.php' exists
    }

    // Send reset password link
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required',
            'name' => 'required'
        ]);

        // Log the input data
        Log::info('Password reset requested', [
            'email' => $request->email,
            'phone' => $request->phone,
            'name' => $request->name,
        ]);

        // Retrieve and log all user records
        $allUsers = User::all();
        Log::info('All user records', [
            'users' => $allUsers
        ]);

        // Retrieve user record
        $user = User::where('email', $request->email)
            ->where('phone', $request->phone)
            ->where('name', $request->name)
            ->first();

        // Log the retrieved user data
        Log::info('User record found', [
            'user' => $user
        ]);

        if (!$user) {
            return back()->withErrors(['email' => 'The provided information does not match our records.']);
        }

        // Redirect to the password reset form
        return redirect()->route('password.reset', ['email' => $request->email]);
    }

    // Show reset password form
    public function showResetForm(Request $request)
    {
        $email = $request->query('email');
        return view('auth.reset', compact('email')); // Assuming 'auth/reset.blade.php' exists
    }

    // Reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No user found with this email address.']);
        }

        // Update the user's password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Password has been updated.');
    }
}
