<!-- Dashboard Sidebar -->
<aside id="dashboard-sidebar" 
       class="fixed top-0 right-0 z-50 h-screen w-72 bg-gradient-to-b from-slate-900 via-slate-900 to-blue-950 text-white flex flex-col border-l border-slate-800 shadow-2xl transition-transform duration-300 ease-in-out translate-x-full lg:translate-x-0">
    
    <!-- Brand / Logo Header -->
    <div class="h-20 flex items-center justify-between px-6 border-b border-slate-800/80 bg-slate-950/40">
        <a href="{{ url('/admin') }}" class="flex items-center gap-3 group">
            <div class="relative w-11 h-11 rounded-xl bg-gradient-to-tr from-blue-700 via-blue-600 to-red-600 p-0.5 shadow-lg shadow-blue-950/50 flex items-center justify-center overflow-hidden">
                <img src="{{ asset('logo.png') }}" alt="شعار نبراس العرب" class="w-full h-full object-contain p-1 bg-white rounded-[10px]" onerror="this.onerror=null; this.src='https://placehold.co/100x100/1e3a8a/white?text=NA';">
            </div>
            <div class="flex flex-col">
                <span class="font-extrabold text-base tracking-wide text-white group-hover:text-red-400 transition-colors">نبراس العرب</span>
                <span class="text-[10px] font-medium text-slate-400 tracking-wider">للمطبوعات | لوحة التحكم</span>
            </div>
        </a>

        <!-- Mobile Close Button -->
        <button onclick="toggleSidebar(false)" 
                class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 focus:outline-none"
                aria-label="إغلاق القائمة">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Live Status Pill -->
    <div class="px-6 py-3 bg-blue-950/30 border-b border-slate-800/50 flex items-center justify-between text-xs">
        <div class="flex items-center gap-2">
            <span class="relative flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
            </span>
            <span class="text-slate-300 font-medium">نظام استقبال الطلبات</span>
        </div>
        <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">نشط الآن</span>
    </div>

    <!-- Navigation Menu Items -->
    <nav class="flex-1 overflow-y-auto px-4 py-5 space-y-1.5 scrollbar-thin">
        
        <div class="px-3 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">القائمة الرئيسية</div>

        <!-- Dashboard Link (Active State) -->
        <a href="{{ url('/admin') }}" 
           class="flex items-center justify-between px-3.5 py-3 rounded-xl font-medium text-sm transition-all duration-200 bg-gradient-to-l from-blue-600 to-blue-700 text-white shadow-md shadow-blue-900/40 border-r-4 border-red-500">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>لوحة التحكم والرئيسية</span>
            </div>
            <span class="w-2 h-2 rounded-full bg-red-400 animate-pulse"></span>
        </a>

        <!-- Products -->
        <a href="#" 
           class="flex items-center justify-between px-3.5 py-3 rounded-xl font-medium text-sm text-slate-300 hover:text-white hover:bg-slate-800/80 transition-all duration-150 group">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <span>إدارة المنتجات والمطبوعات</span>
            </div>
            <span class="px-2 py-0.5 text-xs rounded-md bg-slate-800 text-slate-400 font-bold group-hover:bg-blue-900/60 group-hover:text-blue-300">24</span>
        </a>

        <!-- Categories -->
        <a href="#" 
           class="flex items-center justify-between px-3.5 py-3 rounded-xl font-medium text-sm text-slate-300 hover:text-white hover:bg-slate-800/80 transition-all duration-150 group">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                <span>تصنيفات المطبوعات</span>
            </div>
            <span class="px-2 py-0.5 text-xs rounded-md bg-slate-800 text-slate-400 font-bold">8</span>
        </a>

        <!-- Inquiries / Quotes with RED BADGE -->
        <a href="#" 
           class="flex items-center justify-between px-3.5 py-3 rounded-xl font-medium text-sm text-slate-300 hover:text-white hover:bg-slate-800/80 transition-all duration-150 group">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-red-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>طلبات عروض الأسعار</span>
            </div>
            <span class="px-2.5 py-0.5 text-xs font-bold rounded-full bg-red-600 text-white shadow-sm shadow-red-900/50 animate-bounce">5 جديد</span>
        </a>

        <!-- Portfolio Showcase -->
        <a href="#" 
           class="flex items-center justify-between px-3.5 py-3 rounded-xl font-medium text-sm text-slate-300 hover:text-white hover:bg-slate-800/80 transition-all duration-150 group">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>معرض الأعمال والمشاريع</span>
            </div>
            <span class="px-2 py-0.5 text-xs rounded-md bg-slate-800 text-slate-400 font-bold">18</span>
        </a>

        <div class="pt-4 px-3 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">التواصل والإدارة</div>

        <!-- WhatsApp Inquiries -->
        <a href="#" 
           class="flex items-center justify-between px-3.5 py-3 rounded-xl font-medium text-sm text-slate-300 hover:text-white hover:bg-slate-800/80 transition-all duration-150 group">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-400 group-hover:text-emerald-300 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <span>تواصل الواتساب المباشر</span>
            </div>
            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
        </a>

        <!-- Analytics & Reports -->
        <a href="#" 
           class="flex items-center justify-between px-3.5 py-3 rounded-xl font-medium text-sm text-slate-300 hover:text-white hover:bg-slate-800/80 transition-all duration-150 group">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span>التقارير والإحصائيات</span>
            </div>
        </a>

        <!-- Store & Contact Settings -->
        <a href="#" 
           class="flex items-center justify-between px-3.5 py-3 rounded-xl font-medium text-sm text-slate-300 hover:text-white hover:bg-slate-800/80 transition-all duration-150 group">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>إعدادات المطبعة والهوية</span>
            </div>
        </a>

        <!-- View Live Catalog -->
        <a href="{{ url('/') }}" target="_blank"
           class="mt-4 flex items-center justify-between px-3.5 py-3 rounded-xl font-medium text-sm text-blue-200 bg-blue-900/30 border border-blue-700/40 hover:bg-blue-900/60 hover:text-white transition-all duration-150">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                <span>معاينة واجهة الموقع</span>
            </div>
            <span class="text-xs bg-red-600/20 text-red-300 border border-red-500/30 px-2 py-0.5 rounded">مباشر</span>
        </a>
    </nav>

    <!-- Bottom User Section -->
    <div class="p-4 border-t border-slate-800 bg-slate-950/60">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="relative w-10 h-10 rounded-xl bg-gradient-to-tr from-red-600 to-blue-600 p-0.5 flex items-center justify-center">
                    <div class="w-full h-full bg-slate-900 rounded-[10px] flex items-center justify-center text-sm font-bold text-white">
                        مدير
                    </div>
                    <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-500 border-2 border-slate-900 rounded-full"></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-xs font-bold text-white">مدير النظام</span>
                    <span class="text-[11px] text-slate-400">admin@nebras.com</span>
                </div>
            </div>

            <!-- Logout Button -->
            <button class="p-2 text-slate-400 hover:text-red-400 hover:bg-slate-800 rounded-lg transition-colors" title="تسجيل الخروج">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </button>
        </div>
    </div>
</aside>
