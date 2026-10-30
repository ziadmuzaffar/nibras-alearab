@extends('layouts.website.app')

@section('title', $selectedCategory ? $selectedCategory->name : __('كتالوج المنتجات وحلول الطباعة'))

@section('content')

<!-- Page Hero Header -->
<section class="relative bg-slate-950 text-white py-12 sm:py-16 overflow-hidden">
    <div class="absolute inset-0 bg-grid-pattern opacity-40 pointer-events-none"></div>
    <div class="absolute -top-24 -right-24 w-80 h-80 rounded-full bg-blue-600/20 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-80 h-80 rounded-full bg-red-600/15 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs font-bold text-slate-400 mb-4 flex-wrap">
            <a href="{{ route('website.home') }}" class="hover:text-white transition-colors">{{ __('الرئيسية') }}</a>
            <i class="fa-solid fa-chevron-left text-[10px] text-slate-600"></i>
            <a href="{{ route('website.products.index') }}" class="{{ $selectedCategory ? 'hover:text-white' : 'text-blue-400' }} transition-colors">{{ __('كتالوج المنتجات') }}</a>
            @if($selectedCategory)
            <i class="fa-solid fa-chevron-left text-[10px] text-slate-600"></i>
            <span class="text-amber-300">{{ $selectedCategory->name }}</span>
            @endif
        </nav>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="space-y-2.5">
                <div class="flex items-center gap-3">
                    @if($selectedCategory)
                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-blue-600/20 border border-blue-500/40 text-blue-300 flex items-center justify-center shrink-0">
                        <x-category-icon :icon="$selectedCategory->icon ?? 'box'" class="w-5 h-5 sm:w-6 sm:h-6" />
                    </div>
                    @endif
                    <h1 class="text-2xl sm:text-4xl font-black text-white tracking-tight">
                        {{ $selectedCategory ? $selectedCategory->name : __('كتالوج منتجات الطباعة والتغليف') }}
                    </h1>
                </div>
                <p class="text-xs sm:text-base text-slate-300 max-w-2xl leading-relaxed">
                    @if($selectedCategory)
                    {{ __('استعرض كافة منتجات وحلول') }} {{ $selectedCategory->name }} {{ __('المنفذة بأعلى معايير الدقة والجودة، واطلب عرض سعر مخصص حسب الكميات والمقاسات المطلوبة.') }}
                    @else
                    {{ __('تشكيلة متكاملة من علب التغليف الفاخرة، كراتين الشحن، البطاقات الشخصية، الأكياس الورقية، الكتالوجات، والهدايا الترويجية المصممة لإبراز هويتك.') }}
                    @endif
                </p>
            </div>

            <div class="flex items-center gap-3 self-start md:self-auto shrink-0">
                @if(setting('enable_quotes', '1') === '1')
                <button type="button"
                    onclick="openQuoteModal()"
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-gradient-to-r from-blue-600 to-red-600 hover:from-blue-500 hover:to-red-500 text-white font-black text-xs sm:text-sm whitespace-nowrap shadow-lg">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                    <span>{{ __('طلب تسعير مخصص') }}</span>
                </button>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Main Catalog Layout -->
