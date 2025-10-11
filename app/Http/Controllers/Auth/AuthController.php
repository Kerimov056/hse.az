<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Eyni səhifədə login/register göstər.
     * /auth/{tab?}  -> tab = login | register (default: login)
     */
    public function show(string $tab = 'login')
    {
        if (!in_array($tab, ['login','register'])) {
            $tab = 'login';
        }

        // Əgər artıq login olubsa, home-a at
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('educve.signup', ['tab' => $tab]);
    }

    /**
     * Register
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required','string','max:255'],
            'email'    => ['required','email','unique:users,email'],
            'phone'    => ['nullable','string','max:30'],
            'password' => ['required','string','min:8','confirmed'],
        ]);

        // User modelində password üçün 'hashed' cast varsa, raw veririk
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'phone'    => $data['phone'] ?? null,
            'password' => $data['password'],
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required','string'],
            'remember' => ['nullable','boolean'],
        ]);

        $remember = (bool)($credentials['remember'] ?? false);
        unset($credentials['remember']);

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        throw ValidationException::withMessages([
            'email' => __('These credentials do not match our records.'),
        ]);
    }

    /**
     * Logout (web session)
     */
    public function webLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.show', 'login');
    }

    // ===== JWT JSON endpointləri (istəsən API üçün saxla) =====

    public function me()
    {
        return response()->json(JWTAuth::user());
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Logged out']);
    }

    public function refresh()
    {
        $new = JWTAuth::refresh(JWTAuth::getToken());

        return response()->json([
            'access_token' => $new,
            'token_type'   => 'bearer',
            'expires_in'   => JWTAuth::factory()->getTTL() * 60,
        ]);
    }
}
