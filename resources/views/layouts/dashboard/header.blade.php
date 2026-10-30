<!-- Dashboard Top Header -->
<header class="sticky top-0 z-30 h-20 bg-white/90 backdrop-blur-md border-b border-slate-200/80 px-4 sm:px-6 lg:px-8 flex items-center justify-between transition-all">

    <!-- Right side: Hamburger (Mobile) & Title / Breadcrumbs -->
    <div class="flex items-center gap-4">
        <!-- Mobile Sidebar Toggle -->
        <button onclick="toggleSidebar(true)"
            class="lg:hidden p-2.5 rounded-xl text-slate-600 hover:text-blue-900 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-600 transition-colors"
            aria-label="{{ __('فتح القائمة الجانبية') }}">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
            </svg>
        </button>

    </div>


    <!-- Left side: Actions & User Profile -->
    <div class="flex items-center gap-2 sm:gap-3">

        <!-- Language Switcher -->
        <a href="{{ route('locale.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
            class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-extrabold text-slate-700 bg-slate-100 hover:bg-blue-50 hover:text-blue-900 border border-slate-200/80 transition-colors"
            title="{{ app()->getLocale() === 'ar' ? 'Switch to English' : 'التبديل إلى العربية' }}">
            <i class="fa-solid fa-globe text-blue-600"></i>
            <span>{{ app()->getLocale() === 'ar' ? 'EN' : 'عربي' }}</span>
        </a>

        <!-- Notifications Dropdown Container -->
        @php
        $unreadQuotesCount = \App\Models\QuoteRequest::unread()->count();
        $pendingQuotesCount = \App\Models\QuoteRequest::where('status', 'pending')->count();
        $headerQuotes = \App\Models\QuoteRequest::with('product')
        ->where('status', 'pending')
        ->whereNull('read_at')
        ->latest()
        ->take(4)
        ->get();

        if ($headerQuotes->count() < 4) {
            $moreQuotes=\App\Models\QuoteRequest::with('product')
            ->whereNotIn('id', $headerQuotes->pluck('id'))
            ->latest()
            ->take(4 - $headerQuotes->count())
            ->get();
            $headerQuotes = $headerQuotes->concat($moreQuotes);
            }

            $latestPortfolio = \App\Models\Portfolio::latest()->first();
            $hasNewNotifications = $unreadQuotesCount > 0;
            @endphp
            <div class="static sm:relative">
                <button id="notifications-btn"
                    onclick="toggleNotifications()"
                    class="relative p-2.5 rounded-xl text-slate-600 hover:text-blue-900 hover:bg-slate-100 focus:outline-none transition-colors"
                    aria-label="{{ __('الإشعارات') }}">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <!-- Red Alert Badge -->
                    <span id="notifications-badge-wrapper" class="{{ $hasNewNotifications ? 'flex' : 'hidden' }} absolute top-1.5 left-1.5 h-4 min-w-[16px] px-1 items-center justify-center">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span id="notifications-badge-count" data-count="{{ $unreadQuotesCount }}" class="relative inline-flex items-center justify-center rounded-full h-4 min-w-[16px] px-1 bg-red-600 text-[10px] font-bold font-mono text-white leading-none">
                            {{ $unreadQuotesCount > 99 ? '99+' : $unreadQuotesCount }}
                        </span>
                    </span>
                </button>

                <!-- Notifications Panel -->
                <div id="notifications-dropdown"
                    class="hidden absolute top-full mt-2 inset-x-3 max-w-md mx-auto sm:max-w-none sm:mx-0 sm:inset-x-auto {{ app()->getLocale() === 'ar' ? 'sm:left-0 sm:right-auto' : 'sm:right-0 sm:left-auto' }} sm:w-96 sm:mt-3 bg-white rounded-2xl shadow-2xl border border-slate-200/80 overflow-hidden z-50 animate-fade-in">
                    <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-sm text-slate-900">{{ __('الإشعارات والتنبيهات') }}</span>
                            <span id="notifications-header-badge" class="px-2 py-0.5 text-[11px] {{ $unreadQuotesCount > 0 ? 'font-bold bg-red-100 text-red-700' : 'font-medium bg-slate-100 text-slate-500' }} rounded-full">
                                {{ $unreadQuotesCount > 0 ? $unreadQuotesCount . ' ' . __('غير مقروءة') : __('لا توجد جديدة') }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button id="mark-all-read-btn"
                                type="button"
                                onclick="markAllNotificationsAsRead()"
                                class="{{ $unreadQuotesCount > 0 ? '' : 'hidden' }} text-[11px] font-bold text-blue-600 hover:text-blue-800 transition-colors">
                                {{ __('تحديد الكل كمقروء') }}
                            </button>
                            <button onclick="toggleNotifications()" class="sm:hidden p-1 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100 transition-colors" aria-label="{{ __('إغلاق') }}">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="max-h-72 sm:max-h-80 overflow-y-auto divide-y divide-slate-100 overscroll-contain">
                        @forelse($headerQuotes as $notifQuote)
                        @php
                        $isUnread = $notifQuote->is_unread;
                        @endphp
                        <a href="{{ route('admin.quote-requests.show', $notifQuote->id) }}"
                            data-notification-id="{{ $notifQuote->id }}"
                            data-mark-read-url="{{ route('admin.quote-requests.mark-read', $notifQuote->id) }}"
                            data-unread="{{ $isUnread ? '1' : '0' }}"
                            onclick="markNotificationAsRead({{ $notifQuote->id }})"
                            class="notification-item flex items-start gap-3 px-4 py-3 hover:bg-blue-50/50 transition-colors {{ $isUnread ? 'bg-red-50/20' : '' }}">
                            <div class="notification-icon w-9 h-9 rounded-xl {{ $isUnread ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-600' }} flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="flex flex-col text-xs min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="font-bold text-slate-800 leading-snug break-words truncate">
                                        {{ __('طلب تسعير:') }} {{ $notifQuote->product ? $notifQuote->product->name : __('طلب مخصص عام') }}
                                    </span>
                                    @if($isUnread)
                                    <span class="notification-unread-dot w-2 h-2 rounded-full bg-red-500 flex-shrink-0" title="{{ __('غير مقروء') }}"></span>
                                    @endif
                                </div>
                                <span class="text-slate-500 mt-0.5 leading-relaxed break-words">
                                    {{ __('العميل:') }} {{ $notifQuote->customer_name }}
                                    @if($notifQuote->quantity)
                                    ({{ __('الكمية:') }} {{ number_format($notifQuote->quantity) }} {{ __('قطعة') }})
                                    @endif
                                </span>
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-slate-400 text-[10px]">{{ $notifQuote->created_at ? $notifQuote->created_at->locale(app()->getLocale())->diffForHumans() : '' }}</span>
                                    <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded {{ $notifQuote->status_badge_classes }}">{{ $notifQuote->status_label }}</span>
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="px-4 py-8 text-center text-slate-400">
                            <svg class="w-8 h-8 mx-auto mb-2 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <p class="text-xs font-semibold text-slate-500">{{ __('لا توجد طلبات أو إشعارات جديدة حالياً') }}</p>
                        </div>
                        @endforelse

                        @if($latestPortfolio)
                        <a href="{{ route('admin.portfolios.show', $latestPortfolio->id) }}" class="flex items-start gap-3 px-4 py-3 hover:bg-blue-50/50 transition-colors">
                            <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="flex flex-col text-xs min-w-0 flex-1">
                                <span class="font-bold text-slate-800 leading-snug break-words">{{ __('آخر مشروع مضاف لمعرض الأعمال') }}</span>
                                <span class="text-slate-500 mt-0.5 leading-relaxed break-words">{{ $latestPortfolio->title }}{{ $latestPortfolio->client_name ? ' - ' . $latestPortfolio->client_name : '' }}</span>
                                <span class="text-slate-400 text-[10px] mt-1">{{ $latestPortfolio->created_at ? $latestPortfolio->created_at->locale(app()->getLocale())->diffForHumans() : '' }}</span>
                            </div>
                        </a>
                        @endif
                    </div>

                    <div class="px-4 py-2.5 border-t border-slate-100 flex items-center justify-between bg-slate-50/50 text-xs">
                        <a href="{{ route('admin.quote-requests.index', ['status' => 'pending']) }}" class="font-bold text-red-600 hover:text-red-700 transition-colors">
                            {{ __('الطلبات المعلقة') }} ({{ $pendingQuotesCount }})
                        </a>
                        <a href="{{ route('admin.quote-requests.index') }}" class="font-bold text-blue-800 hover:text-blue-600 transition-colors">
                            {{ __('عرض كافة الطلبات ←') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="h-6 w-px bg-slate-200"></div>

            <!-- User Profile Dropdown -->
            <div class="relative">
                <button id="user-menu-btn"
                    onclick="toggleUserMenu()"
                    class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-slate-100 focus:outline-none transition-colors">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-700 via-blue-600 to-red-600 p-0.5 flex items-center justify-center shadow-sm overflow-hidden">
                        @if(auth()->check() && auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover rounded-[10px]">
                        @else
                        <div class="w-full h-full bg-slate-900 rounded-[10px] flex items-center justify-center text-xs font-bold text-white uppercase">
                            {{ mb_substr(auth()->user()->name ?? 'N', 0, 1) }}
                        </div>
                        @endif
                    </div>
                    <div class="hidden xl:flex flex-col {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} max-w-[130px]">
                        <span class="text-xs font-bold text-slate-900 truncate">{{ auth()->user()->name ?? __('نبراس الإدارة') }}</span>
                        <span class="text-[10px] text-slate-400 truncate">{{ __('مدير عام') }}</span>
                    </div>
                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div id="user-dropdown-menu"
                    class="hidden absolute {{ app()->getLocale() === 'ar' ? 'left-0' : 'right-0' }} mt-3 w-56 bg-white rounded-2xl shadow-xl border border-slate-200/80 py-2 z-50 animate-fade-in">
                    <div class="px-4 py-2 border-b border-slate-100">
                        <p class="text-xs font-bold text-slate-900 truncate">{{ auth()->user()->name ?? __('نبراس العرب للمطبوعات') }}</p>
                        <p class="text-[11px] text-slate-500 font-mono truncate" dir="ltr">{{ auth()->user()->email ?? 'info@nebras-press.com' }}</p>
                    </div>
                    <div class="py-1">
                        <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs text-slate-700 hover:bg-blue-50 hover:text-blue-900 transition-colors {{ request()->routeIs('admin.profile.*') ? 'bg-blue-50/70 text-blue-900 font-bold' : '' }}">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>{{ __('الملف الشخصي') }}</span>
                        </a>
                        <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs text-slate-700 hover:bg-blue-50 hover:text-blue-900 transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-blue-50/70 text-blue-900 font-bold' : '' }}">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ __('إعدادات النظام') }}</span>
                        </a>
                    </div>
                    <div class="border-t border-slate-100 pt-1">
                        <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-xs text-red-600 hover:bg-red-50 transition-colors {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                                <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span>{{ __('تسجيل الخروج') }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

    </div>

    <script>
        function updateUnreadNotificationsUI(newCount) {
            const count = Math.max(0, parseInt(newCount, 10) || 0);
            const badgeWrapper = document.getElementById('notifications-badge-wrapper');
            const badgeCount = document.getElementById('notifications-badge-count');
            const headerBadge = document.getElementById('notifications-header-badge');
            const markAllBtn = document.getElementById('mark-all-read-btn');
            const sidebarBadge = document.getElementById('sidebar-quotes-badge');

            if (badgeCount) {
                badgeCount.dataset.count = count;
                badgeCount.textContent = count > 99 ? '99+' : count;
            }

            if (sidebarBadge) {
                sidebarBadge.textContent = count;
                if (count > 0) {
                    sidebarBadge.classList.remove('hidden');
                    sidebarBadge.classList.add('inline-flex');
                } else {
                    sidebarBadge.classList.add('hidden');
                    sidebarBadge.classList.remove('inline-flex');
                }
            }

            if (badgeWrapper) {
                if (count > 0) {
                    badgeWrapper.classList.remove('hidden');
                    badgeWrapper.classList.add('flex');
                } else {
                    badgeWrapper.classList.add('hidden');
                    badgeWrapper.classList.remove('flex');
                }
            }

            if (headerBadge) {
                if (count > 0) {
                    headerBadge.textContent = count + ' {{ __('
                    غير مقروءة ') }}';
                    headerBadge.className = 'px-2 py-0.5 text-[11px] font-bold bg-red-100 text-red-700 rounded-full';
                } else {
                    headerBadge.textContent = '{{ __('
                    لا توجد جديدة ') }}';
                    headerBadge.className = 'px-2 py-0.5 text-[11px] font-medium bg-slate-100 text-slate-500 rounded-full';
                }
            }

            if (markAllBtn) {
                if (count > 0) {
                    markAllBtn.classList.remove('hidden');
                } else {
                    markAllBtn.classList.add('hidden');
                }
            }
        }

        function markItemVisuallyAsRead(itemEl) {
            if (!itemEl) return;
            itemEl.dataset.unread = '0';
            itemEl.classList.remove('bg-red-50/20');
            const icon = itemEl.querySelector('.notification-icon');
            if (icon) {
                icon.classList.remove('bg-red-100', 'text-red-600');
                icon.classList.add('bg-amber-100', 'text-amber-600');
            }
            const dot = itemEl.querySelector('.notification-unread-dot');
            if (dot) {
                dot.remove();
            }
        }

        function markNotificationAsRead(notificationId) {
            const itemEl = document.querySelector(`.notification-item[data-notification-id="${notificationId}"]`);
            if (!itemEl || itemEl.dataset.unread !== '1') return;

            markItemVisuallyAsRead(itemEl);

            const badgeCount = document.getElementById('notifications-badge-count');
            const currentCount = badgeCount ? (parseInt(badgeCount.dataset.count, 10) || 0) : 0;
            updateUnreadNotificationsUI(currentCount - 1);

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const markReadUrl = itemEl.dataset.markReadUrl || `/admin/quote-requests/${notificationId}/mark-read`;
            fetch(markReadUrl, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': csrfToken || '',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                keepalive: true
            }).catch(() => {});
        }

        function markAllNotificationsAsRead() {
            document.querySelectorAll('.notification-item[data-unread="1"]').forEach(markItemVisuallyAsRead);
            updateUnreadNotificationsUI(0);

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            fetch(`{{ route('admin.quote-requests.mark-all-read') }}`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': csrfToken || '',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            }).catch(() => {});
        }
    </script>
</header>