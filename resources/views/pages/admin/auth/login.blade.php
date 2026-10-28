<!DOCTYPE html>
<html lang="ar" dir="rtl" class="h-full bg-slate-950 overflow-x-hidden">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>تسجيل الدخول إلى لوحة التحكم | مطبعة نبراس العرب</title>

    <!-- Local Fonts: Cairo -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/cairo/cairo.css') }}">

    <!-- Local Font Awesome 6 Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}">

    <!-- Local Tailwind CSS (Standalone) -->
    <script src="{{ asset('assets/vendor/tailwindcss/tailwind.min.js') }}"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-blue': {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#2563eb',
                            600: '#1d4ed8',
                            700: '#1e40af',
                            800: '#1e3a8a',
                            900: '#0f172a',
                            950: '#0a0f1d',
                        },
                        'brand-red': {
                            50: '#fef2f2',
                            100: '#fee2e2',
                            500: '#ef4444',
                            600: '#dc2626',
                            700: '#b91c1c',
                            800: '#991b1b',
                        }
                    },
                    fontFamily: {
                        sans: ['Cairo', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/app.css') }}">

    <style>
        html,
        body {
            overflow-x: hidden;
            max-width: 100vw;
        }

        /* Ambient Glow Animations */
        @keyframes float-slow {

            0%,
            100% {
                transform: translateY(0px) scale(1);
            }

            50% {
                transform: translateY(-12px) scale(1.03);
            }
        }

        @keyframes pulse-subtle {

            0%,
            100% {
                opacity: 0.35;
            }

            50% {
                opacity: 0.55;
            }
        }

        .animate-float {
            animation: float-slow 7s ease-in-out infinite;
        }

        .animate-pulse-glow {
            animation: pulse-subtle 6s ease-in-out infinite;
        }

        /* Custom pattern background */
        .pattern-grid {
            background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px);
            background-size: 28px 28px;
        }
    </style>
</head>

<body class="min-h-full font-sans text-slate-800 antialiased selection:bg-red-500 selection:text-white bg-slate-950 overflow-x-hidden">

    <div class="min-h-screen w-full flex flex-col lg:flex-row overflow-x-hidden">

        <!-- Left Side: Interactive & Artistic Brand Showcase (Visible on Large Screens) -->
        <div class="hidden lg:flex lg:w-1/2 xl:w-7/12 relative overflow-hidden bg-gradient-to-br from-slate-950 via-slate-900 to-blue-950 flex-col justify-between p-8 xl:p-14 text-white border-l border-slate-800/80">

            <!-- Background Decorative Grid & Glows -->
            <div class="absolute inset-0 pattern-grid pointer-events-none opacity-40"></div>

            <div class="absolute -top-32 -right-32 w-96 h-96 bg-blue-600/25 rounded-full blur-3xl pointer-events-none animate-pulse-glow"></div>
            <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-red-600/20 rounded-full blur-3xl pointer-events-none animate-pulse-glow" style="animation-delay: 3s;"></div>
            <div class="absolute top-1/2 left-1/3 -translate-y-1/2 w-80 h-80 bg-blue-500/15 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Top Header in Showcase -->
            <div class="relative z-10 flex flex-wrap items-center justify-between gap-3">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group" title="الانتقال للموقع الرئيسي">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-blue-700 via-blue-600 to-red-600 p-0.5 shadow-xl shadow-blue-950/60 flex items-center justify-center overflow-hidden transition-transform duration-300 group-hover:scale-105">
                        <img src="{{ asset('logo.png') }}" alt="شعار نبراس العرب" class="w-full h-full object-contain p-1.5 bg-white rounded-[14px]" onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\' viewBox=\'0 0 100 100\'><rect width=\'100%\' height=\'100%\' fill=\'%231e3a8a\'/><text x=\'50%\' y=\'50%\' dominant-baseline=\'middle\' text-anchor=\'middle\' fill=\'white\' font-family=\'sans-serif\' font-size=\'32\' font-weight=\'bold\'>NA</text></svg>';">
                    </div>
                    <div class="flex flex-col">
                        <span class="font-extrabold text-lg tracking-wide text-white group-hover:text-red-400 transition-colors">مطبعة نبراس العرب</span>
                        <span class="text-xs font-medium text-slate-400 tracking-wider">الريادة والإتقان في عالم الطباعة</span>
                    </div>
                </a>

                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-800/80 border border-slate-700/80 text-xs font-semibold text-slate-300 backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>النظام متصل وآمن</span>
                </div>
            </div>

            <!-- Central Content: Visual Feature Cards & Statement -->
            <div class="relative z-10 my-auto py-6 xl:py-8">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-500/10 border border-blue-500/30 text-blue-400 text-xs font-bold mb-6 backdrop-blur-md">
                    <i class="fa-solid fa-shield-halved text-red-500"></i>
                    <span>بوابة الإدارة المركزية</span>
                </div>

                <h1 class="text-2xl xl:text-4xl font-extrabold text-white leading-tight mb-4">
                    إدارة متطورة لكافة
                    <span class="bg-gradient-to-l from-red-500 via-red-400 to-blue-400 bg-clip-text text-transparent">عمليات الطباعة والتوزيع</span>
                </h1>

                <p class="text-slate-400 text-sm xl:text-base leading-relaxed max-w-xl mb-8 xl:mb-10">
                    منظومة إدارية شاملة ومصممة بأعلى معايير الدقة والسرعة لمتابعة المنتجات، التصنيفات، الطلبات، والتقارير الحية في مطبعة نبراس العرب.
                </p>

                <!-- 3 Highlights Cards -->
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-3.5 max-w-2xl">
                    <div class="p-4 rounded-2xl bg-slate-900/60 border border-slate-800/90 backdrop-blur-md hover:border-slate-700 transition-all duration-300">
                        <div class="w-10 h-10 rounded-xl bg-blue-600/20 text-blue-400 flex items-center justify-center mb-3 text-lg">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                        <h4 class="text-sm font-bold text-white mb-1">المنتجات والتصنيفات</h4>
                        <p class="text-xs text-slate-400 leading-normal">تحكم فوري بكافة الكتالوجات والأسعار والمخزون.</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-900/60 border border-slate-800/90 backdrop-blur-md hover:border-slate-700 transition-all duration-300">
                        <div class="w-10 h-10 rounded-xl bg-red-600/20 text-red-400 flex items-center justify-center mb-3 text-lg">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <h4 class="text-sm font-bold text-white mb-1">أداء فائق السرعة</h4>
                        <p class="text-xs text-slate-400 leading-normal">معالجة فورية للبيانات وتحديثات مستمرة في الوقت الفعلي.</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-900/60 border border-slate-800/90 backdrop-blur-md hover:border-slate-700 transition-all duration-300">
                        <div class="w-10 h-10 rounded-xl bg-emerald-600/20 text-emerald-400 flex items-center justify-center mb-3 text-lg">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <h4 class="text-sm font-bold text-white mb-1">حماية وتشفير عالي</h4>
                        <p class="text-xs text-slate-400 leading-normal">صلاحيات دقيقة وتأمين كامل لبيانات النظام والعملاء.</p>
                    </div>
                </div>
            </div>

            <!-- Bottom Footer in Showcase -->
            <div class="relative z-10 pt-6 border-t border-slate-800/80 flex flex-wrap items-center justify-between gap-3 text-xs text-slate-400">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                    <span>جميع الحقوق محفوظة &copy; {{ date('Y') }} مطبعة نبراس العرب</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="hover:text-slate-300 transition-colors">نظام الإدارة الآمن</span>
                    <span>•</span>
                    <span class="hover:text-slate-300 transition-colors">دعم تقني 24/7</span>
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form (Visible & Centered across all devices) -->
        <div class="w-full lg:w-1/2 xl:w-5/12 min-h-screen lg:min-h-0 flex items-center justify-center p-4 sm:p-8 lg:p-10 xl:p-14 bg-slate-900/90 relative overflow-hidden">

            <!-- Mobile Ambient Glows (Clipped by overflow-hidden on parent) -->
            <div class="lg:hidden absolute -top-24 -left-24 w-72 h-72 bg-blue-600/20 rounded-full blur-3xl pointer-events-none select-none"></div>
            <div class="lg:hidden absolute -bottom-24 -right-24 w-72 h-72 bg-red-600/15 rounded-full blur-3xl pointer-events-none select-none"></div>

            <div class="w-full max-w-md relative z-10 mx-auto">

                <!-- Mobile Brand Header (Hidden on Large Screens) -->
                <div class="lg:hidden flex flex-col items-center text-center mb-6 sm:mb-8">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-gradient-to-tr from-blue-700 via-blue-600 to-red-600 p-0.5 shadow-xl shadow-blue-950/70 flex items-center justify-center overflow-hidden mb-2.5">
                        <img src="{{ asset('logo.png') }}" alt="شعار نبراس العرب" class="w-full h-full object-contain p-1.5 sm:p-2 bg-white rounded-[14px]" onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\' viewBox=\'0 0 100 100\'><rect width=\'100%\' height=\'100%\' fill=\'%231e3a8a\'/><text x=\'50%\' y=\'50%\' dominant-baseline=\'middle\' text-anchor=\'middle\' fill=\'white\' font-family=\'sans-serif\' font-size=\'32\' font-weight=\'bold\'>NA</text></svg>';">
                    </div>
                    <h2 class="text-lg sm:text-xl font-extrabold text-white">مطبعة نبراس العرب</h2>
                    <p class="text-xs text-slate-400 mt-0.5">بوابة تسجيل دخول المشرفين والمديرين</p>
                </div>

                <!-- Form Card -->
                <div class="bg-slate-900/95 border border-slate-800 shadow-2xl rounded-2xl sm:rounded-3xl p-5 sm:p-8 md:p-9 backdrop-blur-xl transition-all">

                    <!-- Form Header -->
                    <div class="mb-6 sm:mb-8">
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight">تسجيل الدخول</h2>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
                            مرحباً بك مجدداً! أدخل بيانات حسابك للوصول إلى لوحة الإدارة.
                        </p>
                    </div>

                    <!-- Flash / Error Alerts -->
                    @if (session('status'))
                    <div class="mb-6 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-sm flex items-start gap-3 break-words">
                        <div class="w-6 h-6 rounded-lg bg-emerald-500/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fa-solid fa-check text-emerald-400 text-xs"></i>
                        </div>
                        <div class="flex-1 font-medium break-words">{{ session('status') }}</div>
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/30 text-red-300 text-sm flex items-start gap-3 break-words">
                        <div class="w-6 h-6 rounded-lg bg-red-500/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fa-solid fa-triangle-exclamation text-red-400 text-xs"></i>
                        </div>
                        <div class="flex-1 font-medium break-words">{{ session('error') }}</div>
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/30 text-red-300 text-sm break-words">
                        <div class="flex items-center gap-2 font-bold mb-1.5 text-red-400">
                            <i class="fa-solid fa-circle-exclamation text-xs"></i>
                            <span>تعذر تسجيل الدخول:</span>
                        </div>
                        <ul class="list-disc list-inside space-y-1 text-xs text-red-300/90 pr-2">
                            @foreach ($errors->all() as $error)
                            <li class="break-words">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Login Form -->
                    <form action="{{ route('admin.login.post') }}" method="POST" id="adminLoginForm" class="space-y-5" novalidate>
                        @csrf

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                                البريد الإلكتروني <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-regular fa-envelope text-sm"></i>
                                </div>
                                <input type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    placeholder="admin@nibras-alearab.com"
                                    class="w-full pr-11 pl-4 py-3.5 rounded-xl bg-slate-950/80 border {{ $errors->has('email') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-slate-800 focus:border-blue-500 focus:ring-blue-500' }} text-white text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-opacity-40 transition-all duration-200"
                                    dir="ltr">
                            </div>
                            @error('email')
                            <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1 font-medium">
                                <i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                                <span>{{ $message }}</span>
                            </p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
                                    كلمة المرور <span class="text-red-500">*</span>
                                </label>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-lock text-sm"></i>
                                </div>
                                <input type="password"
                                    id="password"
                                    name="password"
                                    required
                                    placeholder="••••••••"
                                    class="w-full pr-11 pl-12 py-3.5 rounded-xl bg-slate-950/80 border {{ $errors->has('password') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-slate-800 focus:border-blue-500 focus:ring-blue-500' }} text-white text-sm placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-opacity-40 transition-all duration-200"
                                    dir="ltr">

                                <!-- Password Toggle Button -->
                                <button type="button"
                                    id="togglePasswordBtn"
                                    onclick="togglePasswordVisibility()"
                                    class="absolute inset-y-0 left-0 pl-3.5 pr-2 flex items-center text-slate-400 hover:text-slate-200 focus:outline-none transition-colors"
                                    title="إظهار / إخفاء كلمة المرور"
                                    tabindex="-1">
                                    <i id="passwordToggleIcon" class="fa-regular fa-eye text-sm"></i>
                                </button>
                            </div>
                            @error('password')
                            <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1 font-medium">
                                <i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                                <span>{{ $message }}</span>
                            </p>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between pt-1">
                            <label class="relative flex items-center gap-2.5 cursor-pointer select-none group">
                                <input type="checkbox"
                                    name="remember"
                                    id="remember"
                                    {{ old('remember') ? 'checked' : '' }}
                                    class="w-4 h-4 shrink-0 rounded border-slate-700 bg-slate-950 text-blue-600 focus:ring-blue-500 focus:ring-offset-0 focus:ring-offset-slate-900 accent-blue-600 transition cursor-pointer">
                                <span class="text-xs font-medium text-slate-300 group-hover:text-white transition-colors leading-relaxed">
                                    تذكر تسجيل الدخول على هذا الجهاز
                                </span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit"
                                id="submitBtn"
                                class="w-full relative group overflow-hidden py-3.5 px-6 rounded-xl bg-gradient-to-r from-blue-700 via-blue-600 to-red-600 hover:from-blue-600 hover:via-blue-500 hover:to-red-500 active:scale-[0.99] text-white font-bold text-sm shadow-lg shadow-blue-600/30 hover:shadow-xl hover:shadow-blue-600/40 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-slate-900 transition-all duration-200 flex items-center justify-center gap-2.5">

                                <span id="btnText" class="flex items-center gap-2">
                                    <span>تسجيل الدخول</span>
                                    <i class="fa-solid fa-arrow-left text-xs transition-transform duration-200 group-hover:-translate-x-1"></i>
                                </span>

                                <span id="btnSpinner" class="hidden items-center gap-2">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span>جاري التحقق والمتابعة...</span>
                                </span>
                            </button>
                        </div>
                    </form>

                    <!-- Security & Encryption Badge -->
                    <div class="mt-8 pt-6 border-t border-slate-800/80 flex items-center justify-center gap-2 text-slate-400 text-xs">
                        <i class="fa-solid fa-lock text-emerald-400 text-xs"></i>
                        <span>جلسة عمل مؤمنة بتشفير 256-Bit SSL قياسي</span>
                    </div>

                </div>

            </div>
        </div>

    </div>

    <!-- Client-Side Interactive Scripts -->
    <script>
        // Password Visibility Toggle
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('passwordToggleIcon');

            if (!passwordInput || !toggleIcon) return;

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash', 'text-blue-400');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash', 'text-blue-400');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Handle Form Submission State
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('adminLoginForm');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnSpinner = document.getElementById('btnSpinner');

            if (form && submitBtn) {
                form.addEventListener('submit', function(e) {
                    // Check form validity
                    if (!form.checkValidity()) {
                        return;
                    }

                    // Show loading state
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-90', 'cursor-not-allowed');
                    if (btnText) btnText.classList.add('hidden');
                    if (btnSpinner) {
                        btnSpinner.classList.remove('hidden');
                        btnSpinner.classList.add('flex');
                    }
                });
            }

            // Auto-focus on appropriate field
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            if (emailInput && emailInput.value.trim() !== '' && passwordInput) {
                passwordInput.focus();
            }
        });
    </script>
</body>

</html>