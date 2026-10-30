<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Supported application locales.
     */
    public const SUPPORTED_LOCALES = ['ar', 'en'];

    /**
     * Handle an incoming request and set the active locale.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = null;

        // 1. Explicit query parameter (?lang=en or ?lang=ar)
        if ($request->has('lang') && in_array($request->query('lang'), self::SUPPORTED_LOCALES, true)) {
            $locale = $request->query('lang');
            if ($request->hasSession()) {
                $request->session()->put('locale', $locale);
            }
            Cookie::queue('locale', $locale, 60 * 24 * 365);
        }

        // 2. Session stored locale
        if (! $locale && $request->hasSession() && $request->session()->has('locale')) {
            $sessionLocale = $request->session()->get('locale');
            if (in_array($sessionLocale, self::SUPPORTED_LOCALES, true)) {
                $locale = $sessionLocale;
            }
        }

        // 3. Cookie stored locale
        if (! $locale && $request->hasCookie('locale')) {
            $cookieLocale = $request->cookie('locale');
            if (in_array($cookieLocale, self::SUPPORTED_LOCALES, true)) {
                $locale = $cookieLocale;
            }
        }

        // 4. Default locale fallback
        if (! $locale || ! in_array($locale, self::SUPPORTED_LOCALES, true)) {
            $locale = config('app.locale', 'ar');
        }

        App::setLocale($locale);
        Carbon::setLocale($locale);

        return $next($request);
    }
}

