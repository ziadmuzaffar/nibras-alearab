@php
$navCategories = $navCategories ?? \App\Models\Category::active()->ordered()->withCount(['products' => fn($q) => $q->active()])->get();
$noticeActive = setting('header_notice_active', '1') === '1' && !empty(setting('header_notice'));
$noticeType = setting('header_notice_type', 'promo');

$noticeClasses = match($noticeType) {
'info' => 'bg-gradient-to-r from-blue-900 via-blue-700 to-indigo-800 text-white',
'warning' => 'bg-gradient-to-r from-amber-600 via-amber-500 to-orange-600 text-white',
'danger' => 'bg-gradient-to-r from-red-800 via-red-600 to-rose-700 text-white',
default => 'bg-gradient-to-r from-slate-900 via-blue-800 to-red-700 text-white',
};

$noticeIcon = match($noticeType) {
'info' => 'fa-circle-info',
'warning' => 'fa-triangle-exclamation',
'danger' => 'fa-bell',
default => 'fa-gift',
};
@endphp

<!-- Top Promotional / Announcement Banner -->
@if($noticeActive)
<div id="top-announcement-bar" class="{{ $noticeClasses }} relative z-40 px-3 sm:px-6 py-2 text-[11px] sm:text-xs md:text-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto flex items-center justify-between gap-2 sm:gap-3">
        <div class="flex items-center gap-2 min-w-0 flex-1 justify-center sm:justify-start text-center {{ app()->getLocale() === 'ar' ? 'sm:text-right' : 'sm:text-left' }}">
            <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-white/15 flex items-center justify-center shrink-0">
                <i class="fa-solid {{ $noticeIcon }} text-amber-300 text-[10px] sm:text-xs"></i>
            </span>
            <p class="font-bold leading-snug line-clamp-1 sm:line-clamp-none">
                {{ setting('header_notice') }}
            </p>
            @if(setting('enable_quotes', '1') === '1')
            <button type="button"
                onclick="openQuoteModal()"
                class="hidden md:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white text-slate-900 hover:bg-amber-300 font-extrabold text-[11px] transition-all shrink-0 shadow-sm">
                <span>{{ __('اطلب تسعيرك الآن') }}</span>
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
            </button>
            @endif
        </div>
        <button type="button"
            onclick="document.getElementById('top-announcement-bar').remove()"
            class="p-1 rounded-lg text-white/75 hover:text-white hover:bg-white/10 transition-colors shrink-0"
            aria-label="{{ __('إغلاق التنبيه') }}">
            <i class="fa-solid fa-xmark text-xs sm:text-sm"></i>
        </button>
    </div>
</div>
@endif

