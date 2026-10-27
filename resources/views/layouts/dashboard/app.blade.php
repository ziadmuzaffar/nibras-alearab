<!DOCTYPE html>
<html lang="ar" dir="rtl" class="h-full bg-slate-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'لوحة التحكم') | مطبعة نبراس العرب</title>

    <!-- Google Fonts: Cairo -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
        }
    </style>
</head>

<body class="h-full text-slate-800 antialiased overflow-x-hidden selection:bg-red-500 selection:text-white">

    <div class="min-h-full flex flex-col lg:flex-row">
        <!-- Mobile Sidebar Overlay Backdrop -->
        <div id="sidebar-backdrop"
            onclick="toggleSidebar(false)"
            class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300 opacity-0 pointer-events-none lg:hidden">
        </div>

        <!-- Sidebar Component -->
        @include('layouts.dashboard.sidebar')

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 min-h-screen bg-slate-50/75 lg:mr-72 transition-all duration-300">
            <!-- Top Header -->
            @include('layouts.dashboard.header')

            <!-- Page Body -->
            <main class="flex-1 p-4 max-w-7xl w-full mx-auto">
                <!-- Session Flash Messages -->
                @if (session('success'))
                <div class="mb-6 flex items-center justify-between p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 shadow-sm transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-sm font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                @if (session('error'))
                <div class="mb-6 flex items-center justify-between p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 shadow-sm transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center text-red-600 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <p class="text-sm font-semibold">{{ session('error') }}</p>
                    </div>
                </div>
                @endif

                @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 shadow-sm">
                    <div class="flex items-center gap-2 mb-2 font-bold text-sm text-amber-800">
                        <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>يرجى تصحيح الأخطاء التالية:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 text-amber-800 pr-2">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="mt-auto py-4 px-6 border-t border-slate-200/80 bg-white/60 text-xs text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-2">
                <div class="flex items-center gap-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-red-600"></span>
                    <span>جميع الحقوق محفوظة &copy; {{ date('Y') }} <strong>مطبعة نبراس العرب</strong></span>
                </div>
                <div class="flex items-center gap-4 text-slate-400">
                    <span class="text-blue-900 font-medium">لوحة الإدارة v1.0</span>
                    <span>•</span>
                    <a href="#" class="hover:text-red-600 transition-colors">الدعم الفني</a>
                    <span>•</span>
                    <a href="#" class="hover:text-blue-700 transition-colors">دليل الاستخدام</a>
                </div>
            </footer>
        </div>
    </div>

    <!-- Interactive UI Scripts -->
    <script>
        function toggleSidebar(open) {
            const sidebar = document.getElementById('dashboard-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');

            if (open) {
                sidebar.classList.remove('translate-x-full');
                backdrop.classList.remove('opacity-0', 'pointer-events-none');
                backdrop.classList.add('opacity-100', 'pointer-events-auto');
                document.body.classList.add('overflow-hidden', 'lg:overflow-auto');
            } else {
                sidebar.classList.add('translate-x-full');
                backdrop.classList.add('opacity-0', 'pointer-events-none');
                backdrop.classList.remove('opacity-100', 'pointer-events-auto');
                document.body.classList.remove('overflow-hidden', 'lg:overflow-auto');
            }
        }

        function toggleUserMenu() {
            const menu = document.getElementById('user-dropdown-menu');
            const notif = document.getElementById('notifications-dropdown');
            if (notif && !notif.classList.contains('hidden')) {
                notif.classList.add('hidden');
            }
            if (menu) menu.classList.toggle('hidden');
        }

        function toggleNotifications() {
            const notif = document.getElementById('notifications-dropdown');
            const menu = document.getElementById('user-dropdown-menu');
            if (menu && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
            }
            if (notif) notif.classList.toggle('hidden');
        }

        // Close dropdowns when clicking outside
        window.addEventListener('click', function(e) {
            const userBtn = document.getElementById('user-menu-btn');
            const userMenu = document.getElementById('user-dropdown-menu');
            const notifBtn = document.getElementById('notifications-btn');
            const notifMenu = document.getElementById('notifications-dropdown');

            if (userBtn && userMenu && !userBtn.contains(e.target) && !userMenu.contains(e.target)) {
                userMenu.classList.add('hidden');
            }
            if (notifBtn && notifMenu && !notifBtn.contains(e.target) && !notifMenu.contains(e.target)) {
                notifMenu.classList.add('hidden');
            }
        });
    </script>
    @stack('scripts')
</body>

</html>