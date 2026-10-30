<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $siteName = setting('site_name', __('مطبعة نبراس العرب للطباعة والتغليف'));
        $siteTagline = setting('site_tagline', __('ريادة في عالم الطباعة الفاخرة والتغليف المبتكر'));
        $metaDesc = View::hasSection('meta_description')
            ? View::getSection('meta_description')
            : setting('meta_description', setting('site_description', __('نبراس العرب للطباعة والتغليف بالرياض - خدمات متكاملة في الطباعة الرقمية والأوفست وتصنيع علب التغليف الفاخرة والهدايا الدعائية.')));
        $metaKeywords = setting('meta_keywords', __('مطبعة الرياض, طباعة علب كرتون, تغليف فاخر, كروت شخصية, بروشورات, نبراس العرب, طباعة أوفست'));
    @endphp

    <title>@hasSection('title')@yield('title') | {{ $siteName }}@else{{ $siteName }} — {{ $siteTagline }}@endif</title>
    <meta name="description" content="{{ $metaDesc }}">
    <meta name="keywords" content="{{ $metaKeywords }}">

    <!-- Open Graph / Social Meta -->
    <meta property="og:title" content="@hasSection('title')@yield('title') | {{ $siteName }}@else{{ $siteName }}@endif">
    <meta property="og:description" content="{{ $metaDesc }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ setting_image('site_logo', 'logo.png') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ setting_image('site_favicon', 'favicon.ico') }}">

    <!-- Local Fonts: Cairo -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/cairo/cairo.css') }}">

    <!-- Local Font Awesome 6 Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}">

    <!-- Local Tailwind CSS -->
    <script src="{{ asset('assets/vendor/tailwindcss/tailwind.min.js') }}"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-blue': {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#2563eb',
                            600: '#1d4ed8',
                            700: '#1e40af',
                            800: '#1e3a8a',
                            900: '#0f172a',
                            950: '#090d16',
                        },
                        'brand-red': {
                            50: '#fef2f2',
                            100: '#fee2e2',
                            200: '#fecaca',
                            400: '#f87171',
                            500: '#ef4444',
                            600: '#dc2626',
                            700: '#b91c1c',
                            800: '#991b1b',
                        },
                        'brand-gold': {
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                        }
                    },
                    fontFamily: {
                        sans: ['Cairo', 'system-ui', '-apple-system', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Custom Website Styles -->
    <link rel="stylesheet" href="{{ asset('assets/website/css/app.css') }}">
    <style>
        html[dir="ltr"] .fa-arrow-left:not(.no-flip),
        html[dir="ltr"] .fa-angle-left:not(.no-flip),
        html[dir="ltr"] .fa-chevron-left:not(.no-flip),
        html[dir="ltr"] .fa-arrow-right:not(.no-flip) {
            transform: scaleX(-1);
        }
    </style>

    @if(setting('google_analytics_id'))
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ setting('google_analytics_id') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ setting('google_analytics_id') }}');
    </script>
    @endif

    @if(setting('custom_header_scripts'))
        {!! setting('custom_header_scripts') !!}
    @endif

    @stack('styles')
</head>