<!-- Main Sticky Navigation Header -->
<header id="main-navbar" class="sticky top-0 z-40 bg-white/95 backdrop-blur-xl border-b border-slate-200/80 shadow-sm shadow-slate-900/[0.03] transition-all duration-300">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 xl:px-8">
        <div class="h-16 sm:h-20 flex items-center justify-between gap-2 sm:gap-3 xl:gap-6">

            <!-- Brand Logo & Identity -->
            <a href="{{ route('website.home') }}" class="flex items-center gap-2.5 sm:gap-3 group focus:outline-none min-w-0 flex-1 lg:flex-initial">
                <div class="relative w-10 h-10 sm:w-12 sm:h-12 xl:w-14 xl:h-14 rounded-2xl bg-gradient-to-tr from-blue-900 via-blue-700 to-red-600 p-0.5 shadow-lg shadow-blue-900/15 group-hover:shadow-blue-600/25 transition-all duration-300 flex items-center justify-center overflow-hidden shrink-0">
                    <div class="w-full h-full bg-white rounded-[14px] flex items-center justify-center p-1 sm:p-1.5">
                        <img src="{{ setting_image('site_logo', 'logo.png') }}"
                            alt="{{ setting('site_name', __('نبراس العرب')) }}"
                            class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300"
                            onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\' viewBox=\'0 0 100 100\'><rect width=\'100%\' height=\'100%\' rx=\'20\' fill=\'%231e3a8a\'/><text x=\'50%\' y=\'55%\' dominant-baseline=\'middle\' text-anchor=\'middle\' fill=\'white\' font-family=\'Cairo, sans-serif\' font-size=\'36\' font-weight=\'900\'>نبراس</text></svg>';">
                    </div>
                </div>
                <div class="flex flex-col justify-center min-w-0 max-w-[175px] sm:max-w-[240px] lg:max-w-[165px] xl:max-w-[250px]">
                    <span class="text-xs sm:text-base lg:text-[13px] xl:text-lg font-black text-slate-900 tracking-tight group-hover:text-blue-700 transition-colors leading-tight truncate">
                        {{ setting('site_name', __('نبراس العرب للطباعة والتغليف')) }}
                    </span>
                    <span class="text-[10px] sm:text-[11px] xl:text-xs font-semibold text-slate-500 mt-0.5 sm:mt-1 truncate">
                        {{ setting('site_tagline', __('ريادة في عالم الطباعة الفاخرة والتغليف المبتكر')) }}
                    </span>
                </div>
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden lg:flex items-center justify-center gap-0.5 xl:gap-1.5 shrink-0">
                <a href="{{ route('website.home') }}"
                    class="inline-flex items-center justify-center h-9 xl:h-10 px-2 xl:px-3.5 rounded-xl text-xs xl:text-sm font-bold whitespace-nowrap leading-none transition-all {{ request()->routeIs('website.home') ? 'text-blue-700 bg-blue-50/90' : 'text-slate-700 hover:text-blue-700 hover:bg-slate-100/70' }}">
                    {{ __('الرئيسية') }}
                </a>

                <!-- Categories Mega Dropdown -->
                <div class="relative group flex items-center">
                    <button type="button"
                        class="inline-flex items-center justify-center gap-1 xl:gap-1.5 h-9 xl:h-10 px-2 xl:px-3.5 rounded-xl text-xs xl:text-sm font-bold whitespace-nowrap leading-none transition-all {{ request()->routeIs('website.categories.*') ? 'text-blue-700 bg-blue-50/90' : 'text-slate-700 group-hover:text-blue-700 group-hover:bg-slate-100/70 focus:text-blue-700 focus:bg-slate-100/70' }}">
                        <span>{{ __('أقسام الطباعة') }}</span>
                        <i class="fa-solid fa-chevron-down text-[9px] xl:text-[10px] text-slate-400 group-hover:text-blue-600 group-hover:rotate-180 group-focus-within:text-blue-600 group-focus-within:rotate-180 transition-transform duration-200"></i>
                    </button>

                    <!-- Mega Menu Panel -->
                    <div class="absolute {{ app()->getLocale() === 'ar' ? 'right-0' : 'left-0' }} top-full pt-3 w-[500px] xl:w-[560px] max-w-[calc(100vw-2rem)] opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 group-focus-within:opacity-100 group-focus-within:visible group-focus-within:translate-y-0 transition-all duration-200 z-50">
                        <div class="bg-white rounded-2xl shadow-2xl shadow-slate-900/15 border border-slate-200/90 p-4 xl:p-5 overflow-hidden">
                            <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                    <span class="text-xs font-black text-slate-900 uppercase tracking-wider">{{ __('تصفح حسب قسم الطباعة والتغليف') }}</span>
                                </div>
                                <a href="{{ route('website.products.index') }}" class="text-xs font-bold text-blue-600 hover:text-red-600 flex items-center gap-1 transition-colors whitespace-nowrap">
                                    <span>{{ __('عرض جميع المنتجات') }}</span>
                                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                                </a>
                            </div>

                            <div class="grid grid-cols-2 gap-2 xl:gap-2.5 max-h-[340px] overflow-y-auto pr-1">
                                @foreach($navCategories as $navCat)
                                <a href="{{ route('website.categories.show', $navCat->slug) }}"
                                    class="flex items-center gap-3 p-2 xl:p-2.5 rounded-xl hover:bg-blue-50/70 border border-transparent hover:border-blue-100 transition-all group/item">
                                    <div class="w-9 h-9 xl:w-10 xl:h-10 rounded-xl bg-slate-100 group-hover/item:bg-blue-600 text-blue-700 group-hover/item:text-white flex items-center justify-center transition-colors shrink-0">
                                        <x-category-icon :icon="$navCat->icon ?? 'box'" class="w-4 h-4 xl:w-5 xl:h-5" />
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-bold text-slate-800 group-hover/item:text-blue-800 truncate">{{ $navCat->name }}</p>
                                        <span class="text-[11px] text-slate-400 font-medium">{{ $navCat->products_count ?? 0 }} {{ __('منتج متاح') }}</span>
                                    </div>
                                </a>
                                @endforeach
                            </div>

                            <div class="mt-4 pt-3 border-t border-slate-100 bg-slate-50/70 -mx-4 xl:-mx-5 -mb-4 xl:-mb-5 px-4 xl:px-5 py-3 flex items-center justify-between gap-2">
                                <span class="text-xs text-slate-600 font-medium">{{ __('هل تبحث عن مقاسات أو مواصفات خاصة غير مدرجة؟') }}</span>
                                <button type="button" onclick="openQuoteModal()" class="text-xs font-black text-red-600 hover:text-red-700 flex items-center gap-1 whitespace-nowrap shrink-0">
                                    <span>{{ __('اطلب تسعير مخصص') }}</span>
                                    <i class="fa-solid fa-bolt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('website.products.index') }}"
                    class="inline-flex items-center justify-center h-9 xl:h-10 px-2 xl:px-3.5 rounded-xl text-xs xl:text-sm font-bold whitespace-nowrap leading-none transition-all {{ request()->routeIs('website.products.*') ? 'text-blue-700 bg-blue-50/90' : 'text-slate-700 hover:text-blue-700 hover:bg-slate-100/70' }}">
                    {{ __('المنتجات والكتالوج') }}
                </a>

                <a href="{{ route('website.portfolios.index') }}"
                    class="inline-flex items-center justify-center h-9 xl:h-10 px-2 xl:px-3.5 rounded-xl text-xs xl:text-sm font-bold whitespace-nowrap leading-none transition-all {{ request()->routeIs('website.portfolios.*') ? 'text-blue-700 bg-blue-50/90' : 'text-slate-700 hover:text-blue-700 hover:bg-slate-100/70' }}">
                    {{ __('معرض أعمالنا') }}
                </a>

                <a href="{{ route('website.about') }}"
                    class="inline-flex items-center justify-center h-9 xl:h-10 px-2 xl:px-3.5 rounded-xl text-xs xl:text-sm font-bold whitespace-nowrap leading-none transition-all {{ request()->routeIs('website.about') ? 'text-blue-700 bg-blue-50/90' : 'text-slate-700 hover:text-blue-700 hover:bg-slate-100/70' }}">
                    {{ __('من نحن') }}
                </a>

                <a href="{{ route('website.contact') }}"
                    class="inline-flex items-center justify-center h-9 xl:h-10 px-2 xl:px-3.5 rounded-xl text-xs xl:text-sm font-bold whitespace-nowrap leading-none transition-all {{ request()->routeIs('website.contact') ? 'text-blue-700 bg-blue-50/90' : 'text-slate-700 hover:text-blue-700 hover:bg-slate-100/70' }}">
                    {{ __('تواصل معنا') }}
                </a>
            </nav>

            <!-- Action Buttons (Language + Search + WhatsApp + Request Quote + Mobile Menu Button) -->
            <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
                <!-- Language Switcher -->
                <a href="{{ route('locale.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
                    title="{{ app()->getLocale() === 'ar' ? 'Switch to English' : 'التبديل إلى العربية' }}"
                    class="inline-flex items-center justify-center gap-1.5 h-9 sm:h-10 px-2.5 sm:px-3 rounded-xl bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-700 border border-slate-200/80 text-xs font-black transition-all shrink-0">
                    <i class="fa-solid fa-globe text-blue-600 text-xs"></i>
                    <span>{{ app()->getLocale() === 'ar' ? 'EN' : 'عربي' }}</span>
                </a>

                <!-- Search Button -->
                <button type="button"
                    onclick="toggleSearchModal(true)"
                    aria-label="{{ __('بحث في المنتجات') }}"
                    class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-slate-100 hover:bg-blue-50 text-slate-600 hover:text-blue-700 flex items-center justify-center transition-colors shrink-0">
                    <i class="fa-solid fa-magnifying-glass text-xs sm:text-sm"></i>
                </button>

                <!-- Quick WhatsApp Desktop Pill -->
                @if(setting('whatsapp') || setting('mobile'))
                <a href="{{ whatsapp_link() }}"
                    target="_blank"
                    rel="noopener"
                    title="{{ __('تواصل عبر واتساب') }}"
                    class="hidden sm:inline-flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white border border-emerald-200/80 transition-all shrink-0">
                    <i class="fa-brands fa-whatsapp text-base sm:text-lg"></i>
                </a>
                @endif

                <!-- Primary CTA: Request Quote -->
                @if(setting('enable_quotes', '1') === '1')
                <button type="button"
                    onclick="openQuoteModal()"
                    class="hidden sm:inline-flex items-center justify-center gap-1.5 xl:gap-2 h-9 sm:h-10 px-3 xl:px-5 rounded-xl text-xs xl:text-sm font-black text-white whitespace-nowrap leading-none bg-gradient-to-r from-blue-700 via-blue-600 to-red-600 hover:from-blue-800 hover:to-red-700 shadow-lg shadow-blue-700/20 hover:shadow-red-600/25 active:scale-[0.98] transition-all shrink-0">
                    <i class="fa-solid fa-file-invoice-dollar text-[11px] xl:text-xs"></i>
                    <span>{{ __('اطلب عرض سعر') }}</span>
                </button>
                @else
                <a href="{{ route('website.contact') }}"
                    class="hidden sm:inline-flex items-center justify-center gap-1.5 xl:gap-2 h-9 sm:h-10 px-3 xl:px-5 rounded-xl text-xs xl:text-sm font-black text-white whitespace-nowrap leading-none bg-gradient-to-r from-blue-700 to-blue-900 shadow-md transition-all shrink-0">
                    <i class="fa-solid fa-headset text-[11px] xl:text-xs"></i>
                    <span>{{ __('تواصل معنا') }}</span>
                </a>
                @endif

                <!-- Mobile Hamburger Button -->
                <button type="button"
                    onclick="toggleMobileMenu(true)"
                    aria-label="{{ __('فتح القائمة') }}"
                    class="lg:hidden w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-slate-900 text-white hover:bg-blue-700 flex items-center justify-center transition-colors shadow-sm shrink-0">
                    <i class="fa-solid fa-bars-staggered text-sm sm:text-base"></i>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Slide-Over Navigation Backdrop -->
