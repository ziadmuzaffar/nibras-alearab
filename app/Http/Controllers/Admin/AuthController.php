<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Display the split-screen login view.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('pages.admin.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => __('يرجى إدخال البريد الإلكتروني.'),
            'email.email' => __('صيغة البريد الإلكتروني المدخلة غير صحيحة.'),
            'password.required' => __('يرجى إدخال كلمة المرور.'),
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            if (!Auth::user()->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => __('هذا الحساب معطل حالياً من قِبل إدارة النظام.'),
                ])->onlyInput('email');
            }

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', __('مرحباً بك مجدداً، :name', ['name' => Auth::user()->name]));
        }

        return back()->withErrors([
            'email' => __('بيانات الدخول غير صحيحة، يرجى التأكد من البريد الإلكتروني وكلمة المرور.'),
        ])->onlyInput('email');
    }

    /**
     * Destroy an authenticated session.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('status', __('تم تسجيل الخروج بنجاح. نراك قريباً!'));
    }
}

