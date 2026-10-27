<!-- Dashboard Top Header -->
<header class="sticky top-0 z-30 h-20 bg-white/90 backdrop-blur-md border-b border-slate-200/80 px-4 sm:px-6 lg:px-8 flex items-center justify-between transition-all">
    
    <!-- Right side: Hamburger (Mobile) & Title / Breadcrumbs -->
    <div class="flex items-center gap-4">
        <!-- Mobile Sidebar Toggle -->
        <button onclick="toggleSidebar(true)" 
                class="lg:hidden p-2.5 rounded-xl text-slate-600 hover:text-blue-900 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-600 transition-colors"
                aria-label="فتح القائمة الجانبية">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
            </svg>
        </button>

    </div>


    <!-- Left side: Actions & User Profile -->
    <div class="flex items-center gap-2 sm:gap-3">
        

        <!-- Notifications Dropdown Container -->
        <div class="static sm:relative">
            <button id="notifications-btn"
                    onclick="toggleNotifications()"
                    class="relative p-2.5 rounded-xl text-slate-600 hover:text-blue-900 hover:bg-slate-100 focus:outline-none transition-colors"
                    aria-label="الإشعارات">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <!-- Red Alert Badge -->
                <span class="absolute top-2 left-2 flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-600"></span>
                </span>
            </button>

            <!-- Notifications Panel -->
            <div id="notifications-dropdown" 
                 class="hidden absolute top-full mt-2 inset-x-3 max-w-md mx-auto sm:max-w-none sm:mx-0 sm:inset-x-auto sm:left-0 sm:right-auto sm:w-96 sm:mt-3 bg-white rounded-2xl shadow-2xl border border-slate-200/80 overflow-hidden z-50 animate-fade-in">
                <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-sm text-slate-900">الإشعارات والتنبيهات</span>
                        <span class="px-2 py-0.5 text-[11px] font-bold rounded-full bg-red-100 text-red-700">3 جديدة</span>
                    </div>
                    <button onclick="toggleNotifications()" class="sm:hidden p-1 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100 transition-colors" aria-label="إغلاق">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="max-h-72 sm:max-h-80 overflow-y-auto divide-y divide-slate-100 overscroll-contain">
                    <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-blue-50/50 transition-colors">
                        <div class="w-9 h-9 rounded-xl bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="flex flex-col text-xs min-w-0 flex-1">
                            <span class="font-bold text-slate-800 leading-snug break-words">طلب عرض سعر جديد (علب شحن فاخرة)</span>
                            <span class="text-slate-500 mt-0.5 leading-relaxed break-words">من العميل: شركة الأفق للتجارة (الكمية: 2,000 قطعة)</span>
                            <span class="text-slate-400 text-[10px] mt-1">منذ 10 دقائق</span>
                        </div>
                    </a>
                    <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-blue-50/50 transition-colors">
                        <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <div class="flex flex-col text-xs min-w-0 flex-1">
                            <span class="font-bold text-slate-800 leading-snug break-words">استفسار واتساب مباشر</span>
                            <span class="text-slate-500 mt-0.5 leading-relaxed break-words">عميل يستفسر عن طباعة كروت شخصية مع بصمة ذهبية</span>
                            <span class="text-slate-400 text-[10px] mt-1">منذ 35 دقيقة</span>
                        </div>
                    </a>
                    <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-blue-50/50 transition-colors">
                        <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex flex-col text-xs min-w-0 flex-1">
                            <span class="font-bold text-slate-800 leading-snug break-words">تم إضافة مشروع لمعرض الأعمال</span>
                            <span class="text-slate-500 mt-0.5 leading-relaxed break-words">مشروع طباعة هوية متجر ركن القهوة</span>
                            <span class="text-slate-400 text-[10px] mt-1">منذ ساعتين</span>
                        </div>
                    </a>
                </div>
                <div class="px-4 py-2.5 border-t border-slate-100 text-center bg-slate-50/50">
                    <a href="#" class="text-xs font-bold text-blue-800 hover:text-red-600 transition-colors block">عرض كافة الإشعارات</a>
                </div>
            </div>
        </div>

        <div class="h-6 w-px bg-slate-200"></div>

        <!-- User Profile Dropdown -->
        <div class="relative">
            <button id="user-menu-btn"
                    onclick="toggleUserMenu()"
                    class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-slate-100 focus:outline-none transition-colors">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-700 via-blue-600 to-red-600 p-0.5 flex items-center justify-center shadow-sm">
                    <div class="w-full h-full bg-slate-900 rounded-[10px] flex items-center justify-center text-xs font-bold text-white">
                        ن
                    </div>
                </div>
                <div class="hidden xl:flex flex-col text-right">
                    <span class="text-xs font-bold text-slate-900">نبراس الإدارة</span>
                    <span class="text-[10px] text-slate-400">مدير عام</span>
                </div>
                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div id="user-dropdown-menu" 
                 class="hidden absolute left-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-slate-200/80 py-2 z-50 animate-fade-in">
                <div class="px-4 py-2 border-b border-slate-100">
                    <p class="text-xs font-bold text-slate-900">نبراس العرب للمطبوعات</p>
                    <p class="text-[11px] text-slate-500">info@nebras-press.com</p>
                </div>
                <div class="py-1">
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-xs text-slate-700 hover:bg-blue-50 hover:text-blue-900 transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>الملف الشخصي</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-xs text-slate-700 hover:bg-blue-50 hover:text-blue-900 transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>إعدادات النظام</span>
                    </a>
                </div>
                <div class="border-t border-slate-100 pt-1">
                    <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-xs text-red-600 hover:bg-red-50 transition-colors text-right">
                            <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>تسجيل الخروج</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</header>