<div id="mobile-nav-backdrop"
    onclick="toggleMobileMenu(false)"
    class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm transition-opacity duration-300 opacity-0 pointer-events-none lg:hidden">
</div>

<!-- Mobile Slide-Over Drawer -->
<aside id="mobile-nav-drawer"
    class="fixed inset-y-0 right-0 z-50 w-80 max-w-[85vw] bg-white shadow-2xl border-l border-slate-200 flex flex-col transition-transform duration-300 ease-in-out translate-x-full lg:hidden">

    <!-- Drawer Header -->
    <div class="p-3.5 sm:p-4 border-b border-slate-100 flex items-center justify-between gap-2 bg-slate-900 text-white shrink-0">
        <a href="{{ route('website.home') }}" class="flex items-center gap-2.5 min-w-0 flex-1">
            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-white p-1 flex items-center justify-center overflow-hidden shrink-0">
                <img src="{{ setting_image('site_logo', 'logo.png') }}" alt="{{ setting('site_name') }}" class="w-full h-full object-contain"
                    onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'80\' height=\'80\' viewBox=\'0 0 80 80\'><rect width=\'100%\' height=\'100%\' fill=\'%231e3a8a\'/><text x=\'50%\' y=\'55%\' dominant-baseline=\'middle\' text-anchor=\'middle\' fill=\'white\' font-size=\'24\' font-weight=\'bold\'>نبراس</text></svg>';">
            </div>
            <div class="min-w-0 flex-1">
                <p class="font-black text-xs sm:text-sm text-white leading-tight truncate">{{ setting('site_name', __('نبراس العرب')) }}</p>
                <p class="text-[10px] text-blue-300 mt-0.5 truncate">{{ setting('site_tagline', __('للطباعة والتغليف الفاخر')) }}</p>
            </div>
        </a>
        <button type="button" onclick="toggleMobileMenu(false)" aria-label="{{ __('إغلاق القائمة') }}" class="w-8 h-8 rounded-lg bg-white/10 text-slate-300 hover:text-white flex items-center justify-center shrink-0">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <!-- Mobile Search Input -->
    <div class="p-3.5 sm:p-4 border-b border-slate-100 bg-slate-50/70 shrink-0">
        <form action="{{ route('website.products.index') }}" method="GET" class="relative">
            <input type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="{{ __('ابحث عن علب، كروت، أكياس، ستيكرات...') }}"
                class="w-full pr-9 pl-3 py-2.5 rounded-xl bg-white border border-slate-200 text-xs font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-600">
            <button type="submit" aria-label="{{ __('بحث') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-blue-600">
                <i class="fa-solid fa-magnifying-glass text-xs"></i>
            </button>
        </form>
    </div>

    <!-- Drawer Links -->
    <div class="flex-1 overflow-y-auto p-3.5 sm:p-4 space-y-1">
        <a href="{{ route('website.home') }}"
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-bold {{ request()->routeIs('website.home') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100' }}">
            <i class="fa-solid fa-house w-5 text-center {{ request()->routeIs('website.home') ? 'text-white' : 'text-blue-600' }}"></i>
            <span>{{ __('الرئيسية') }}</span>
        </a>

        <a href="{{ route('website.products.index') }}"
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-bold {{ request()->routeIs('website.products.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100' }}">
            <i class="fa-solid fa-boxes-stacked w-5 text-center {{ request()->routeIs('website.products.*') ? 'text-white' : 'text-blue-600' }}"></i>
            <span>{{ __('كتالوج المنتجات') }}</span>
        </a>

        <a href="{{ route('website.portfolios.index') }}"
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-bold {{ request()->routeIs('website.portfolios.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100' }}">
            <i class="fa-solid fa-images w-5 text-center {{ request()->routeIs('website.portfolios.*') ? 'text-white' : 'text-blue-600' }}"></i>
            <span>{{ __('معرض أعمالنا ومشاريعنا') }}</span>
        </a>

        <a href="{{ route('website.about') }}"
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-bold {{ request()->routeIs('website.about') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100' }}">
            <i class="fa-solid fa-building-shield w-5 text-center {{ request()->routeIs('website.about') ? 'text-white' : 'text-blue-600' }}"></i>
            <span>{{ __('من نحن') }}</span>
        </a>

        <a href="{{ route('website.contact') }}"
            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-bold {{ request()->routeIs('website.contact') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100' }}">
            <i class="fa-solid fa-headset w-5 text-center {{ request()->routeIs('website.contact') ? 'text-white' : 'text-blue-600' }}"></i>
            <span>{{ __('تواصل معنا') }}</span>
        </a>

        <!-- Language Switcher in Mobile Drawer -->
        <a href="{{ route('locale.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
            class="flex items-center justify-between gap-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-700 border border-slate-200/70 mt-2">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-globe w-5 text-center text-blue-600"></i>
                <span>{{ app()->getLocale() === 'ar' ? 'English Language' : 'اللغة العربية' }}</span>
            </div>
            <span class="px-2 py-0.5 rounded-md bg-blue-100 text-blue-700 text-[10px] font-black">{{ app()->getLocale() === 'ar' ? 'EN' : 'AR' }}</span>
        </a>

        <!-- Categories Section in Drawer -->
        <div class="pt-3.5 mt-3 border-t border-slate-100">
            <p class="px-2 pb-2 text-[11px] font-black uppercase tracking-wider text-slate-400">{{ __('أقسام الطباعة والتغليف') }}</p>
            <div class="space-y-1">
                @foreach($navCategories as $navCat)
                <a href="{{ route('website.categories.show', $navCat->slug) }}"
                    class="flex items-center justify-between gap-2 px-3 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                    <div class="flex items-center gap-2.5 min-w-0 flex-1">
                        <x-category-icon :icon="$navCat->icon ?? 'box'" class="w-4 h-4 text-blue-600 shrink-0" />
                        <span class="truncate">{{ $navCat->name }}</span>
                    </div>
                    <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 text-[10px] font-mono shrink-0">{{ $navCat->products_count ?? 0 }}</span>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Drawer Footer Actions -->
    <div class="p-3.5 sm:p-4 border-t border-slate-100 bg-slate-50 space-y-2 shrink-0">
        @if(setting('enable_quotes', '1') === '1')
        <button type="button"
            onclick="toggleMobileMenu(false); openQuoteModal();"
            class="w-full py-2.5 sm:py-3 px-4 rounded-xl bg-gradient-to-r from-blue-700 to-red-600 text-white font-black text-xs sm:text-sm shadow-md flex items-center justify-center gap-2">
            <i class="fa-solid fa-file-invoice-dollar"></i>
            <span>{{ __('اطلب عرض سعر فوري') }}</span>
        </button>
        @endif

        <div class="grid grid-cols-2 gap-2">
            @if(setting('whatsapp') || setting('mobile'))
            <a href="{{ whatsapp_link() }}" target="_blank" rel="noopener"
                class="py-2 sm:py-2.5 px-3 rounded-xl bg-emerald-600 text-white font-bold text-xs flex items-center justify-center gap-1.5">
                <i class="fa-brands fa-whatsapp text-sm"></i>
                <span>{{ __('واتساب') }}</span>
            </a>
            @endif
            @if(setting('mobile') || setting('phone'))
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', setting('mobile', setting('phone'))) }}"
                class="py-2 sm:py-2.5 px-3 rounded-xl bg-slate-900 text-white font-bold text-xs flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-phone text-xs"></i>
                <span>{{ __('اتصال مباشر') }}</span>
            </a>
            @endif
        </div>
    </div>
</aside>

<!-- Instant Search Modal -->
<div id="website-search-modal" class="hidden fixed inset-0 z-50 flex items-start justify-center pt-12 sm:pt-24 px-3 sm:px-4">
    <div onclick="toggleSearchModal(false)" class="fixed inset-0 bg-slate-950/65 backdrop-blur-sm"></div>
    <div class="relative z-10 w-full max-w-2xl bg-white rounded-2xl sm:rounded-3xl shadow-2xl border border-slate-200 overflow-hidden">
        <form action="{{ route('website.products.index') }}" method="GET" class="p-4 sm:p-6">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] sm:text-xs font-black text-blue-700 uppercase tracking-wider flex items-center gap-1.5">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span>{{ __('البحث السريع في كتالوج نبراس العرب') }}</span>
                </span>
                <button type="button" onclick="toggleSearchModal(false)" aria-label="{{ __('إغلاق البحث') }}" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="relative flex items-center">
                <input type="text"
                    id="website-search-input"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="{{ __('ابحث عن منتج (مثال: علب عطور، كروت شخصية، أكياس ورقية)...') }}"
                    class="w-full pr-3.5 sm:pr-4 pl-20 sm:pl-28 py-3 sm:py-4 rounded-xl sm:rounded-2xl bg-slate-50 border-2 border-slate-200 focus:border-blue-600 focus:bg-white text-xs sm:text-base font-bold text-slate-900 focus:outline-none transition-all">
                <button type="submit" class="absolute {{ app()->getLocale() === 'ar' ? 'left-1.5 sm:left-2' : 'right-1.5 sm:right-2' }} px-4 sm:px-5 py-2 sm:py-2.5 rounded-lg sm:rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs sm:text-sm transition-colors">
                    {{ __('بحث') }}
                </button>
            </div>
            <div class="mt-3 sm:mt-4 flex flex-wrap items-center gap-1.5 sm:gap-2">
                <span class="text-[11px] font-bold text-slate-400">{{ __('الأكثر بحثاً:') }}</span>
                @foreach($navCategories->take(5) as $quickCat)
                <a href="{{ route('website.categories.show', $quickCat->slug) }}"
                    class="px-2.5 sm:px-3 py-1 rounded-full bg-slate-100 hover:bg-blue-50 text-slate-600 hover:text-blue-700 text-[11px] sm:text-xs font-semibold transition-colors">
                    {{ $quickCat->name }}
                </a>
                @endforeach
            </div>
        </form>
    </div>
</div>