<section class="py-10 sm:py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 items-start">

            <!-- Right Sidebar: Categories & Custom Quote Card (3 Cols on Desktop) -->
            <aside class="lg:col-span-3 min-w-0 space-y-6">

                <!-- Categories Filter Box -->
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-4 sm:p-5">
                    <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100">
                        <h3 class="text-sm font-black text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-layer-group text-blue-600"></i>
                            <span>{{ __('أقسام الطباعة') }}</span>
                        </h3>
                        @if($selectedCategory || request('search') || request('featured'))
                        <a href="{{ route('website.products.index') }}" class="text-[11px] font-bold text-red-600 hover:underline">
                            {{ __('إعادة ضبط') }}
                        </a>
                        @endif
                    </div>

                    <!-- Mobile/Tablet Horizontal Scroll / Desktop Vertical List -->
                    <div class="flex lg:flex-col gap-2 overflow-x-auto no-scrollbar pb-1 lg:pb-0">
                        <a href="{{ route('website.products.index', request()->only(['search', 'sort'])) }}"
                            class="shrink-0 lg:shrink flex items-center justify-between gap-2.5 px-3.5 py-2.5 rounded-xl text-xs font-extrabold whitespace-nowrap transition-all {{ !$selectedCategory ? 'bg-slate-900 text-white shadow-sm' : 'bg-slate-50 lg:bg-transparent text-slate-700 hover:bg-slate-100' }}">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-border-all text-xs {{ !$selectedCategory ? 'text-blue-400' : 'text-slate-400' }}"></i>
                                <span>{{ __('جميع الأقسام') }}</span>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-mono shrink-0 {{ !$selectedCategory ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500' }}">
                                {{ $totalActiveProducts }}
                            </span>
                        </a>

                        @foreach($navCategories as $cat)
                        @php
                        $isCatActive = $selectedCategory && $selectedCategory->id === $cat->id;
                        @endphp
                        <a href="{{ route('website.categories.show', $cat->slug) }}"
                            class="shrink-0 lg:shrink flex items-center justify-between gap-2.5 px-3.5 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition-all {{ $isCatActive ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20 font-black' : 'bg-slate-50 lg:bg-transparent text-slate-700 hover:bg-blue-50/70 hover:text-blue-700' }}">
                            <div class="flex items-center gap-2 lg:min-w-0">
                                <x-category-icon :icon="$cat->icon ?? 'box'" class="w-4 h-4 {{ $isCatActive ? 'text-white' : 'text-blue-600' }}" />
                                <span class="lg:truncate">{{ $cat->name }}</span>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-mono shrink-0 {{ $isCatActive ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500' }}">
                                {{ $cat->products_count ?? 0 }}
                            </span>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Special Specifications Help Card (Desktop) -->
                <div class="hidden lg:block rounded-3xl bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 text-white p-6 shadow-xl border border-slate-800 space-y-4">
                    <div class="w-11 h-11 rounded-2xl bg-white/10 text-amber-300 flex items-center justify-center">
                        <i class="fa-solid fa-compass-drafting text-lg"></i>
                    </div>
                    <h4 class="text-base font-black leading-snug">{{ __('هل لديك مقاس أو تصميم خاص غير موجود بالكتالوج؟') }}</h4>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        {{ __('نحن مصنع ومطبعة متكاملة؛ نصنع القوالب والعلب والمطبوعات حسب مواصفاتك الهندسية الخاصة من الصفر.') }}
                    </p>
                    <button type="button"
                        onclick="openQuoteModal()"
                        class="w-full py-3 px-4 rounded-xl bg-white text-slate-950 hover:bg-amber-300 font-black text-xs transition-colors flex items-center justify-center gap-2">
                        <i class="fa-solid fa-bolt text-red-600"></i>
                        <span>{{ __('اطلب تسعير لمواصفات خاصة') }}</span>
                    </button>
                </div>

            </aside>

            <!-- Left Main Column: Search, Sort & Products Grid (9 Cols on Desktop) -->
            <div class="lg:col-span-9 min-w-0 space-y-6">

                <!-- Search & Sort Filter Bar -->
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-4 sm:p-5">
                    <form action="{{ $selectedCategory ? route('website.categories.show', $selectedCategory->slug) : route('website.products.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">

                        <!-- Search Input -->
                        <div class="sm:col-span-12 md:col-span-6 relative">
                            <input type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="{{ __('ابحث باسم المنتج أو الخامة (مثال: مغناطيس، كرافت، UV)...') }}"
                                class="w-full pr-10 pl-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs sm:text-sm font-medium text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all">
                            <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            </span>
                        </div>

                        <!-- Sort Select -->
                        <div class="sm:col-span-8 md:col-span-4">
                            <select name="sort"
                                onchange="this.form.submit()"
                                class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs sm:text-sm font-bold text-slate-700 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all">
                                <option value="featured" {{ $sort === 'featured' ? 'selected' : '' }}>{{ __('الترتيب: المميزة أولاً') }}</option>
                                <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>{{ __('الترتيب: الأحدث إضافة') }}</option>
                                <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>{{ __('الاسم: أ - ي') }}</option>
                                <option value="name_desc" {{ $sort === 'name_desc' ? 'selected' : '' }}>{{ __('الاسم: ي - أ') }}</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="sm:col-span-4 md:col-span-2">
                            <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs sm:text-sm transition-colors">
                                {{ __('تطبيق') }}
                            </button>
                        </div>
                    </form>

                    <!-- Active Filters Summary -->
                    @if(request('search') || $selectedCategory)
                    <div class="mt-3 pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-2 text-xs">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-slate-400 font-semibold">{{ __('نتائج البحث:') }}</span>
                            <span class="font-black text-slate-800">{{ $products->total() }} {{ __('منتج') }}</span>
                            @if(request('search'))
                            <span class="px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 font-bold">
                                "{{ request('search') }}"
                            </span>
                            @endif
                        </div>
                        <a href="{{ route('website.products.index') }}" class="text-red-600 hover:underline font-bold flex items-center gap-1">
                            <i class="fa-solid fa-rotate-left text-[10px]"></i>
                            <span>{{ __('مسح الفلاتر وعرض الكل') }}</span>
                        </a>
                    </div>
                    @endif
                </div>

                <!-- Products Grid -->
                @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5 sm:gap-6">
                    @foreach($products as $product)
                    <x-product-card :product="$product" />
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                <div class="pt-6">
                    {{ $products->links() }}
                </div>
                @endif
                @else
                <!-- Empty State -->
                <div class="bg-white rounded-3xl border border-slate-200/80 p-12 text-center space-y-4">
                    <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                        <i class="fa-solid fa-box-open text-2xl"></i>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-base sm:text-lg font-black text-slate-900">{{ __('لم يتم العثور على منتجات مطابقة لبحثك') }}</h3>
                        <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto">
                            {{ __('جرب البحث بكلمات أخرى، أو تصفح جميع أقسام المطبعة، أو اطلب تسعيراً لمواصفاتك الخاصة مباشرة.') }}
                        </p>
                    </div>
                    <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
                        <a href="{{ route('website.products.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-900 text-white text-xs sm:text-sm font-bold">
                            {{ __('عرض جميع المنتجات') }}
                        </a>
                        <button type="button" onclick="openQuoteModal()" class="px-5 py-2.5 rounded-xl bg-blue-600 text-white text-xs sm:text-sm font-bold">
                            {{ __('اطلب تسعير مخصص') }}
                        </button>
                    </div>
                </div>
                @endif

            </div>

        </div>

    </div>
</section>

@endsection