<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Show registration form
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle user registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        Auth::login($user);
        
        // Regenerate session to prevent session fixation
        $request->session()->regenerate();

        return redirect()->route('products.index');
    }

    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle user login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // CRITICAL: Flush any existing session data to prevent role crossover
        $request->session()->flush();
        $request->session()->regenerate();

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Regenerate session AGAIN after successful login
            $request->session()->regenerate();

            // Log successful login
            \Log::info('User logged in', [
                'user_id' => Auth::id(),
                'email' => Auth::user()->email,
                'role' => Auth::user()->role,
                'ip' => $request->ip(),
            ]);

            // Redirect based on role
            if (Auth::user()->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('products.index'));
        }

        // Log failed login attempt
        \Log::warning('Failed login attempt', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle user logout
     */
    public function logout(Request $request)
    {
        // Store intended URL before logout (if any)
        $user = Auth::user();
        
        // Log logout
        \Log::info('User logged out', [
            'user_id' => $user?->id,
            'role' => $user?->role,
        ]);

        // Logout
        Auth::logout();

        // CRITICAL: Flush ALL session data
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Force forget all session keys
        $request->session()->forget('_token');
        $request->session()->forget('_previous');
        $request->session()->forget('_flash');

        return redirect()->route('login')->with('success', 'Anda berhasil logout');
    }
}
