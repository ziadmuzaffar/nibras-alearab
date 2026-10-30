<!-- Dashboard Sidebar -->
@php
    $isRtl = app()->getLocale() === 'ar';
    $activeLinkClasses = $isRtl
        ? 'bg-gradient-to-l from-blue-600 to-blue-700 text-white shadow-md shadow-blue-900/40 border-r-4 border-red-500'
        : 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md shadow-blue-900/40 border-l-4 border-red-500';
@endphp
<aside id="dashboard-sidebar"
    class="fixed top-0 {{ $isRtl ? 'right-0 border-l translate-x-full' : 'left-0 border-r -translate-x-full' }} z-50 h-screen w-72 bg-gradient-to-b from-slate-900 via-slate-900 to-blue-950 text-white flex flex-col border-slate-800 shadow-2xl transition-transform duration-300 ease-in-out lg:translate-x-0">

    <!-- Brand / Logo Header -->
    <div class="h-20 flex items-center justify-between px-6 border-b border-slate-800/80 bg-slate-950/40">
        <a href="{{ url('/admin') }}" class="flex items-center gap-3 group">
            <div class="relative w-11 h-11 rounded-xl bg-gradient-to-tr from-blue-700 via-blue-600 to-red-600 p-0.5 shadow-lg shadow-blue-950/50 flex items-center justify-center overflow-hidden">
                <img src="{{ setting_image('site_logo', 'logo.png') }}" alt="{{ setting('site_name', 'نبراس العرب') }}" class="w-full h-full object-contain p-1 bg-white rounded-[10px]" onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\' viewBox=\'0 0 100 100\'><rect width=\'100%\' height=\'100%\' fill=\'%231e3a8a\'/><text x=\'50%\' y=\'50%\' dominant-baseline=\'middle\' text-anchor=\'middle\' fill=\'white\' font-family=\'sans-serif\' font-size=\'32\' font-weight=\'bold\'>NA</text></svg>';">
            </div>
            <div class="flex flex-col">
                <span class="font-extrabold text-base tracking-wide text-white group-hover:text-red-400 transition-colors">{{ setting('site_name', 'نبراس العرب') }}</span>
                <span class="text-[10px] font-medium text-slate-400 tracking-wider truncate max-w-[140px]">{{ setting('site_tagline', 'للمطبوعات | لوحة التحكم') }}</span>
            </div>
        </a>

        <!-- Mobile Close Button -->
        <button onclick="toggleSidebar(false)"
            class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 focus:outline-none"
            aria-label="{{ __('إغلاق القائمة') }}">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>


    <!-- Navigation Menu Items -->
    <nav class="flex-1 overflow-y-auto px-4 py-5 space-y-1.5 scrollbar-thin">

        <div class="px-3 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">{{ __('القائمة الرئيسية') }}</div>

        <!-- Dashboard Link -->
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center justify-between px-3.5 py-3 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? $activeLinkClasses : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }}">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>{{ __('لوحة التحكم') }}</span>
            </div>
        </a>

        <!-- Products -->
        <a href="{{ route('admin.products.index') }}"
            class="flex items-center justify-between px-3.5 py-3 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.products.*') ? $activeLinkClasses : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }} group">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.products.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <span>{{ __('إدارة المنتجات') }}</span>
            </div>
        </a>

        <!-- Categories -->
        <a href="{{ route('admin.categories.index') }}"
            class="flex items-center justify-between px-3.5 py-3 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.categories.*') ? $activeLinkClasses : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }} group">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                <span>{{ __('إدارة التصنيفات') }}</span>
            </div>
        </a>

        <!-- Users -->
        <a href="{{ route('admin.users.index') }}"
            class="flex items-center justify-between px-3.5 py-3 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.users.*') ? $activeLinkClasses : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }} group">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span>{{ __('إدارة المستخدمين') }}</span>
            </div>
        </a>

        <!-- Inquiries / Quotes with RED BADGE -->
        @php
        $unreadQuotesCount = \App\Models\QuoteRequest::unread()->count();
        @endphp
        <a href="{{ route('admin.quote-requests.index') }}"
            class="flex items-center justify-between px-3.5 py-3 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.quote-requests.*') ? $activeLinkClasses : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }} group">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.quote-requests.*') ? 'text-white' : 'text-slate-400 group-hover:text-red-400' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>{{ __('طلبات عروض الأسعار') }}</span>
            </div>
            <span id="sidebar-quotes-badge" class="{{ $unreadQuotesCount > 0 ? 'inline-flex' : 'hidden' }} items-center justify-center px-2 py-0.5 text-xs font-bold font-mono rounded-full {{ request()->routeIs('admin.quote-requests.*') ? 'bg-white text-blue-800' : 'bg-red-500 text-white animate-pulse' }} shadow-xs">
                {{ $unreadQuotesCount }}
            </span>
        </a>

        <!-- Portfolio Showcase -->
        <a href="{{ route('admin.portfolios.index') }}"
            class="flex items-center justify-between px-3.5 py-3 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.portfolios.*') ? $activeLinkClasses : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }} group">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.portfolios.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>{{ __('معرض الأعمال والمشاريع') }}</span>
            </div>
        </a>

        <div class="pt-4 px-3 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">{{ __('التواصل والإدارة') }}</div>

        <!-- Analytics & Reports -->
        <a href="{{ route('admin.reports.index') }}"
            class="flex items-center justify-between px-3.5 py-3 rounded-xl font-medium text-sm transition-all duration-150 {{ request()->routeIs('admin.reports.*') ? $activeLinkClasses : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }} group">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.reports.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span>{{ __('التقارير والإحصائيات') }}</span>
            </div>
            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded {{ request()->routeIs('admin.reports.*') ? 'bg-white/20 text-white' : 'bg-blue-900/40 text-blue-300' }}">{{ __('تحليلات') }}</span>
        </a>

        <!-- View Live Catalog -->
        <a href="{{ url('/') }}" target="_blank"
            class="mt-4 flex items-center justify-between px-3.5 py-3 rounded-xl font-medium text-sm text-blue-200 bg-blue-900/30 border border-blue-700/40 hover:bg-blue-900/60 hover:text-white transition-all duration-150">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                <span>{{ __('معاينة واجهة الموقع') }}</span>
            </div>
        </a>
    </nav>

</aside>