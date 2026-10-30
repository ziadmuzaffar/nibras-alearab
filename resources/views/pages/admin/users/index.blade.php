@extends('layouts.dashboard.app')

@section('title', __('إدارة المستخدمين'))

@section('content')
<div class="space-y-6">

    <!-- Page Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                <span>{{ __('إدارة المستخدمين') }}</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">{{ __('إدارة حسابات وبيانات المستخدمين لمطبعة نبراس العرب') }}</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.create') }}"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-700 via-blue-600 to-red-600 hover:from-blue-800 hover:to-red-700 shadow-md shadow-blue-900/20 hover:shadow-lg transition-all duration-200 active:scale-[0.98]">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                <span>{{ __('إضافة مستخدم جديد') }}</span>
            </a>
        </div>
    </div>

    <!-- KPI Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Total -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">{{ __('إجمالي المستخدمين') }}</p>
                <p class="text-2xl sm:text-3xl font-black text-slate-800 mt-1">{{ number_format($stats['total']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>

        <!-- Active -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">{{ __('الحسابات النشطة') }}</p>
                <p class="text-2xl sm:text-3xl font-black text-emerald-600 mt-1">{{ number_format($stats['active']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Inactive -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">{{ __('الحسابات المعطلة') }}</p>
                <p class="text-2xl sm:text-3xl font-black text-amber-600 mt-1">{{ number_format($stats['inactive']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
            </div>
        </div>

        <!-- Verified -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">{{ __('البريد المفعّل') }}</p>
                <p class="text-2xl sm:text-3xl font-black text-purple-600 mt-1">{{ number_format($stats['verified']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                <i class="fa-solid fa-circle-check text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Filters & Search Bar -->
    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('admin.users.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 sm:gap-4 items-center">

            <!-- Search Query -->
            <div class="lg:col-span-5 relative">
                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="{{ __('ابحث بالاسم، البريد الإلكتروني، أو الهاتف...') }}"
                    class="w-full pl-4 pr-10 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                @if(request('search'))
                <a href="{{ route('admin.users.index', array_merge(request()->except('search'))) }}" class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 hover:text-slate-600">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
                @endif
            </div>

            <!-- Status Filter -->
            <div class="lg:col-span-3">
                <select name="status"
                    class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all text-slate-700">
                    <option value="all" {{ request('status') === 'all' || !request()->has('status') ? 'selected' : '' }}>{{ __('الحالة: الكل') }}</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>{{ __('نشط فقط') }}</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>{{ __('معطل فقط') }}</option>
                </select>
            </div>

            <!-- Verified Filter -->
            <div class="lg:col-span-2">
                <select name="verified"
                    class="w-full px-3 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all text-slate-700">
                    <option value="all" {{ request('verified') === 'all' || !request()->has('verified') ? 'selected' : '' }}>{{ __('التحقق: الكل') }}</option>
                    <option value="1" {{ request('verified') === '1' ? 'selected' : '' }}>{{ __('بريد مفعّل') }}</option>
                    <option value="0" {{ request('verified') === '0' ? 'selected' : '' }}>{{ __('بريد غير مفعّل') }}</option>
                </select>
            </div>

            <!-- Submit & Reset Actions -->
            <div class="lg:col-span-2 flex items-center gap-2">
                <button type="submit"
                    class="flex-1 py-2.5 px-4 rounded-xl text-xs sm:text-sm font-bold text-white bg-blue-700 hover:bg-blue-800 transition-colors shadow-sm">
                    {{ __('تطبيق') }}
                </button>
                @if(request()->hasAny(['search', 'status', 'verified', 'sort']))
                <a href="{{ route('admin.users.index') }}"
                    class="p-2.5 rounded-xl border border-slate-200 text-slate-500 hover:text-red-600 hover:bg-red-50 transition-colors"
                    title="{{ __('إعادة ضبط الفلاتر') }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Results Counter & Info Bar -->
    <div class="flex items-center justify-between text-xs font-semibold text-slate-500 px-1">
        <div class="flex items-center gap-2">
            <span>{{ __('عرض النتائج:') }}</span>
            <span class="text-blue-700 font-bold font-mono">{{ $users->count() }}</span>
            <span>{{ __('من أصل') }}</span>
            <span class="text-slate-800 font-bold font-mono">{{ $users->total() }}</span>
            <span>{{ __('مستخدم') }}</span>
        </div>
        @if(request()->hasAny(['search', 'status', 'verified', 'sort']))
        <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span>{{ __('إلغاء التصفية') }}</span>
        </a>
        @endif
    </div>

    <!-- Users Professional Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
        @forelse ($users as $user)
        <div class="bg-white rounded-2xl border border-slate-200/90 hover:border-blue-400/80 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden group">

            <!-- Top Banner & Badges -->
            <div class="relative h-32 w-full overflow-hidden bg-slate-900 flex items-start justify-between p-4">
                <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900"></div>
                <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:14px_14px]"></div>
                <div class="absolute -bottom-8 -left-8 w-24 h-24 rounded-full bg-blue-500/20 blur-xl"></div>
                <div class="absolute -top-8 -right-8 w-24 h-24 rounded-full bg-red-500/15 blur-xl"></div>

                <!-- Top Float Badges -->
                <div class="relative z-10 w-full flex items-center justify-between">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-black/50 backdrop-blur-md text-white text-xs font-mono font-bold border border-white/10 shadow-xs">
                        <i class="fa-regular fa-id-badge text-blue-400 text-xs"></i>
                        <span>#{{ $user->id }}</span>
                    </span>

                    <!-- Quick Status Toggle -->
                    <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline-block" onclick="event.stopPropagation();">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold transition-all backdrop-blur-md shadow-xs {{ $user->is_active ? 'bg-emerald-500/90 hover:bg-emerald-600 text-white border border-emerald-400/40' : 'bg-slate-800/90 hover:bg-slate-700 text-slate-300 border border-slate-700' }}"
                            title="{{ __('انقر لتبديل حالة الحساب (نشط / معطل)') }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $user->is_active ? 'bg-white animate-pulse' : 'bg-slate-400' }}"></span>
                            <span>{{ $user->is_active ? __('نشط') : __('معطل') }}</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Card Body Content -->
            <div class="p-5 flex-1 flex flex-col justify-between">
                <div>
                    <!-- User Avatar -->
                    <div class="flex items-end justify-between -mt-14 mb-3 relative z-10">
                        <div class="w-16 h-16 rounded-2xl bg-white p-1 shadow-md border-2 border-white flex items-center justify-center overflow-hidden flex-shrink-0 group-hover:scale-105 transition-transform duration-300">
                            <img src="{{ $user->avatar_url }}"
                                alt="{{ $user->name }}"
                                class="w-full h-full object-cover rounded-xl"
                                onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=1d4ed8&background=eff6ff';">
                        </div>

                        <!-- Email Verification Status Badge -->
                        @if($user->email_verified_at)
                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200/70" title="{{ __('تم التحقق من البريد الإلكتروني') }}">
                            <i class="fa-solid fa-circle-check text-xs"></i>
                            <span>{{ __('مفعّل') }}</span>
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-amber-700 bg-amber-50 px-2.5 py-1 rounded-lg border border-amber-200/70" title="{{ __('لم يتم التحقق من البريد') }}">
                            <i class="fa-solid fa-clock text-xs"></i>
                            <span>{{ __('غير مفعّل') }}</span>
                        </span>
                        @endif
                    </div>

                    <!-- User Name & Email -->
                    <div class="space-y-1">
                        <a href="{{ route('admin.users.show', $user) }}"
                            class="block text-base sm:text-lg font-black text-slate-900 group-hover:text-blue-700 transition-colors line-clamp-1"
                            title="{{ $user->name }}">
                            {{ $user->name }}
                        </a>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 font-mono text-[11px] text-slate-500 bg-slate-50 border border-slate-200/60 px-2 py-0.5 rounded-md dir-ltr truncate max-w-[240px]">
                                <i class="fa-regular fa-envelope text-[10px] text-slate-400"></i>{{ $user->email }}
                            </span>
                        </div>
                    </div>

                    <!-- Contact & Info Badges -->
                    <div class="grid grid-cols-2 gap-2.5 mt-4">
                        <!-- Phone Number -->
                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-lg {{ $user->phone ? 'bg-blue-100 text-blue-700' : 'bg-slate-200 text-slate-500' }} flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-phone text-xs"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] text-slate-400 font-semibold leading-none">{{ __('رقم الهاتف') }}</p>
                                <p class="text-xs font-bold text-slate-800 mt-1 leading-none font-mono truncate" dir="ltr">
                                    {{ $user->phone ?: __('غير محدد') }}
                                </p>
                            </div>
                        </div>

                        <!-- Account Status Badge -->
                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-lg {{ $user->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }} flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid {{ $user->is_active ? 'fa-check' : 'fa-ban' }} text-xs"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] text-slate-400 font-semibold leading-none">{{ __('حالة الحساب') }}</p>
                                <p class="text-xs font-bold text-slate-800 mt-1 leading-none truncate">
                                    {{ $user->is_active ? __('نشط ومفعّل') : __('معطل') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Created At Info -->
                <div class="flex items-center justify-between text-xs text-slate-400 pt-3 mt-4 border-t border-slate-100">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>{{ __('تاريخ التسجيل') }}</span>
                    </span>
                    <span class="font-mono text-[11px] text-slate-500 font-semibold">
                        {{ $user->created_at ? $user->created_at->format('Y-m-d') : '—' }}
                    </span>
                </div>
            </div>

            <!-- Card Bottom Actions -->
            <div class="px-4 py-3 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between gap-2">
                <!-- View Details -->
                <a href="{{ route('admin.users.show', $user) }}"
                    class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:text-blue-700 hover:border-blue-300 hover:bg-blue-50/50 shadow-xs transition-all">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <span>{{ __('عرض') }}</span>
                </a>

                <!-- Edit -->
                <a href="{{ route('admin.users.edit', $user) }}"
                    class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl bg-blue-50 border border-blue-200/80 text-xs font-bold text-blue-700 hover:bg-blue-100 hover:border-blue-300 shadow-xs transition-all">
                    <svg class="w-3.5 h-3.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>{{ __('تعديل') }}</span>
                </a>

                <!-- Delete Modal Trigger -->
                <button type="button"
                    onclick="openDeleteModal('{{ $user->id }}', '{{ addslashes($user->name) }}')"
                    class="p-2 rounded-xl text-slate-400 hover:text-red-600 hover:bg-red-50 border border-transparent hover:border-red-200 transition-colors"
                    title="{{ __('حذف المستخدم') }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>

        </div>
        @empty
        <!-- Empty State -->
        <div class="col-span-full bg-white rounded-2xl border border-slate-200/80 p-12 text-center shadow-sm">
            <div class="max-w-md mx-auto flex flex-col items-center">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-blue-50 to-indigo-50 border border-blue-100 text-blue-600 flex items-center justify-center mb-4 shadow-inner">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-black text-slate-800">{{ __('لا يوجد مستخدمون حالياً') }}</h3>
                <p class="text-xs sm:text-sm text-slate-500 mt-1 mb-6 leading-relaxed">
                    @if(request()->hasAny(['search', 'status', 'verified', 'sort']))
                    {{ __('لم نجد أي مستخدم يطابق شروط البحث والفلاتر المحددة. جرب تعديل الفلاتر أو حذفها.') }}
                    @else
                    {{ __('ابدأ بإضافة أول مستخدم في لوحة تحكم نبراس العرب.') }}
                    @endif
                </p>
                @if(request()->hasAny(['search', 'status', 'verified', 'sort']))
                <a href="{{ route('admin.users.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>{{ __('إعادة ضبط الفلاتر') }}</span>
                </a>
                @else
                <a href="{{ route('admin.users.create') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-blue-700 to-blue-600 hover:from-blue-800 hover:to-blue-700 shadow-md shadow-blue-900/20 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>{{ __('إضافة مستخدم جديد') }}</span>
                </a>
                @endif
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($users->hasPages())
    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        {{ $users->links() }}
    </div>
    @endif

</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-200">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 text-start space-y-4">

        <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </div>

        <div>
            <h3 class="text-lg font-bold text-slate-900">{{ __('تأكيد حذف المستخدم') }}</h3>
            <p class="text-sm text-slate-500 mt-1">
                {{ __('هل أنت متأكد من رغبتك في حذف حساب المستخدم:') }} <strong id="modal-user-name" class="text-slate-800"></strong>؟
            </p>
        </div>

        <form id="delete-form" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button"
                    onclick="closeDeleteModal()"
                    class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-sm font-semibold hover:bg-slate-100 transition-colors">
                    {{ __('إلغاء') }}
                </button>
                <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-bold shadow-md shadow-red-900/20 transition-all">
                    {{ __('تأكيد الحذف') }}
                </button>
            </div>
        </form>

    </div>
</div>

@push('scripts')
<script>
    function openDeleteModal(userId, userName) {
        const modal = document.getElementById('delete-modal');
        const form = document.getElementById('delete-form');
        const nameEl = document.getElementById('modal-user-name');

        form.action = `/admin/users/${userId}`;
        nameEl.textContent = userName;

        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100', 'pointer-events-auto');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.add('opacity-0', 'pointer-events-none');
        modal.classList.remove('opacity-100', 'pointer-events-auto');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });
</script>
@endpush
@endsection