<body class="min-h-screen flex flex-col bg-slate-50 text-slate-800 antialiased selection:bg-blue-600 selection:text-white">

    <!-- Admin Quick Control Bar (Visible only when logged in as Admin) -->
    @auth
    <div class="bg-slate-950 text-slate-300 border-b border-slate-800 px-4 py-2 text-xs z-50">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-2">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-blue-600/20 text-blue-400 border border-blue-500/30 font-bold">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                    <span>{{ __('وضع المدير') }}: {{ auth()->user()->name }}</span>
                </span>
                @if(setting('maintenance_mode', '0') === '1')
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-red-600/20 text-red-400 border border-red-500/30 font-bold">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>{{ __('وضع الصيانة مفعّل للزوار') }}</span>
                </span>
                @endif
            </div>
            <div class="flex items-center gap-4">
                @php
                    $adminUnreadQuotes = \App\Models\QuoteRequest::unread()->count();
                @endphp
                <a href="{{ route('admin.quote-requests.index') }}" class="hover:text-white transition-colors flex items-center gap-1.5">
                    <i class="fa-solid fa-file-invoice-dollar text-amber-400"></i>
                    <span>{{ __('طلبات التسعير') }}</span>
                    @if($adminUnreadQuotes > 0)
                        <span class="px-1.5 py-0.2 rounded-full bg-red-600 text-white text-[10px] font-bold font-mono">{{ $adminUnreadQuotes }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.settings.index') }}" class="hover:text-white transition-colors hidden sm:inline-flex items-center gap-1">
                    <i class="fa-solid fa-sliders text-slate-400"></i>
                    <span>{{ __('الإعدادات') }}</span>
                </a>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-blue-600 hover:bg-blue-500 text-white font-bold transition-colors">
                    <i class="fa-solid fa-gauge-high text-[11px]"></i>
                    <span>{{ __('لوحة التحكم') }}</span>
                </a>
            </div>
        </div>
    </div>
    @endauth

    <!-- Header & Navigation -->
    @include('layouts.website.header')

    <!-- Session Flash Notifications (Quote Success / Errors) -->
    @if(session('quote_success') || session('success'))
    <div id="flash-success-banner" class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-6">
        <div class="p-4 sm:p-5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 shadow-lg shadow-emerald-900/5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-start sm:items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-emerald-600 text-white flex items-center justify-center flex-shrink-0 shadow-md shadow-emerald-600/30">
                    <i class="fa-solid fa-check text-lg"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h4 class="font-black text-sm sm:text-base text-emerald-950">{{ __('تم إرسال طلبك بنجاح!') }}</h4>
                        @if(session('quote_reference'))
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 border border-emerald-300 text-emerald-800 text-xs font-mono font-bold">
                            {{ __('رقم الطلب') }}: #{{ session('quote_reference') }}
                        </span>
                        @endif
                    </div>
                    <p class="text-xs sm:text-sm text-emerald-800 mt-0.5 leading-relaxed">
                        {{ session('quote_success') ?? session('success') }}
                    </p>
                </div>
            </div>
            <button type="button" onclick="document.getElementById('flash-success-banner').remove()" class="self-end sm:self-center p-2 rounded-xl text-emerald-600 hover:bg-emerald-100 transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div id="flash-error-banner" class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-6">
        <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-900 shadow-sm flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-circle-exclamation text-lg"></i>
                </div>
                <p class="text-xs sm:text-sm font-bold">{{ session('error') }}</p>
            </div>
            <button type="button" onclick="document.getElementById('flash-error-banner').remove()" class="p-1.5 rounded-lg text-red-500 hover:bg-red-100">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div id="flash-validation-banner" class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-6">
        <div class="p-4 sm:p-5 rounded-2xl bg-amber-50 border border-amber-200 text-amber-950 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2 font-black text-sm text-amber-900">
                    <i class="fa-solid fa-triangle-exclamation text-amber-600"></i>
                    <span>{{ __('يرجى التحقق من البيانات المدخلة:') }}</span>
                </div>
                <button type="button" onclick="document.getElementById('flash-validation-banner').remove()" class="text-amber-600 hover:text-amber-800">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <ul class="list-disc list-inside text-xs sm:text-sm space-y-1 text-amber-800 pr-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- Main Page Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.website.footer')

    <!-- Universal Quick Quote Request Modal -->
    @include('layouts.website.quick-quote-modal')

    <!-- Floating Quick Actions (WhatsApp + Scroll To Top) -->
    <div class="fixed bottom-5 left-5 z-40 flex flex-col items-center gap-3">
        <!-- Scroll to Top Button -->
        <button id="scroll-to-top-btn"
            type="button"
            onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
            aria-label="{{ __('العودة للأعلى') }}"
            class="w-11 h-11 rounded-2xl bg-slate-900/90 hover:bg-blue-700 text-white shadow-xl border border-white/15 flex items-center justify-center transition-all duration-300 opacity-0 translate-y-4 pointer-events-none">
            <i class="fa-solid fa-arrow-up text-sm"></i>
        </button>

        <!-- Floating WhatsApp Button -->
        @if(setting('whatsapp') || setting('mobile'))
        <a href="{{ whatsapp_link() }}"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="{{ __('تواصل معنا عبر واتساب') }}"
            class="group relative flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-600 to-emerald-500 text-white shadow-2xl shadow-emerald-600/40 hover:scale-105 active:scale-95 transition-all duration-300">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-2xl bg-emerald-400 opacity-30"></span>
            <i class="fa-brands fa-whatsapp text-3xl relative z-10"></i>
            <!-- Tooltip -->
            <span class="hidden sm:flex items-center gap-2 absolute left-full ml-3 px-3.5 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold whitespace-nowrap shadow-xl opacity-0 -translate-x-2 pointer-events-none group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-200">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>{{ __('تحدث مع المبيعات مباشرة') }}</span>
            </span>
        </a>
        @endif
    </div>

    <!-- Global Website Interactive Scripts -->
    <script>
        // Scroll to Top Button Visibility & Sticky Header Shadow
        window.addEventListener('scroll', function () {
            const scrollBtn = document.getElementById('scroll-to-top-btn');
            const mainHeader = document.getElementById('main-navbar');

            if (scrollBtn) {
                if (window.scrollY > 350) {
                    scrollBtn.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
                    scrollBtn.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
                } else {
                    scrollBtn.classList.add('opacity-0', 'translate-y-4', 'pointer-events-none');
                    scrollBtn.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
                }
            }

            if (mainHeader) {
                if (window.scrollY > 20) {
                    mainHeader.classList.add('shadow-lg', 'shadow-slate-900/5', 'bg-white/95');
                    mainHeader.classList.remove('bg-white/90');
                } else {
                    mainHeader.classList.remove('shadow-lg', 'shadow-slate-900/5', 'bg-white/95');
                    mainHeader.classList.add('bg-white/90');
                }
            }
        });

        // Mobile Navigation Drawer Toggle
        function toggleMobileMenu(open) {
            const drawer = document.getElementById('mobile-nav-drawer');
            const backdrop = document.getElementById('mobile-nav-backdrop');
            if (!drawer || !backdrop) return;

            if (open) {
                drawer.classList.remove('translate-x-full');
                backdrop.classList.remove('opacity-0', 'pointer-events-none');
                backdrop.classList.add('opacity-100', 'pointer-events-auto');
                document.body.classList.add('overflow-hidden');
            } else {
                drawer.classList.add('translate-x-full');
                backdrop.classList.add('opacity-0', 'pointer-events-none');
                backdrop.classList.remove('opacity-100', 'pointer-events-auto');
                document.body.classList.remove('overflow-hidden');
            }
        }

        // Search Overlay Modal Toggle
        function toggleSearchModal(open) {
            const modal = document.getElementById('website-search-modal');
            const input = document.getElementById('website-search-input');
            if (!modal) return;

            if (open) {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
                setTimeout(() => {
                    if (input) input.focus();
                }, 100);
            } else {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }

        // Escape key handler for modals
        window.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                toggleMobileMenu(false);
                toggleSearchModal(false);
                if (typeof closeQuoteModal === 'function') closeQuoteModal();
                if (typeof closePortfolioModal === 'function') closePortfolioModal();
            }
        });

        // Reset mobile menu state when resizing to desktop
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 1024) {
                toggleMobileMenu(false);
            }
        });
    </script>

    @if(setting('custom_footer_scripts'))
        {!! setting('custom_footer_scripts') !!}
    @endif

    @stack('scripts')
</body>

</html>

