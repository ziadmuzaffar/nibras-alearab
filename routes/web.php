<?php

use App\Http\Middleware\SetLocale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

// Language Switcher Route
Route::get('/locale/{locale}', function (Request $request, string $locale) {
    if (in_array($locale, SetLocale::SUPPORTED_LOCALES, true)) {
        if ($request->hasSession()) {
            $request->session()->put('locale', $locale);
        }
        Cookie::queue('locale', $locale, 60 * 24 * 365);
        App::setLocale($locale);
    }

    return redirect()->back(fallback: route('website.home'));
})->name('locale.switch');

require __DIR__.'/website.php';
