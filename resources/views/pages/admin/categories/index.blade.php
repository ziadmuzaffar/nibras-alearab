@extends('layouts.dashboard.app')

@php
    $isRtl = LaravelLocalization::getCurrentLocaleDirection() === 'rtl';
    $currentLocale = LaravelLocalization::getCurrentLocale();
    $otherLocale = $currentLocale === 'ar' ? 'en' : 'ar';
@endphp

@section('title', __('main.categories_management'))

@section('content')
<div class="space-y-6">

    <!-- Page Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                <span>{{ __('main.categories_management') }}</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">{{ __('main.categories_management_desc') }}</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.categories.create') }}"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-700 via-blue-600 to-red-600 hover:from-blue-800 hover:to-red-700 shadow-md shadow-blue-900/20 hover:shadow-lg transition-all duration-200 active:scale-[0.98]">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                <span>{{ __('main.add_new_category') }}</span>
            </a>
        </div>
    </div>

    <!-- KPI Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Total -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">{{ __('main.total_categories') }}</p>
                <p class="text-2xl sm:text-3xl font-black text-slate-800 mt-1">{{ number_format($stats['total']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
            </div>
        </div>

        <!-- Active -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">{{ __('main.active_categories') }}</p>
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
                <p class="text-xs font-semibold text-slate-400">{{ __('main.inactive_categories') }}</p>
                <p class="text-2xl sm:text-3xl font-black text-amber-600 mt-1">{{ number_format($stats['inactive']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
            </div>
        </div>

        <!-- With Products -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">{{ __('main.categories_with_products') }}</p>
                <p class="text-2xl sm:text-3xl font-black text-indigo-600 mt-1">{{ number_format($stats['with_products']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Filters & Search Bar -->
    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('admin.categories.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 sm:gap-4 items-center">

            <!-- Search Query -->
            <div class="lg:col-span-5 relative">
                <div class="absolute inset-y-0 {{ $isRtl ? 'right-0 pr-3.5' : 'left-0 pl-3.5' }} flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="{{ __('main.search_categories_placeholder') }}"
                    class="w-full {{ $isRtl ? 'pr-10 pl-4' : 'pl-10 pr-4' }} py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                @if(request('search'))
                <a href="{{ route('admin.categories.index', array_merge(request()->except('search'))) }}" class="absolute inset-y-0 {{ $isRtl ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center text-slate-400 hover:text-slate-600">
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
                    <option value="all" {{ request('status') === 'all' || !request()->has('status') ? 'selected' : '' }}>{{ __('main.all_statuses') }}</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>{{ __('main.status_active_only') }}</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>{{ __('main.status_inactive_only') }}</option>
                </select>
            </div>

            <!-- Sort Option -->
            <div class="lg:col-span-2">
                <select name="sort"
                    class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all text-slate-700">
                    <option value="order_asc" {{ request('sort') === 'order_asc' ? 'selected' : '' }}>{{ __('main.sort_order_asc') }}</option>
                    <option value="order_desc" {{ request('sort') === 'order_desc' ? 'selected' : '' }}>{{ __('main.sort_order_desc') }}</option>
                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>{{ __('main.sort_name_az') }}</option>
                    <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>{{ __('main.sort_name_za') }}</option>
                    <option value="products_desc" {{ request('sort') === 'products_desc' ? 'selected' : '' }}>{{ __('main.sort_most_products') }}</option>
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>{{ __('main.sort_newest_first') }}</option>
                </select>
            </div>

            <!-- Submit & Reset Actions -->
            <div class="lg:col-span-2 flex items-center gap-2">
                <button type="submit"
                    class="flex-1 py-2.5 px-4 rounded-xl text-xs sm:text-sm font-bold text-white bg-blue-700 hover:bg-blue-800 transition-colors shadow-sm">
                    {{ __('main.apply') }}
                </button>
                @if(request()->hasAny(['search', 'status', 'sort']))
                <a href="{{ route('admin.categories.index') }}"
                    class="p-2.5 rounded-xl border border-slate-200 text-slate-500 hover:text-red-600 hover:bg-red-50 transition-colors"
                    title="{{ __('main.reset_filters_btn') }}">
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
            <span>{{ __('main.showing_results') }}</span>
            <span class="text-blue-700 font-bold font-mono">{{ $categories->count() }}</span>
            <span>{{ __('main.out_of') }}</span>
            <span class="text-slate-800 font-bold font-mono">{{ $categories->total() }}</span>
            <span>{{ __('main.category_unit') }}</span>
        </div>
        @if(request()->hasAny(['search', 'status', 'sort']))
        <a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span>{{ __('main.reset_filter') }}</span>
        </a>
        @endif
    </div>

    <!-- Categories Professional Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
        @forelse ($categories as $category)
        <div class="bg-white rounded-2xl border border-slate-200/90 hover:border-blue-400/80 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden group">

            <!-- Top Banner & Badges -->
            <div class="relative h-36 w-full overflow-hidden bg-slate-900 flex items-start justify-between p-4">
                @if($category->image)
                <img src="{{ asset($category->image) }}"
                    alt="{{ $category->name }}"
                    class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-60"
                    onerror="this.style.display='none'">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-900/40 to-slate-900/30"></div>
                @else
                <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900"></div>
                <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:14px_14px]"></div>
                <div class="absolute -bottom-10 -left-10 w-28 h-28 rounded-full bg-blue-500/20 blur-xl"></div>
                <div class="absolute -top-10 -right-10 w-28 h-28 rounded-full bg-red-500/15 blur-xl"></div>
                @endif

                <!-- Top Float Badges -->
                <div class="relative z-10 w-full flex items-center justify-between">
                    <!-- Order Badge -->
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-black/40 backdrop-blur-md text-white text-xs font-bold border border-white/10 shadow-xs">
                        <span class="text-slate-400 text-[10px]">{{ __('main.order') }}</span>
                        <span class="text-blue-300 font-mono">#{{ $category->order }}</span>
                    </span>

                    <!-- Quick Status Toggle -->
                    <form action="{{ route('admin.categories.toggle-status', $category) }}" method="POST" class="inline-block" onclick="event.stopPropagation();">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold transition-all backdrop-blur-md shadow-xs {{ $category->is_active ? 'bg-emerald-500/90 hover:bg-emerald-600 text-white border border-emerald-400/40' : 'bg-slate-800/90 hover:bg-slate-700 text-slate-300 border border-slate-700' }}"
                            title="{{ __('main.toggle_status_title') }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $category->is_active ? 'bg-white animate-pulse' : 'bg-slate-400' }}"></span>
                            <span>{{ $category->is_active ? __('main.status_enabled') : __('main.status_disabled') }}</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Card Body Content -->
            <div class="p-5 flex-1 flex flex-col justify-between">
                <div>
                    <!-- Avatar & Icon Badge -->
                    <div class="flex items-end justify-between -mt-12 mb-3 relative z-10">
                        <div class="w-16 h-16 rounded-2xl bg-white p-1.5 shadow-md border-2 border-white flex items-center justify-center overflow-hidden flex-shrink-0 group-hover:scale-105 transition-transform duration-300">
                            @if($category->image)
                            <img src="{{ asset($category->image) }}"
                                alt="{{ $category->name }}"
                                class="w-full h-full object-cover rounded-xl"
                                onerror="this.onerror=null; this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');">
                            <div class="hidden text-blue-700">
                                <x-category-icon :icon="$category->icon" class="w-8 h-8" />
                            </div>
                            @else
                            <div class="text-blue-700">
                                <x-category-icon :icon="$category->icon" class="w-8 h-8" />
                            </div>
                            @endif
                        </div>

                        <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-lg border border-slate-200/60" title="{{ __('main.category_icon') }}">
                            <i class="fa-solid fa-icons text-blue-600 text-xs"></i>
                            <span class="font-mono text-[10px]">{{ $category->icon ?: 'box' }}</span>
                        </span>
                    </div>

                    <!-- Category Name & Slug (Spatie Translatable Bilingual Support) -->
                    <div class="space-y-1">
                        <a href="{{ route('admin.categories.show', $category) }}"
                            class="block text-base sm:text-lg font-black text-slate-900 group-hover:text-blue-700 transition-colors line-clamp-1">
                            {{ $category->name }}
                        </a>
                        @php
                            $secondaryName = $category->getTranslation('name', $otherLocale, false);
                        @endphp
                        @if($secondaryName && $secondaryName !== $category->name)
                        <p class="text-xs text-slate-400 font-medium truncate" dir="{{ $otherLocale === 'ar' ? 'rtl' : 'ltr' }}">
                            {{ $secondaryName }}
                        </p>
                        @endif
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center gap-1 font-mono text-[11px] text-slate-500 bg-slate-50 border border-slate-200/60 px-2 py-0.5 rounded-md" dir="ltr">
                                <span class="text-slate-400">/</span>{{ $category->slug }}
                            </span>
                        </div>
                    </div>

                    <!-- Statistics Badges -->
                    <div class="grid grid-cols-2 gap-2.5 mt-4">
                        <!-- Products Count -->
                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-lg {{ $category->products_count > 0 ? 'bg-blue-100 text-blue-700' : 'bg-slate-200 text-slate-500' }} flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] text-slate-400 font-semibold leading-none">{{ __('main.products') }}</p>
                                <p class="text-sm font-black text-slate-800 mt-1 leading-none">{{ number_format($category->products_count) }}</p>
                            </div>
                        </div>

                        <!-- Portfolios Count -->
                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-lg {{ $category->portfolios_count > 0 ? 'bg-purple-100 text-purple-700' : 'bg-slate-200 text-slate-500' }} flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] text-slate-400 font-semibold leading-none">{{ __('main.portfolios') }}</p>
                                <p class="text-sm font-black text-slate-800 mt-1 leading-none">{{ number_format($category->portfolios_count) }}</p>
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
                        <span>{{ __('main.created_at_label') }}</span>
                    </span>
                    <span class="font-mono text-[11px] text-slate-500 font-semibold">
                        {{ $category->created_at ? $category->created_at->format('Y-m-d') : '—' }}
                    </span>
                </div>
            </div>

            <!-- Card Bottom Actions -->
            <div class="px-4 py-3 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between gap-2">
                <!-- View Details -->
                <a href="{{ route('admin.categories.show', $category) }}"
                    class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:text-blue-700 hover:border-blue-300 hover:bg-blue-50/50 shadow-xs transition-all">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <span>{{ __('main.view') }}</span>
                </a>

                <!-- Edit -->
                <a href="{{ route('admin.categories.edit', $category) }}"
                    class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl bg-blue-50 border border-blue-200/80 text-xs font-bold text-blue-700 hover:bg-blue-100 hover:border-blue-300 shadow-xs transition-all">
                    <svg class="w-3.5 h-3.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>{{ __('main.edit') }}</span>
                </a>

                <!-- Delete Modal Trigger -->
                <button type="button"
                    onclick="openDeleteModal('{{ $category->id }}', '{{ addslashes($category->name) }}', {{ $category->products_count }})"
                    class="p-2 rounded-xl text-slate-400 hover:text-red-600 hover:bg-red-50 border border-transparent hover:border-red-200 transition-colors"
                    title="{{ __('main.delete_category') }}">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <h3 class="text-lg font-black text-slate-800">{{ __('main.no_categories_found') }}</h3>
                <p class="text-xs sm:text-sm text-slate-500 mt-1 mb-6 leading-relaxed">
                    @if(request()->hasAny(['search', 'status', 'sort']))
                    {{ __('main.no_categories_search_match') }}
                    @else
                    {{ __('main.start_adding_category_hint') }}
                    @endif
                </p>
                @if(request()->hasAny(['search', 'status', 'sort']))
                <a href="{{ route('admin.categories.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>{{ __('main.reset_filters_btn') }}</span>
                </a>
                @else
                <a href="{{ route('admin.categories.create') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-blue-700 to-blue-600 hover:from-blue-800 hover:to-blue-700 shadow-md shadow-blue-900/20 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>{{ __('main.add_new_category') }}</span>
                </a>
                @endif
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($categories->hasPages())
    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        {{ $categories->links() }}
    </div>
    @endif

</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-200">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 {{ $isRtl ? 'text-right' : 'text-left' }} space-y-4">

        <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </div>

        <div>
            <h3 class="text-lg font-bold text-slate-900">{{ __('main.confirm_delete_category') }}</h3>
            <p class="text-sm text-slate-500 mt-1">
                {{ __('main.confirm_delete_question') }} <strong id="modal-category-name" class="text-slate-800"></strong>؟
            </p>
            <div id="modal-products-warning" class="hidden mt-3 p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs">
                ⚠️ {{ __('main.category_has_products_warning') }}
            </div>
        </div>

        <form id="delete-form" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button"
                    onclick="closeDeleteModal()"
                    class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-sm font-semibold hover:bg-slate-100 transition-colors">
                    {{ __('main.cancel') }}
                </button>
                <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-bold shadow-md shadow-red-900/20 transition-all">
                    {{ __('main.confirm_delete_btn') }}
                </button>
            </div>
        </form>

    </div>
</div>

@push('scripts')
<script>
    function openDeleteModal(categoryId, categoryName, productsCount) {
        const modal = document.getElementById('delete-modal');
        const form = document.getElementById('delete-form');
        const nameEl = document.getElementById('modal-category-name');
        const warningEl = document.getElementById('modal-products-warning');

        form.action = `/admin/categories/${categoryId}`;
        nameEl.textContent = categoryName;

        if (productsCount > 0) {
            warningEl.classList.remove('hidden');
        } else {
            warningEl.classList.add('hidden');
        }

        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100', 'pointer-events-auto');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.add('opacity-0', 'pointer-events-none');
        modal.classList.remove('opacity-100', 'pointer-events-auto');
    }

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });
</script>
@endpush
@endsection
