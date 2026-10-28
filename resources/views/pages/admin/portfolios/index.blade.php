@extends('layouts.dashboard.app')

@section('title', 'معرض الأعمال والمشاريع')

@section('content')
<div class="space-y-6">

    <!-- Page Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                <span>معرض الأعمال والمشاريع</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">استعراض وإدارة نماذج أعمال ومشاريع عملاء مطبعة نبراس العرب</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.portfolios.create') }}"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-700 via-blue-600 to-red-600 hover:from-blue-800 hover:to-red-700 shadow-md shadow-blue-900/20 hover:shadow-lg transition-all duration-200 active:scale-[0.98]">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                <span>إضافة عمل جديد</span>
            </a>
        </div>
    </div>

    <!-- KPI Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Total Portfolios -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">إجمالي الأعمال والمشاريع</p>
                <p class="text-2xl sm:text-3xl font-black text-slate-800 mt-1">{{ number_format($stats['total']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center">
                <i class="fa-solid fa-briefcase text-xl"></i>
            </div>
        </div>

        <!-- Categorized -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">أعمال مصنفة</p>
                <p class="text-2xl sm:text-3xl font-black text-emerald-600 mt-1">{{ number_format($stats['categorized']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i class="fa-solid fa-layer-group text-xl"></i>
            </div>
        </div>

        <!-- Uncategorized -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">أعمال عامة (بدون قسم)</p>
                <p class="text-2xl sm:text-3xl font-black text-amber-600 mt-1">{{ number_format($stats['uncategorized']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <i class="fa-solid fa-folder-open text-xl"></i>
            </div>
        </div>

        <!-- Unique Clients -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">عملاء متميزون</p>
                <p class="text-2xl sm:text-3xl font-black text-purple-600 mt-1">{{ number_format($stats['clients']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                <i class="fa-solid fa-handshake text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Filters & Search Bar -->
    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('admin.portfolios.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 sm:gap-4 items-center">

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
                    placeholder="ابحث بعنوان العمل، اسم العميل، أو الوصف..."
                    class="w-full pl-4 pr-10 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                @if(request('search'))
                <a href="{{ route('admin.portfolios.index', array_merge(request()->except('search'))) }}" class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 hover:text-slate-600">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
                @endif
            </div>

            <!-- Category Filter -->
            <div class="lg:col-span-4">
                <select name="category_id"
                    class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all text-slate-700">
                    <option value="all" {{ request('category_id') === 'all' || !request()->has('category_id') ? 'selected' : '' }}>جميع التصنيفات</option>
                    <option value="uncategorized" {{ request('category_id') === 'uncategorized' ? 'selected' : '' }}>بدون تصنيف (عام)</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Sort By -->
            <div class="lg:col-span-3 flex items-center gap-2">
                <select name="sort"
                    class="w-full px-3 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all text-slate-700">
                    <option value="newest" {{ request('sort') === 'newest' || !request()->has('sort') ? 'selected' : '' }}>الأحدث أولاً</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>الأقدم أولاً</option>
                    <option value="title_asc" {{ request('sort') === 'title_asc' ? 'selected' : '' }}>الاسم (أ - ي)</option>
                    <option value="title_desc" {{ request('sort') === 'title_desc' ? 'selected' : '' }}>الاسم (ي - أ)</option>
                    <option value="client_asc" {{ request('sort') === 'client_asc' ? 'selected' : '' }}>اسم العميل</option>
                    <option value="category" {{ request('sort') === 'category' ? 'selected' : '' }}>حسب التصنيف</option>
                </select>

                <button type="submit"
                    class="py-2.5 px-4 rounded-xl text-xs sm:text-sm font-bold text-white bg-blue-700 hover:bg-blue-800 transition-colors shadow-sm flex-shrink-0">
                    تطبيق
                </button>

                @if(request()->hasAny(['search', 'category_id', 'sort']))
                <a href="{{ route('admin.portfolios.index') }}"
                    class="p-2.5 rounded-xl border border-slate-200 text-slate-500 hover:text-red-600 hover:bg-red-50 transition-colors flex-shrink-0"
                    title="إعادة ضبط الفلاتر">
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
            <span>عرض النتائج:</span>
            <span class="text-blue-700 font-bold font-mono">{{ $portfolios->count() }}</span>
            <span>من أصل</span>
            <span class="text-slate-800 font-bold font-mono">{{ $portfolios->total() }}</span>
            <span>مشروع وعمل منجز</span>
        </div>
        @if(request()->hasAny(['search', 'category_id', 'sort']))
        <a href="{{ route('admin.portfolios.index') }}" class="text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span>إلغاء التصفية</span>
        </a>
        @endif
    </div>

    <!-- Portfolios Professional Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
        @forelse ($portfolios as $portfolio)
        <div class="bg-white rounded-2xl border border-slate-200/90 hover:border-blue-400/80 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden group">

            <!-- Top Banner & Image Preview -->
            <div class="relative h-48 w-full overflow-hidden bg-slate-900 flex items-start justify-between p-4">
                @if($portfolio->image)
                <img src="{{ $portfolio->image_url }}"
                    alt="{{ $portfolio->title }}"
                    class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-85"
                    onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'300\' viewBox=\'0 0 400 300\'><rect width=\'100%\' height=\'100%\' fill=\'%231e293b\'/><text x=\'50%\' y=\'50%\' dominant-baseline=\'middle\' text-anchor=\'middle\' fill=\'%2394a3b8\' font-size=\'18\'>نبراس العرب</text></svg>';">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-900/40 to-slate-900/30"></div>
                @else
                <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900"></div>
                <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:14px_14px]"></div>
                <div class="absolute -bottom-10 -left-10 w-28 h-28 rounded-full bg-blue-500/20 blur-xl"></div>
                <div class="absolute -top-10 -right-10 w-28 h-28 rounded-full bg-red-500/15 blur-xl"></div>
                @endif

                <!-- Top Float Badges -->
                <div class="relative z-10 w-full flex items-center justify-between">
                    <!-- Category Badge -->
                    @if($portfolio->category)
                    <a href="{{ route('admin.categories.show', $portfolio->category) }}"
                        onclick="event.stopPropagation();"
                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-black/50 backdrop-blur-md text-white text-xs font-bold border border-white/10 shadow-xs hover:bg-black/70 transition-colors">
                        <span class="text-blue-400">
                            <x-category-icon :icon="$portfolio->category->icon ?? 'box'" class="w-3.5 h-3.5" />
                        </span>
                        <span class="truncate max-w-[140px]">{{ $portfolio->category->name }}</span>
                    </a>
                    @else
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-black/40 backdrop-blur-md text-slate-300 text-xs font-medium border border-white/10">
                        <i class="fa-solid fa-folder-open text-slate-400 text-xs"></i>
                        <span>عام (بدون قسم)</span>
                    </span>
                    @endif

                    <!-- ID Pill -->
                    <span class="px-2 py-0.5 rounded-md bg-black/40 backdrop-blur-md text-slate-300 font-mono text-[11px] border border-white/10">
                        #{{ $portfolio->id }}
                    </span>
                </div>
            </div>

            <!-- Card Body Content -->
            <div class="p-5 flex-1 flex flex-col justify-between">
                <div>
                    <!-- Client Badge / Tag -->
                    <div class="flex items-center justify-between -mt-9 mb-3 relative z-10">
                        @if($portfolio->client_name)
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-white shadow-md border border-slate-200/80 text-xs font-bold text-slate-800">
                            <div class="w-5 h-5 rounded-md bg-blue-100 text-blue-700 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-user-tie text-[10px]"></i>
                            </div>
                            <span class="truncate max-w-[190px]" title="{{ $portfolio->client_name }}">{{ $portfolio->client_name }}</span>
                        </div>
                        @else
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-white/90 shadow-md border border-slate-200/80 text-xs font-medium text-slate-400">
                            <i class="fa-solid fa-building text-slate-400 text-[10px]"></i>
                            <span>عميل خاص / غير محدد</span>
                        </div>
                        @endif

                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-lg border border-slate-200/60">
                            <i class="fa-solid fa-camera text-blue-600 text-xs"></i>
                            <span>معرض الصور</span>
                        </span>
                    </div>

                    <!-- Portfolio Title -->
                    <div class="space-y-1.5">
                        <a href="{{ route('admin.portfolios.show', $portfolio) }}"
                            class="block text-base sm:text-lg font-black text-slate-900 group-hover:text-blue-700 transition-colors line-clamp-1"
                            title="{{ $portfolio->title }}">
                            {{ $portfolio->title }}
                        </a>
                    </div>

                    <!-- Description -->
                    <p class="text-xs text-slate-500 line-clamp-2 mt-2 leading-relaxed min-h-[2.5rem]">
                        {{ $portfolio->description ?: 'لا يوجد وصف تفصيلي مضاف لهذا المشروع حالياً.' }}
                    </p>

                    <!-- Client & Category info pills -->
                    <div class="grid grid-cols-2 gap-2 mt-4">
                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-tag text-xs"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] text-slate-400 font-semibold leading-none">القسم</p>
                                <p class="text-xs font-bold text-slate-800 mt-1 truncate">
                                    {{ $portfolio->category?->name ?? 'بدون تصنيف' }}
                                </p>
                            </div>
                        </div>

                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-user-check text-xs"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] text-slate-400 font-semibold leading-none">الجهة والعميل</p>
                                <p class="text-xs font-bold text-slate-800 mt-1 truncate">
                                    {{ $portfolio->client_name ?: 'مطبوعات نبراس' }}
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
                        <span>تاريخ الإضافة</span>
                    </span>
                    <span class="font-mono text-[11px] text-slate-500 font-semibold">
                        {{ $portfolio->created_at ? $portfolio->created_at->format('Y-m-d') : '—' }}
                    </span>
                </div>
            </div>

            <!-- Card Bottom Actions -->
            <div class="px-4 py-3 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between gap-2">
                <!-- View Details -->
                <a href="{{ route('admin.portfolios.show', $portfolio) }}"
                    class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:text-blue-700 hover:border-blue-300 hover:bg-blue-50/50 shadow-xs transition-all">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <span>عرض</span>
                </a>

                <!-- Edit -->
                <a href="{{ route('admin.portfolios.edit', $portfolio) }}"
                    class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl bg-blue-50 border border-blue-200/80 text-xs font-bold text-blue-700 hover:bg-blue-100 hover:border-blue-300 shadow-xs transition-all">
                    <svg class="w-3.5 h-3.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>تعديل</span>
                </a>

                <!-- Delete Modal Trigger -->
                <button type="button"
                    onclick="openDeleteModal('{{ $portfolio->id }}', '{{ addslashes($portfolio->title) }}')"
                    class="p-2 rounded-xl text-slate-400 hover:text-red-600 hover:bg-red-50 border border-transparent hover:border-red-200 transition-colors"
                    title="حذف هذا العمل">
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
                    <i class="fa-solid fa-briefcase text-3xl"></i>
                </div>
                <h3 class="text-lg font-black text-slate-800">لا توجد أعمال أو مشاريع حالياً</h3>
                <p class="text-xs sm:text-sm text-slate-500 mt-1 mb-6 leading-relaxed">
                    @if(request()->hasAny(['search', 'category_id', 'sort']))
                    لم نجد أي عمل يطابق شروط البحث والفلاتر الحالية. جرب تعديل الفلاتر أو إعادة ضبطها.
                    @else
                    ابدأ بإضافة أول مشروع أو عمل منفذ لمطبعة نبراس العرب لتظهر في معرض وسابقة الأعمال.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'category_id', 'sort']))
                <a href="{{ route('admin.portfolios.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>إعادة ضبط الفلاتر</span>
                </a>
                @else
                <a href="{{ route('admin.portfolios.create') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-blue-700 to-blue-600 hover:from-blue-800 hover:to-blue-700 shadow-md shadow-blue-900/20 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>إضافة عمل جديد</span>
                </a>
                @endif
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($portfolios->hasPages())
    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        {{ $portfolios->links() }}
    </div>
    @endif

</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-200">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 text-right space-y-4">

        <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </div>

        <div>
            <h3 class="text-lg font-bold text-slate-900">تأكيد حذف العمل من المعرض</h3>
            <p class="text-sm text-slate-500 mt-1">
                هل أنت متأكد من رغبتك في حذف العمل: <strong id="modal-portfolio-title" class="text-slate-800"></strong>؟
            </p>
            <p class="text-xs text-red-500 mt-2">
                سيتم حذف سجل المشروع نهائياً وإزالة الصورة المرتبطة به من الخادم.
            </p>
        </div>

        <form id="delete-form" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button"
                    onclick="closeDeleteModal()"
                    class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 text-sm font-semibold hover:bg-slate-100 transition-colors">
                    إلغاء
                </button>
                <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-bold shadow-md shadow-red-900/20 transition-all">
                    تأكيد الحذف
                </button>
            </div>
        </form>

    </div>
</div>

@push('scripts')
<script>
    function openDeleteModal(portfolioId, portfolioTitle) {
        const modal = document.getElementById('delete-modal');
        const form = document.getElementById('delete-form');
        const titleEl = document.getElementById('modal-portfolio-title');

        form.action = `/admin/portfolios/${portfolioId}`;
        titleEl.textContent = portfolioTitle;

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
