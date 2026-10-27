@extends('layouts.dashboard.app')

@section('title', 'تفاصيل التصنيف: ' . $category->name)

@php
$stats = $stats ?? [
'products_total' => $category->products_count ?? $category->products()->count(),
'products_active' => $category->active_products_count ?? $category->products()->where('is_active', true)->count(),
'products_inactive' => $category->inactive_products_count ?? $category->products()->where('is_active', false)->count(),
'products_featured' => $category->featured_products_count ?? $category->products()->where('is_featured', true)->count(),
'portfolios_total' => $category->portfolios_count ?? $category->portfolios()->count(),
'quotes_total' => \App\Models\QuoteRequest::whereIn('product_id', $category->products()->select('id'))->count(),
];
$activePercent = $stats['products_total'] > 0 ? round(($stats['products_active'] / $stats['products_total']) * 100) : 0;
@endphp

@section('content')
<div class="space-y-6">

    <!-- Header & Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                    <span>تفاصيل التصنيف</span>
                </h1>
            </div>
            <p class="text-xs sm:text-sm text-slate-500 mt-1.5">عرض كافة البيانات والمؤشرات التحليلية والمنتجات التابعة لهذا القسم</p>
        </div>

        <!-- Header Actions -->
        <div class="flex flex-wrap items-center gap-2.5">
            <!-- Back Button -->
            <a href="{{ route('admin.categories.index') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-slate-700 bg-white border border-slate-200/80 hover:bg-slate-50 hover:text-slate-900 shadow-xs transition-all duration-200 active:scale-[0.98]">
                <i class="fa-solid fa-arrow-right text-xs"></i>
                <span>العودة للقائمة</span>
            </a>
        </div>
    </div>

    <!-- KPI Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Total Products -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">إجمالي المنتجات</p>
                <p class="text-2xl sm:text-3xl font-black text-slate-800 mt-1">{{ number_format($stats['products_total']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
        </div>

        <!-- Active Products -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">المنتجات النشطة</p>
                <p class="text-2xl sm:text-3xl font-black text-emerald-600 mt-1">{{ number_format($stats['products_active']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Portfolios (نماذج الأعمال) -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">نماذج الأعمال</p>
                <p class="text-2xl sm:text-3xl font-black text-purple-600 mt-1">{{ number_format($stats['portfolios_total']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                <i class="fa-solid fa-images text-xl"></i>
            </div>
        </div>

        <!-- Quote Requests (طلبات عروض الأسعار) -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">طلبات عروض الأسعار</p>
                <p class="text-2xl sm:text-3xl font-black text-rose-600 mt-1">{{ number_format($stats['quotes_total']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Main Content Layout (2 Columns) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Right Side: Category Technical Details & Products List (8 Columns) -->
        <div class="lg:col-span-8 space-y-6">

            <!-- Category Detailed Specifications Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <h3 class="text-base font-black text-slate-900 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center">
                            <i class="fa-solid fa-circle-info text-sm"></i>
                        </div>
                        <span>معلومات وبيانات القسم التفصيلية</span>
                    </h3>
                </div>

                <div class="divide-y divide-slate-100 text-xs sm:text-sm">
                    <!-- Category Full Name -->
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-2 text-slate-500 font-semibold">
                            <i class="fa-solid fa-tag text-slate-400 w-4"></i>
                            <span>اسم التصنيف الكامل</span>
                        </div>
                        <span class="font-bold text-slate-900 text-sm sm:text-base">{{ $category->name }}</span>
                    </div>

                    <!-- Category Slug -->
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-2 text-slate-500 font-semibold">
                            <i class="fa-solid fa-link text-slate-400 w-4"></i>
                            <span>الرابط اللطيف (Slug)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span dir="ltr" class="font-mono font-bold text-blue-700 bg-blue-50 border border-blue-100 px-3 py-1 rounded-lg text-xs">
                                {{ $category->slug }}
                            </span>
                            <button type="button"
                                onclick="copySlugToClipboard('{{ $category->slug }}')"
                                class="text-slate-400 hover:text-blue-600 transition-colors p-1"
                                title="نسخ الرابط">
                                <i class="fa-regular fa-copy text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Display Order -->
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-2 text-slate-500 font-semibold">
                            <i class="fa-solid fa-arrow-down-1-9 text-slate-400 w-4"></i>
                            <span>ترتيب الظهور في الموقع</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="font-mono font-bold text-slate-800 bg-slate-100 border border-slate-200/80 px-2.5 py-1 rounded-lg text-xs">
                                #{{ $category->order }}
                            </span>
                            <span class="text-xs text-slate-400">الأرقام الأصغر تظهر أولاً</span>
                        </div>
                    </div>

                    <!-- Icon Preset -->
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-2 text-slate-500 font-semibold">
                            <i class="fa-solid fa-icons text-slate-400 w-4"></i>
                            <span>الأيقونة المعتمدة</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="w-7 h-7 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center border border-blue-100">
                                <x-category-icon :icon="$category->icon" class="w-4 h-4" />
                            </span>
                            <span class="font-mono font-bold text-slate-700 text-xs bg-slate-50 px-2.5 py-1 rounded-md border border-slate-200/60">
                                {{ $category->icon ?: 'box' }}
                            </span>
                        </div>
                    </div>

                    <!-- Visibility Status -->
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-2 text-slate-500 font-semibold">
                            <i class="fa-solid fa-eye text-slate-400 w-4"></i>
                            <span>حالة النشر والظهور للعملاء</span>
                        </div>
                        <div>
                            @if($category->is_active)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span>نشط ومتاح في الموقع</span>
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                                <span>معطل ومخفي عن الزوار</span>
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Creation Timestamp -->
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-2 text-slate-500 font-semibold">
                            <i class="fa-regular fa-calendar text-slate-400 w-4"></i>
                            <span>تاريخ الإضافة للنظام</span>
                        </div>
                        <span class="font-mono font-medium text-slate-700 text-xs">
                            {{ $category->created_at ? $category->created_at->format('Y/m/d - h:i A') : '—' }}
                        </span>
                    </div>

                    <!-- Update Timestamp -->
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-2 text-slate-500 font-semibold">
                            <i class="fa-solid fa-clock-rotate-left text-slate-400 w-4"></i>
                            <span>تاريخ آخر تعديل</span>
                        </div>
                        <span class="font-mono font-medium text-slate-700 text-xs">
                            {{ $category->updated_at ? $category->updated_at->format('Y/m/d - h:i A') : '—' }}
                        </span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Left Side: Image Preview & Related Metrics (4 Columns) -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Category Image Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-sm font-black text-slate-900 flex items-center gap-2">
                        <i class="fa-regular fa-image text-blue-700"></i>
                        <span>الصورة التوضيحية للقسم</span>
                    </h3>
                    @if($category->image)
                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">
                        مرفوعة
                    </span>
                    @endif
                </div>

                <div class="mt-4">
                    @if($category->image)
                    <div class="rounded-xl overflow-hidden border border-slate-200 bg-slate-100 group relative shadow-inner">
                        <img src="{{ asset($category->image) }}"
                            alt="{{ $category->name }}"
                            class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                            <a href="{{ asset($category->image) }}" target="_blank" class="px-3 py-1.5 bg-white/95 text-slate-800 text-xs font-bold rounded-xl shadow-lg hover:bg-white transition-all flex items-center gap-1.5">
                                <i class="fa-solid fa-up-right-from-square text-[10px]"></i>
                                <span>عرض بالحجم الكامل</span>
                            </a>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-xs">
                        <span class="text-slate-400 text-[11px] font-mono truncate max-w-[200px]" dir="ltr">{{ basename($category->image) }}</span>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-700 hover:text-blue-800 font-bold text-[11px] flex items-center gap-1">
                            <i class="fa-solid fa-pen text-[10px]"></i>
                            <span>تغيير الصورة</span>
                        </a>
                    </div>
                    @else
                    <div class="rounded-xl border-2 border-dashed border-slate-200 p-6 text-center bg-slate-50/50">
                        <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2">
                            <i class="fa-regular fa-image text-xl"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-700">لا توجد صورة مخصصة مرفوعة</p>
                        <p class="text-[11px] text-slate-400 mt-1">يتم اعتماد الأيقونة الرمزية الافتراضية للتصنيف</p>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="inline-flex items-center gap-1.5 text-xs text-blue-700 font-bold hover:underline mt-3">
                            <i class="fa-solid fa-upload text-[11px]"></i>
                            <span>رفع صورة الآن</span>
                        </a>
                    </div>
                    @endif
                </div>
            </div>


            <!-- Quick Actions Hub Card -->
            <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 rounded-2xl p-5 text-white shadow-xl relative overflow-hidden">
                <div class="absolute -bottom-8 -left-8 w-28 h-28 rounded-full bg-blue-500/20 blur-xl"></div>
                <div class="relative z-10 space-y-3.5">
                    <h3 class="text-sm font-black flex items-center gap-2">
                        <i class="fa-solid fa-bolt text-amber-400"></i>
                        <span>إجراءات وتحكم سريع</span>
                    </h3>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        تحكم بإعدادات هذا القسم مباشرة أو قم بإجراء التعديلات المطلوبة.
                    </p>

                    <div class="space-y-2 pt-1">
                        <a href="{{ route('admin.categories.edit', $category) }}"
                            class="w-full flex items-center justify-between p-3 rounded-xl bg-white/10 hover:bg-white/15 border border-white/10 text-xs font-bold transition-colors">
                            <span class="flex items-center gap-2">
                                <i class="fa-solid fa-pen text-blue-300"></i>
                                <span>تعديل اسم وبيانات التصنيف</span>
                            </span>
                            <i class="fa-solid fa-chevron-left text-[10px] text-slate-400"></i>
                        </a>

                        <form action="{{ route('admin.categories.toggle-status', $category) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="w-full flex items-center justify-between p-3 rounded-xl bg-white/10 hover:bg-white/15 border border-white/10 text-xs font-bold transition-colors text-right">
                                <span class="flex items-center gap-2">
                                    <i class="fa-solid {{ $category->is_active ? 'fa-pause text-amber-300' : 'fa-play text-emerald-300' }}"></i>
                                    <span>{{ $category->is_active ? 'تعطيل وإخفاء التصنيف' : 'تفعيل وإظهار التصنيف' }}</span>
                                </span>
                                <i class="fa-solid fa-chevron-left text-[10px] text-slate-400"></i>
                            </button>
                        </form>

                        <a href="{{ route('admin.categories.index') }}"
                            class="w-full flex items-center justify-between p-3 rounded-xl bg-white/10 hover:bg-white/15 border border-white/10 text-xs font-bold transition-colors">
                            <span class="flex items-center gap-2">
                                <i class="fa-solid fa-layer-group text-purple-300"></i>
                                <span>استعراض كافة التصنيفات</span>
                            </span>
                            <i class="fa-solid fa-chevron-left text-[10px] text-slate-400"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- Products List In Category -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h3 class="text-base font-black text-slate-900 flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center">
                        <i class="fa-solid fa-boxes-stacked text-sm"></i>
                    </div>
                    <span>منتجات هذا القسم</span>
                </h3>
                <p class="text-xs text-slate-500 mt-1">قائمة بالمنتجات التابعة للقسم</p>
            </div>

            <a href="{{ route('admin.products.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-white bg-blue-700 hover:bg-blue-800 transition-colors shadow-2xs self-start sm:self-auto">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>إضافة منتج جديد</span>
            </a>
        </div>

        @if($products->isNotEmpty())
        <!-- Responsive Products Cards Grid -->
        <div class="p-5 sm:p-6 bg-slate-50/40">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
                @foreach($products as $product)
                <div class="bg-white rounded-2xl border border-slate-200/90 hover:border-blue-400/80 shadow-xs hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex flex-col justify-between overflow-hidden group">

                    <!-- Product Top Image / Banner -->
                    <a href="{{ route('admin.products.show', $product) }}" class="relative h-44 w-full overflow-hidden bg-slate-100 flex items-center justify-center block">
                        @if($product->featured_image)
                        <img src="{{ asset($product->featured_image) }}"
                            alt="{{ $product->name }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            onerror="this.parentElement.innerHTML='<div class=\'flex flex-col items-center justify-center text-slate-300 gap-1.5\'><i class=\'fa-solid fa-image text-3xl\'></i><span class=\'text-[10px] font-semibold text-slate-400\'>تعذر تحميل الصورة</span></div>'">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-slate-100 via-slate-50 to-slate-200/60 flex flex-col items-center justify-center text-slate-400 gap-2">
                            <div class="w-12 h-12 rounded-2xl bg-white shadow-xs border border-slate-200/60 flex items-center justify-center text-slate-400 group-hover:text-blue-600 group-hover:scale-110 transition-all">
                                <i class="fa-solid fa-box-open text-xl"></i>
                            </div>
                            <span class="text-[11px] font-medium text-slate-400">لا توجد صورة للمنتج</span>
                        </div>
                        @endif

                        <!-- Floating Badges -->
                        <div class="absolute inset-x-3 top-3 flex items-center justify-between pointer-events-none z-10">
                            <!-- Status Badge -->
                            <div>
                                @if($product->is_active)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-white/95 backdrop-blur-xs text-emerald-700 shadow-xs border border-emerald-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span>نشط</span>
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-white/95 backdrop-blur-xs text-slate-600 shadow-xs border border-slate-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                    <span>معطل</span>
                                </span>
                                @endif
                            </div>

                            <!-- Featured Badge -->
                            <div>
                                @if($product->is_featured)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-amber-500 text-white shadow-xs shadow-amber-900/20">
                                    <i class="fa-solid fa-star text-[9px]"></i>
                                    <span>مميز</span>
                                </span>
                                @endif
                            </div>
                        </div>
                    </a>

                    <!-- Card Body Content -->
                    <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between gap-3">
                        <div class="space-y-1.5">
                            <a href="{{ route('admin.products.show', $product) }}" class="block font-black text-slate-800 text-sm sm:text-base group-hover:text-blue-700 transition-colors line-clamp-1" title="{{ $product->name }}">
                                {{ $product->name }}
                            </a>
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed min-h-[2.5rem]">
                                {{ $product->short_description ?: 'لا يوجد وصف مختصر متوفر لهذا المنتج في الوقت الحالي.' }}
                            </p>
                        </div>

                        <!-- Meta Footer -->
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2 text-xs">
                            <div class="flex items-center gap-1.5 min-w-0" title="الرابط: {{ $product->slug }}">
                                <i class="fa-solid fa-link text-[10px] text-slate-400 flex-shrink-0"></i>
                                <span class="font-mono text-[11px] text-slate-500 bg-slate-50 border border-slate-200/70 px-2 py-0.5 rounded-md dir-ltr truncate">
                                    {{ $product->slug }}
                                </span>
                            </div>

                            <a href="{{ route('admin.products.show', $product) }}" class="text-blue-700 hover:text-blue-800 font-bold text-xs flex items-center gap-1">
                                <span>عرض</span>
                                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                </div>
                @endforeach
            </div>
        </div>
        @else
        <!-- Empty State for Products -->
        <div class="p-10 text-center">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-3 shadow-inner">
                <i class="fa-solid fa-box-open text-2xl"></i>
            </div>
            <h4 class="text-base font-black text-slate-800">لا توجد منتجات مسجلة في هذا التصنيف بعد</h4>
            <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                يمكنك إضافة منتجات جديدة وتعيين هذا التصنيف لها لتظهر هنا وتصبح متاحة للعملاء.
            </p>
            <a href="{{ route('admin.products.create') }}"
                class="inline-flex items-center gap-2 mt-4 px-4 py-2 rounded-xl text-xs font-bold text-white bg-blue-700 hover:bg-blue-800 transition-colors shadow-2xs">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>إضافة منتج الآن</span>
            </a>
        </div>
        @endif
    </div>

</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-200">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 text-right space-y-4">

        <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
            <i class="fa-solid fa-triangle-exclamation text-xl"></i>
        </div>

        <div>
            <h3 class="text-lg font-bold text-slate-900">تأكيد حذف التصنيف</h3>
            <p class="text-sm text-slate-500 mt-1">
                هل أنت متأكد من رغبتك في حذف التصنيف: <strong id="modal-category-name" class="text-slate-800"></strong>؟
            </p>
            <div id="modal-products-warning" class="hidden mt-3 p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs flex items-start gap-2">
                <i class="fa-solid fa-circle-exclamation text-amber-600 mt-0.5"></i>
                <span>تنبيه: هذا التصنيف مرتبط بمنتجات حالياً! لن تتمكن من حذفه حتى تقوم بنقل أو حذف تلك المنتجات أولاً.</span>
            </div>
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
    // Copy Slug function
    function copySlugToClipboard(slug) {
        const fullPath = `/categories/${slug}`;
        navigator.clipboard.writeText(fullPath).then(() => {
            const feedback = document.getElementById('copy-feedback');
            const icon = document.getElementById('copy-slug-icon');

            if (feedback) {
                feedback.classList.remove('opacity-0');
                feedback.classList.add('opacity-100');
            }
            if (icon) {
                icon.className = 'fa-solid fa-check text-xs text-emerald-600';
            }

            setTimeout(() => {
                if (feedback) {
                    feedback.classList.remove('opacity-100');
                    feedback.classList.add('opacity-0');
                }
                if (icon) {
                    icon.className = 'fa-regular fa-copy text-xs';
                }
            }, 2000);
        });
    }

    // Delete Modal controls
    function openDeleteModal(categoryId, categoryName, productsCount) {
        const modal = document.getElementById('delete-modal');
        const form = document.getElementById('delete-form');
        const nameEl = document.getElementById('modal-category-name');
        const warningEl = document.getElementById('modal-products-warning');

        if (form) form.action = `/admin/categories/${categoryId}`;
        if (nameEl) nameEl.textContent = categoryName;

        if (warningEl) {
            if (productsCount > 0) {
                warningEl.classList.remove('hidden');
            } else {
                warningEl.classList.add('hidden');
            }
        }

        if (modal) {
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100', 'pointer-events-auto');
        }
    }

    function closeDeleteModal() {
        const modal = document.getElementById('delete-modal');
        if (modal) {
            modal.classList.add('opacity-0', 'pointer-events-none');
            modal.classList.remove('opacity-100', 'pointer-events-auto');
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });
</script>
@endpush
@endsection