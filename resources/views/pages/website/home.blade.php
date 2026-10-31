@extends('layouts.website.app')

@section('content')

<!-- ==========================================================================
     1. HERO SECTION - LUXURY PRINTING & PACKAGING SHOWCASE
     ========================================================================== -->
<section class="relative bg-slate-950 text-white overflow-hidden pt-10 pb-16 sm:py-20 lg:py-24 flex items-center justify-center">
    <!-- Ambient Mesh Gradients & Grid Pattern -->
    <div class="absolute inset-0 bg-grid-pattern opacity-60 pointer-events-none"></div>
    <div class="absolute -top-32 -right-32 w-[450px] h-[450px] rounded-full bg-blue-600/25 blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/3 -left-32 w-[400px] h-[400px] rounded-full bg-red-600/20 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 right-1/3 w-[350px] h-[350px] rounded-full bg-indigo-500/15 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 flex items-center justify-center">
        <div class="w-full max-w-4xl mx-auto flex flex-col items-center justify-center text-center space-y-6 sm:space-y-8">

            <!-- Right Column: Content & CTAs -->
            <div class="w-full flex flex-col items-center justify-center space-y-6 sm:space-y-8 text-center">

                <!-- Trust Pill Badge -->
                <div class="inline-flex items-center justify-center gap-2 sm:gap-2.5 px-3.5 sm:px-4 py-1.5 rounded-2xl sm:rounded-full bg-white/10 border border-white/15 backdrop-blur-md max-w-full">
                    <span class="flex h-2 w-2 relative shrink-0">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                    </span>
                    <span class="text-[11px] sm:text-sm font-bold text-blue-200 leading-snug">
                        {{ __('خبرة منذ عام') }} {{ $stats['established_year'] }}{{ app()->getLocale() === 'ar' ? 'م' : '' }} • {{ __('الشريك الأول للطباعة الفاخرة والتغليف بالمملكة') }}
                    </span>
                </div>

                <!-- Main Headline -->
                <div class="space-y-3 flex flex-col items-center">
                    <h1 class="text-2xl sm:text-4xl md:text-5xl lg:text-[54px] font-black tracking-tight text-white leading-[1.3] sm:leading-[1.2] lg:leading-[1.18]">
                        {{ __('نُجسّد هويتك التجارية بأرقى حلول') }}
                        <span class="brand-gradient-text">{{ __('الطباعة الفاخرة والتغليف المبتكر') }}</span>
                    </h1>
                    <p class="text-sm sm:text-lg text-slate-300 leading-relaxed max-w-2xl mx-auto font-medium">
                        {{ setting('site_description', __('نبراس العرب هي وجهتكم الموثوقة لخدمات الطباعة الرقمية والأوفست، تصنيع علب التغليف الفاخرة، والهدايا الترويجية بالمملكة العربية السعودية وفق أرقى المعايير العالمية.')) }}
                    </p>
                </div>

                <!-- Printing Capabilities Quick Pills -->
                <div class="flex flex-wrap items-center justify-center gap-2 text-[11px] sm:text-xs font-bold text-slate-300">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-900/90 border border-slate-800">
                        <i class="fa-solid fa-box-open text-amber-400 shrink-0"></i>
                        <span>{{ __('علب صلبة ومغناطيسية') }}</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-900/90 border border-slate-800">
                        <i class="fa-solid fa-wand-magic-sparkles text-blue-400 shrink-0"></i>
                        <span>{{ __('بصمة ذهبية و Spot UV') }}</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-900/90 border border-slate-800">
                        <i class="fa-solid fa-layer-group text-red-400 shrink-0"></i>
                        <span>{{ __('طباعة أوفست وديجيتال CMYK') }}</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-900/90 border border-slate-800">
                        <i class="fa-solid fa-truck-fast text-emerald-400 shrink-0"></i>
                        <span>{{ __('توريد لجميع مناطق المملكة') }}</span>
                    </span>
                </div>

                <!-- Primary & Secondary CTA Buttons -->
                <div class="flex flex-col sm:flex-row sm:flex-wrap items-stretch sm:items-center justify-center gap-3 sm:gap-3.5 pt-1 w-full sm:w-auto">
                    @if(setting('enable_quotes', '1') === '1')
                    <button type="button"
                        onclick="openQuoteModal()"
                        class="inline-flex items-center justify-center gap-2.5 sm:gap-3 px-6 sm:px-7 py-3.5 sm:py-4 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-700 to-red-600 hover:from-blue-500 hover:to-red-500 text-white font-black text-sm sm:text-base whitespace-nowrap shadow-2xl shadow-blue-600/30 hover:scale-[1.02] active:scale-[0.98] transition-all">
                        <i class="fa-solid fa-file-invoice-dollar text-lg"></i>
                        <span>{{ __('اطلب عرض سعر فوري') }}</span>
                        <i class="fa-solid fa-arrow-left text-xs"></i>
                    </button>
                    @endif

                    <a href="{{ route('website.products.index') }}"
                        class="inline-flex items-center justify-center gap-2.5 px-5 sm:px-6 py-3.5 sm:py-4 rounded-2xl bg-white/10 hover:bg-white/15 border border-white/20 text-white font-bold text-sm sm:text-base whitespace-nowrap backdrop-blur-sm transition-all">
                        <i class="fa-solid fa-boxes-stacked text-blue-400"></i>
                        <span>{{ __('استكشف كتالوج المنتجات') }}</span>
                    </a>

                    @if(setting('whatsapp') || setting('mobile'))
                    <a href="{{ whatsapp_link() }}"
                        target="_blank"
                        rel="noopener"
                        class="inline-flex items-center justify-center gap-2 px-5 py-3.5 sm:py-4 rounded-2xl bg-emerald-600/20 hover:bg-emerald-600 border border-emerald-500/40 text-emerald-300 hover:text-white font-bold text-sm whitespace-nowrap transition-all">
                        <i class="fa-brands fa-whatsapp text-xl"></i>
                        <span>{{ __('استشارة مجانية') }}</span>
                    </a>
                    @endif
                </div>

                <!-- Live Key Statistics Bar -->
                <div class="w-full pt-6 border-t border-slate-800/90 grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6 text-center">
                    <div>
                        <p class="text-2xl sm:text-3xl font-black text-white font-mono">+{{ $stats['years_experience'] }}</p>
                        <p class="text-xs text-slate-400 font-semibold mt-0.5">{{ __('عاماً من الخبرة والتميز') }}</p>
                    </div>
                    <div>
                        <p class="text-2xl sm:text-3xl font-black text-blue-400 font-mono">+5,400</p>
                        <p class="text-xs text-slate-400 font-semibold mt-0.5">{{ __('مشروع طباعة وتغليف منفذ') }}</p>
                    </div>
                    <div>
                        <p class="text-2xl sm:text-3xl font-black text-amber-400 font-mono">+1,200</p>
                        <p class="text-xs text-slate-400 font-semibold mt-0.5">{{ __('شركة وعلامة تجارية تثق بنا') }}</p>
                    </div>
                    <div>
                        <p class="text-2xl sm:text-3xl font-black text-emerald-400 font-mono">100%</p>
                        <p class="text-xs text-slate-400 font-semibold mt-0.5">{{ __('ضمان مطابقة المواصفات') }}</p>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- ==========================================================================
     2. TRUST & FEATURES STRIP
     ========================================================================== -->
<section class="relative z-20 -mt-6 sm:-mt-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-3xl shadow-xl shadow-slate-900/5 border border-slate-200/80 p-5 sm:p-7">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6 divide-y sm:divide-y-0 lg:divide-x lg:divide-x-reverse divide-slate-100">

            <div class="flex items-start gap-3.5 pt-3 sm:pt-0 first:pt-0">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-print text-xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-slate-900">{{ __('أحدث تقنيات الطباعة') }}</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ __('مكائن أوفست وديجيتال ألمانية حديثة تضمن ثبات الألوان ودقة التفاصيل.') }}</p>
                </div>
            </div>

            <div class="flex items-start gap-3.5 pt-4 sm:pt-0 lg:pr-5">
                <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-gem text-xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-slate-900">{{ __('خامات وتشطيبات ملكية') }}</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ __('كرتون صلب، ورق قطني، سلوفان مخملي، بصمة حرارية، وحفر ليزري.') }}</p>
                </div>
            </div>

            <div class="flex items-start gap-3.5 pt-4 sm:pt-0 lg:pr-5">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-compass-drafting text-xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-slate-900">{{ __('مقاسات وقوالب مخصصة') }}</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ __('تفصيل هندسي كامل للعلب والأكياس والملصقات حسب أبعاد منتجك.') }}</p>
                </div>
            </div>

            <div class="flex items-start gap-3.5 pt-4 sm:pt-0 lg:pr-5">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-truck-fast text-xl"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-slate-900">{{ __('التزام بالتوريد والشحن') }}</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ __('سرعة في الإنجاز وتغليف آمن للشحنات إلى كافة مدن ومناطق المملكة.') }}</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ==========================================================================
     3. CATEGORIES SECTION - PRINTING & PACKAGING DEPARTMENTS
     ========================================================================== -->
@php
    $isRtl = LaravelLocalization::getCurrentLocaleDirection() === 'rtl';
@endphp
<section id="categories-section" class="py-16 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10 sm:mb-12">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-200/80 text-blue-700 text-xs font-extrabold mb-3">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    <span>{{ __('main.categories_badge') }}</span>
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                    {{ __('main.categories_section_title') }}
                </h2>
                <p class="text-xs sm:text-base text-slate-500 mt-2 max-w-2xl">
                    {{ __('main.categories_section_desc') }}
                </p>
            </div>
            <a href="{{ route('website.products.index') }}"
                class="self-start md:self-auto shrink-0 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white border border-slate-200 hover:border-blue-600 text-slate-800 hover:text-blue-700 text-xs sm:text-sm font-black shadow-2xs transition-all">
                <span>{{ __('main.browse_all_categories') }}</span>
                <i class="fa-solid {{ $isRtl ? 'fa-arrow-left' : 'fa-arrow-right' }} text-xs"></i>
            </a>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3.5 sm:gap-5">
            @foreach($categories as $category)
            <a href="{{ route('website.categories.show', $category->slug) }}"
                class="group relative bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 border border-slate-200/80 hover:border-blue-500/80 shadow-sm hover:shadow-xl hover:shadow-blue-900/5 transition-all duration-300 flex flex-col justify-between overflow-hidden">

                <!-- Decorative Hover Circle -->
                <div class="absolute -bottom-10 -left-10 w-28 h-28 rounded-full bg-gradient-to-tr from-blue-50 to-indigo-50 group-hover:scale-150 transition-transform duration-500 pointer-events-none"></div>

                <div class="relative z-10 flex items-start justify-between gap-2 sm:gap-3 mb-4 sm:mb-5">
                    @if($category->image_url)
                    <div class="w-11 h-11 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl overflow-hidden border border-slate-200 shadow-sm flex-shrink-0">
                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    </div>
                    @else
                    <div class="w-11 h-11 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl bg-gradient-to-br from-blue-50 to-slate-100 group-hover:from-blue-600 group-hover:to-blue-800 text-blue-700 group-hover:text-white border border-blue-100/80 flex items-center justify-center shadow-sm transition-all duration-300 flex-shrink-0">
                        <x-category-icon :icon="$category->icon ?? 'box'" class="w-5 h-5 sm:w-6 sm:h-6" />
                    </div>
                    @endif

                    <span class="px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-full bg-slate-100 group-hover:bg-blue-50 text-slate-600 group-hover:text-blue-700 text-[10px] sm:text-[11px] font-extrabold font-mono whitespace-nowrap shrink-0 transition-colors">
                        {{ $category->products_count }} {{ __('main.product_unit') }}
                    </span>
                </div>

                <div class="relative z-10">
                    <h3 class="text-xs sm:text-base font-black text-slate-900 group-hover:text-blue-700 transition-colors leading-snug">
                        {{ $category->name }}
                    </h3>
                    <div class="mt-2.5 sm:mt-3 flex items-center gap-1.5 text-[11px] sm:text-xs font-bold text-slate-400 group-hover:text-red-600 transition-colors">
                        <span>{{ __('main.explore_category') }}</span>
                        <i class="fa-solid {{ $isRtl ? 'fa-arrow-left group-hover:-translate-x-1' : 'fa-arrow-right group-hover:translate-x-1' }} text-[10px] transition-transform"></i>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

    </div>
</section>

<!-- ==========================================================================
     4. INTERACTIVE PRODUCTS CATALOG SECTION
     ========================================================================== -->
<section id="catalog-section" class="py-16 sm:py-20 bg-white border-y border-slate-200/70 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-8 sm:mb-10">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-50 border border-red-200/80 text-red-700 text-xs font-extrabold mb-3">
                    <i class="fa-solid fa-fire-flame-curved text-xs"></i>
                    <span>{{ __('الأكثر طلباً في المطبعة') }}</span>
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                    {{ __('منتجاتنا المميزة وحلول التغليف المخصصة') }}
                </h2>
                <p class="text-xs sm:text-base text-slate-500 mt-2 max-w-2xl">
                    {{ __('اختر المنتج المناسب لنشاطك التجاري، اطلع على المواصفات الفنية الدقيقة، واطلب عرض سعر مخصص بكمياتك المطلوبة في ثوانٍ.') }}
                </p>
            </div>

            <!-- Category Instant Filter Pills -->
            <div class="w-full lg:w-auto max-w-full flex items-center gap-2 overflow-x-auto no-scrollbar pb-1">
                <button type="button"
                    onclick="filterHomeProducts('all', this)"
                    class="home-product-filter-btn active shrink-0 px-4 py-2 rounded-xl text-xs font-black bg-slate-900 text-white shadow-sm whitespace-nowrap transition-all">
                    {{ __('الكل') }} ({{ $featuredProducts->count() }})
                </button>
                @foreach($categories as $cat)
                @if($featuredProducts->where('category_id', $cat->id)->count() > 0)
                <button type="button"
                    onclick="filterHomeProducts('{{ $cat->slug }}', this)"
                    class="home-product-filter-btn shrink-0 px-4 py-2 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 whitespace-nowrap transition-all">
                    {{ $cat->name }}
                </button>
                @endif
                @endforeach
            </div>
        </div>

        <!-- Products Grid -->
        @if($featuredProducts->count() > 0)
        <div id="home-products-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 lg:gap-7">
            @foreach($featuredProducts as $product)
            <div class="home-product-item min-w-0 transition-all duration-300" data-category="{{ $product->category?->slug ?? 'general' }}">
                <x-product-card :product="$product" />
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-14 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
            <i class="fa-solid fa-box-open text-4xl text-slate-300 mb-3 block"></i>
            <p class="text-sm font-bold text-slate-600">{{ __('لا توجد منتجات مضافة حالياً.') }}</p>
        </div>
        @endif

        <!-- Bottom View Full Catalog CTA -->
        <div class="mt-10 sm:mt-12 text-center">
            <a href="{{ route('website.products.index') }}"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 sm:gap-3 px-6 sm:px-8 py-3.5 sm:py-4 rounded-2xl bg-slate-900 hover:bg-blue-700 text-white font-black text-xs sm:text-base shadow-xl shadow-slate-900/15 transition-all hover:scale-[1.01]">
                <i class="fa-solid fa-grip"></i>
                <span>{{ __('تصفح الكتالوج الكامل') }} ({{ $stats['products_count'] }} {{ __('منتج متاح') }})</span>
                <i class="fa-solid fa-arrow-left text-xs"></i>
            </a>
        </div>

    </div>
</section>

<!-- ==========================================================================
     5. WHY CHOOSE NIBRAS AL-ARAB & PRINTING TECHNOLOGIES (BENTO GRID)
     ========================================================================== -->
<section class="py-16 sm:py-24 bg-slate-950 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-pattern opacity-40 pointer-events-none"></div>
    <div class="absolute top-1/4 -right-32 w-96 h-96 rounded-full bg-blue-600/20 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-10 -left-32 w-96 h-96 rounded-full bg-red-600/15 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16 space-y-3">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/10 border border-white/15 text-blue-300 text-xs font-bold">
                <i class="fa-solid fa-medal text-amber-400"></i>
                <span>{{ __('لماذا تختار مطبعة نبراس العرب؟') }}</span>
            </div>
            <h2 class="text-2xl sm:text-4xl font-black text-white leading-tight">
                {{ __('نجمع بين الهندسة الدقيقة، الفخامة البصرية، والالتزام الصارم بالمواعيد') }}
            </h2>
            <p class="text-xs sm:text-base text-slate-400 leading-relaxed">
                {{ __('نستثمر في أحدث تقنيات الطباعة والتشطيب لنمنح منتجاتك حضوراً تنافسياً يرسخ في أذهان عملائك منذ اللحظة الأولى.') }}
            </p>
        </div>

        <!-- Bento Capabilities Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">

            <!-- Feature 1 -->
            <div class="p-6 sm:p-7 rounded-3xl bg-slate-900/90 border border-slate-800 hover:border-blue-500/50 transition-all group">
                <div class="w-12 h-12 rounded-2xl bg-blue-600/20 border border-blue-500/30 text-blue-400 flex items-center justify-center mb-5 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-box-archive text-xl"></i>
                </div>
                <h3 class="text-lg font-black text-white mb-2">{{ __('تصنيع العلب الصلبة الفاخرة (Rigid Boxes)') }}</h3>
                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
                    {{ __('خطوط إنتاج متخصصة لتفصيل علب الهدايا والعطور والساعات بكرتون مقوى صلب وأقفال مغناطيسية خفية مع بطانات إسفنجية ومخملية مقصوصة بالليزر.') }}
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="p-6 sm:p-7 rounded-3xl bg-slate-900/90 border border-slate-800 hover:border-amber-500/50 transition-all group">
                <div class="w-12 h-12 rounded-2xl bg-amber-500/20 border border-amber-500/30 text-amber-400 flex items-center justify-center mb-5 group-hover:bg-amber-500 group-hover:text-slate-950 transition-colors">
                    <i class="fa-solid fa-wand-magic-sparkles text-xl"></i>
                </div>
                <h3 class="text-lg font-black text-white mb-2">{{ __('تشطيبات ملكية تبرز أدق التفاصيل') }}</h3>
                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
                    {{ __('نوفر البصمة الحرارية (الذهبية، الفضية، الروز جولد)، الورنيش البارز (Spot UV)، الحفر الغائر والبارز (Embossing / Debossing)، وسلوفان Soft Touch الحريري.') }}
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="p-6 sm:p-7 rounded-3xl bg-slate-900/90 border border-slate-800 hover:border-red-500/50 transition-all group">
                <div class="w-12 h-12 rounded-2xl bg-red-600/20 border border-red-500/30 text-red-400 flex items-center justify-center mb-5 group-hover:bg-red-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-palette text-xl"></i>
                </div>
                <h3 class="text-lg font-black text-white mb-2">{{ __('دقة ألوان قياسية (CMYK & Pantone)') }}</h3>
                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
                    {{ __('معايرة إلكترونية دقيقة للألوان لضمان تطابق درجة لون شعارك وهويتك البصرية بنسبة 100% عبر جميع المطبوعات والعلب والأكياس.') }}
                </p>
            </div>

            <!-- Feature 4 -->
            <div class="p-6 sm:p-7 rounded-3xl bg-slate-900/90 border border-slate-800 hover:border-emerald-500/50 transition-all group">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 flex items-center justify-center mb-5 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-leaf text-xl"></i>
                </div>
                <h3 class="text-lg font-black text-white mb-2">{{ __('خامات معتمدة وصديقة للبيئة') }}</h3>
                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
                    {{ __('تشكيلة واسعة من ورق الكرافت الطبيعي، الورق القطني الفاخر، والكرتون المضلع القابل لإعادة التدوير والآمن للمنتجات الغذائية والتجميلية.') }}
                </p>
            </div>

            <!-- Feature 5 -->
            <div class="p-6 sm:p-7 rounded-3xl bg-slate-900/90 border border-slate-800 hover:border-purple-500/50 transition-all group">
                <div class="w-12 h-12 rounded-2xl bg-purple-500/20 border border-purple-500/30 text-purple-400 flex items-center justify-center mb-5 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-magnifying-glass-plus text-xl"></i>
                </div>
                <h3 class="text-lg font-black text-white mb-2">{{ __('مراجعة فنية للملفات واعتماد العينات') }}</h3>
                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
                    {{ __('يقوم فريق ما قبل الطباعة (Pre-Press) بفحص ملفات التصميم، ضبط الهوامش ودقة الصور، وتوفير بروفة/عينة معتمدة قبل بدء تشغيل خط الإنتاج.') }}
                </p>
            </div>

            <!-- Feature 6 -->
            <div class="p-6 sm:p-7 rounded-3xl bg-gradient-to-br from-blue-900/80 via-slate-900 to-red-950/60 border border-blue-500/40 flex flex-col justify-between">
                <div>
                    <span class="inline-block px-3 py-1 rounded-full bg-white/10 text-amber-300 text-[11px] font-bold mb-4">
                        {{ __('أسعار الجملة والكميات التجارية') }}
                    </span>
                    <h3 class="text-lg font-black text-white mb-2">{{ __('عقود توريد مرنة للشركات والمتاجر') }}</h3>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        {{ __('نقدم خطط أسعار تنافسية للكميات المتوسطة والكبيرة مع إمكانية جدولة الدفعات والتوريد الدوري للمتاجر الإلكترونية والمصانع.') }}
                    </p>
                </div>
                <div class="mt-5 pt-4 border-t border-white/10">
                    <button type="button" onclick="openQuoteModal()" class="text-xs sm:text-sm font-black text-amber-300 hover:text-white flex items-center gap-2 transition-colors">
                        <span>{{ __('احصل على تسعيرة خاصة لشركتك') }}</span>
                        <i class="fa-solid fa-arrow-left text-xs"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ==========================================================================
     6. HOW IT WORKS - 4 EXECUTION STEPS
     ========================================================================== -->
<section class="py-16 sm:py-20 bg-slate-50 border-b border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-14">
            <span class="text-xs font-black text-blue-700 uppercase tracking-wider">{{ __('آلية العمل في نبراس العرب') }}</span>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-1">
                {{ __('خطوات بسيطة وواضحة من الفكرة حتى الاستلام') }}
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 relative">
            <!-- Step 1 -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm relative group hover:border-blue-500 transition-all">
                <div class="flex items-center justify-between mb-4">
                    <span class="w-12 h-12 rounded-2xl bg-blue-600 text-white font-black text-lg flex items-center justify-center shadow-lg shadow-blue-600/25">
                        01
                    </span>
                    <i class="fa-solid fa-file-signature text-2xl text-slate-200 group-hover:text-blue-200 transition-colors"></i>
                </div>
                <h3 class="text-base font-black text-slate-900 mb-2">{{ __('إرسال طلب التسعير') }}</h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                    {{ __('اختر المنتج وحدد الكمية والمقاسات المطلوبة عبر نموذج التسعير السريع أو تواصل معنا عبر الواتساب.') }}
                </p>
            </div>

            <!-- Step 2 -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm relative group hover:border-blue-500 transition-all">
                <div class="flex items-center justify-between mb-4">
                    <span class="w-12 h-12 rounded-2xl bg-indigo-600 text-white font-black text-lg flex items-center justify-center shadow-lg shadow-indigo-600/25">
                        02
                    </span>
                    <i class="fa-solid fa-swatchbook text-2xl text-slate-200 group-hover:text-indigo-200 transition-colors"></i>
                </div>
                <h3 class="text-base font-black text-slate-900 mb-2">{{ __('الدراسة واعتماد العينة') }}</h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                    {{ __('نقدم لك عرض السعر التفصيلي، ونقوم بمراجعة ملفات التصميم وتجهيز القالب الهندسي واعتماد العينة قبل البدء.') }}
                </p>
            </div>

            <!-- Step 3 -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm relative group hover:border-blue-500 transition-all">
                <div class="flex items-center justify-between mb-4">
                    <span class="w-12 h-12 rounded-2xl bg-red-600 text-white font-black text-lg flex items-center justify-center shadow-lg shadow-red-600/25">
                        03
                    </span>
                    <i class="fa-solid fa-gears text-2xl text-slate-200 group-hover:text-red-200 transition-colors"></i>
                </div>
                <h3 class="text-base font-black text-slate-900 mb-2">{{ __('الطباعة والتشطيب المتقن') }}</h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                    {{ __('يبدأ الإنتاج الفعلي على مكائن الأوفست والديجيتال مع إضافة لمسات السلوفان، البصمة، والقص الليزري.') }}
                </p>
            </div>

            <!-- Step 4 -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm relative group hover:border-blue-500 transition-all">
                <div class="flex items-center justify-between mb-4">
                    <span class="w-12 h-12 rounded-2xl bg-emerald-600 text-white font-black text-lg flex items-center justify-center shadow-lg shadow-emerald-600/25">
                        04
                    </span>
                    <i class="fa-solid fa-truck-ramp-box text-2xl text-slate-200 group-hover:text-emerald-200 transition-colors"></i>
                </div>
                <h3 class="text-base font-black text-slate-900 mb-2">{{ __('الفحص والتوريد السريع') }}</h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                    {{ __('تخضع جميع القطع لفحص الجودة النهائي ثم تُغلّف بعناية فائقة وتُشحن مباشرة إلى مقر عميلنا.') }}
                </p>
            </div>
        </div>

    </div>
</section>

<!-- ==========================================================================
     7. PORTFOLIO SECTION - EXECUTED PROJECTS GALLERY
     ========================================================================== -->
@if($portfolios->count() > 0)
<section id="portfolio-section" class="py-16 sm:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-10">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-200/80 text-indigo-700 text-xs font-extrabold mb-3">
                    <i class="fa-solid fa-camera-retro"></i>
                    <span>{{ __('معرض أعمالنا ومشاريعنا') }}</span>
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                    {{ __('شركاء النجاح ونماذج من مشاريعنا المنفذة') }}
                </h2>
                <p class="text-xs sm:text-base text-slate-500 mt-2 max-w-2xl">
                    {{ __('نفخر بتنفيذ مئات المشاريع المتميزة لكبرى الشركات والمتاجر والعلامات التجارية في مختلف القطاعات بالمملكة.') }}
                </p>
            </div>

            <!-- Portfolio Filter Pills -->
            <div class="w-full lg:w-auto max-w-full flex items-center gap-2 overflow-x-auto no-scrollbar pb-1">
                <button type="button"
                    onclick="filterHomePortfolio('all', this)"
                    class="home-portfolio-filter-btn active shrink-0 px-4 py-2 rounded-xl text-xs font-black bg-blue-700 text-white shadow-sm whitespace-nowrap transition-all">
                    {{ __('جميع المشاريع') }}
                </button>
                @foreach($portfolioCategories as $pCat)
                <button type="button"
                    onclick="filterHomePortfolio('{{ $pCat->slug }}', this)"
                    class="home-portfolio-filter-btn shrink-0 px-4 py-2 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 whitespace-nowrap transition-all">
                    {{ $pCat->name }}
                </button>
                @endforeach
            </div>
        </div>

        <!-- Portfolio Grid -->
        <div id="home-portfolio-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
            @foreach($portfolios as $portfolio)
            <div data-category="{{ $portfolio->category?->slug ?? 'general' }}"
                onclick="openPortfolioModal({{ Js::from([
                    'title' => $portfolio->title,
                    'client' => $portfolio->client_name ?: __('عميل مميز'),
                    'category' => $portfolio->category?->name ?: __('مطبوعات وتغليف'),
                    'image' => $portfolio->image_url,
                    'description' => $portfolio->description,
                ]) }})"
                class="home-portfolio-item min-w-0 group cursor-pointer rounded-3xl overflow-hidden bg-slate-900 border border-slate-200/80 shadow-sm hover:shadow-2xl transition-all duration-300 relative h-72 sm:h-80 flex flex-col justify-end">

                @if($portfolio->image_url)
                <img src="{{ $portfolio->image_url }}"
                    alt="{{ $portfolio->title }}"
                    loading="lazy"
                    class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-90 group-hover:opacity-100"
                    onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1549465220-1a8b9238cd48?auto=format&fit=crop&w=800&q=80';">
                @endif

                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/55 to-transparent opacity-85 group-hover:opacity-95 transition-opacity"></div>

                <!-- Top Category & Zoom Icon -->
                <div class="absolute top-4 inset-x-4 flex items-center justify-between gap-2">
                    @if($portfolio->category)
                    <span class="px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-white text-[11px] font-bold truncate max-w-[170px]">
                        {{ $portfolio->category->name }}
                    </span>
                    @else
                    <span></span>
                    @endif
                    <span class="w-8 h-8 rounded-xl bg-white/20 group-hover:bg-blue-600 text-white flex items-center justify-center backdrop-blur-md transition-colors">
                        <i class="fa-solid fa-magnifying-glass-plus text-xs"></i>
                    </span>
                </div>

                <!-- Bottom Content -->
                <div class="relative z-10 p-5 space-y-1.5">
                    @if($portfolio->client_name)
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-amber-300">
                        <i class="fa-regular fa-building text-[10px]"></i>
                        <span>{{ $portfolio->client_name }}</span>
                    </span>
                    @endif
                    <h3 class="text-sm sm:text-base font-black text-white leading-snug group-hover:text-blue-300 transition-colors line-clamp-2">
                        {{ $portfolio->title }}
                    </h3>
                    @if($portfolio->description)
                    <p class="text-xs text-slate-300 line-clamp-2 leading-relaxed pt-0.5">
                        {{ $portfolio->description }}
                    </p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('website.portfolios.index') }}"
                class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-black text-xs sm:text-sm transition-colors">
                <span>{{ __('استعراض كافة المشاريع في معرض الأعمال') }}</span>
                <i class="fa-solid fa-arrow-left text-xs"></i>
            </a>
        </div>

    </div>
</section>
@endif

<!-- ==========================================================================
     8. DIRECT QUOTE REQUEST & CONSULTATION SECTION
     ========================================================================== -->
<section id="quote-section" class="py-16 sm:py-24 bg-gradient-to-b from-slate-100 to-slate-50 border-t border-slate-200/80 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-start">

            <!-- Right Column: Value Proposition & Direct Contact Channels (5 Cols) -->
            <div class="lg:col-span-5 min-w-0 space-y-6">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-extrabold">
                    <i class="fa-solid fa-calculator"></i>
                    <span>{{ __('تسعير سريع ومخصص لمشروعك') }}</span>
                </div>

                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 leading-tight">
                    {{ __('اطلب عرض سعر مفصل لمطبوعاتك أو علب التغليف الخاصة بك') }}
                </h2>

                <p class="text-xs sm:text-base text-slate-600 leading-relaxed">
                    {{ __('سواء كنت تطلق منتجاً جديداً أو ترغب في توريد كميات تجارية لمنشأتك، يقوم فريق التسعير والهندسة لدينا بدراسة طلبك وتقديم أفضل الخيارات الفنية والمالية.') }}
                </p>

                <!-- Key Advantages List -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-3.5 pt-2">
                    <div class="flex items-start gap-3.5 p-4 rounded-2xl bg-white border border-slate-200/80 shadow-2xs">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-black text-slate-900">{{ __('استجابة سريعة خلال ساعات العمل') }}</h4>
                            <p class="text-xs text-slate-500 mt-0.5">{{ __('يتواصل معك مسؤول المبيعات المختص لمناقشة الخيارات وتقديم السعر النهائي.') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3.5 p-4 rounded-2xl bg-white border border-slate-200/80 shadow-2xs">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fa-solid fa-percent"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-black text-slate-900">{{ __('خصومات خاصة للكميات الكبيرة') }}</h4>
                            <p class="text-xs text-slate-500 mt-0.5">{{ __('كلما زادت الكمية انخفضت تكلفة الوحدة بشكل ملحوظ بفضل تقنيات الأوفست.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Direct Contact Box -->
                <div class="p-5 sm:p-6 rounded-3xl bg-slate-900 text-white space-y-4 shadow-xl">
                    <h4 class="text-sm font-black text-amber-300 flex items-center gap-2">
                        <i class="fa-solid fa-headset"></i>
                        <span>{{ __('تفضل التواصل المباشر مع المبيعات؟') }}</span>
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-2.5 text-xs sm:text-sm">
                        @if(setting('mobile') || setting('phone'))
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', setting('mobile', setting('phone'))) }}"
                            class="flex items-center justify-between gap-2 p-3 rounded-xl bg-white/10 hover:bg-white/15 transition-colors">
                            <span class="text-slate-300">{{ __('اتصال مباشر:') }}</span>
                            <span class="font-mono font-bold text-white" dir="ltr">{{ setting('mobile', setting('phone')) }}</span>
                        </a>
                        @endif

                        @if(setting('whatsapp') || setting('mobile'))
                        <a href="{{ whatsapp_link() }}" target="_blank" rel="noopener"
                            class="flex items-center justify-between gap-2 p-3 rounded-xl bg-emerald-600/20 hover:bg-emerald-600/30 border border-emerald-500/30 transition-colors">
                            <span class="text-emerald-300 font-bold flex items-center gap-1.5">
                                <i class="fa-brands fa-whatsapp text-base"></i>
                                <span>{{ __('محادثة واتساب فورية') }}</span>
                            </span>
                            <span class="text-xs font-bold text-white whitespace-nowrap">{{ __('اضغط هنا ←') }}</span>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Left Column: Embedded Interactive Quote Form Card (7 Cols) -->
            <div class="lg:col-span-7 min-w-0">
                <div class="bg-white rounded-3xl shadow-xl shadow-slate-900/5 border border-slate-200/90 p-5 sm:p-8 lg:p-10">
                    @if(setting('enable_quotes', '1') === '1')
                    <div class="border-b border-slate-100 pb-4 mb-6 flex items-center justify-between gap-3">
                        <div>
                            <h3 class="text-lg sm:text-xl font-black text-slate-900">{{ __('نموذج طلب عرض السعر') }}</h3>
                            <p class="text-xs text-slate-500 mt-0.5">{{ __('املأ البيانات التالية وسيصل طلبك مباشرة إلى قسم التسعير والمبيعات') }}</p>
                        </div>
                        <span class="w-11 h-11 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
                        </span>
                    </div>

                    <form action="{{ route('website.quote.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                            <div>
                                <label for="home_customer_name" class="block text-xs font-extrabold text-slate-700 mb-2">
                                    {{ __('الاسم الكامل أو اسم الشركة') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                    id="home_customer_name"
                                    name="customer_name"
                                    value="{{ old('customer_name') }}"
                                    required
                                    placeholder="{{ __('مثال: شركة الأفق للتجارة / محمد العتيبي') }}"
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all">
                            </div>

                            <div>
                                <label for="home_phone" class="block text-xs font-extrabold text-slate-700 mb-2">
                                    {{ __('رقم الجوال (للتواصل والواتساب)') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="tel"
                                    id="home_phone"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    required
                                    dir="ltr"
                                    placeholder="05XXXXXXXX"
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm font-mono text-left text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                            <div>
                                <label for="home_product_id" class="block text-xs font-extrabold text-slate-700 mb-2">
                                    {{ __('المنتج المطلوب تسعيره') }}
                                </label>
                                <select id="home_product_id"
                                    name="product_id"
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-xs sm:text-sm font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all">
                                    <option value="">{{ __('— مشروع طباعة / تغليف مخصص عام —') }}</option>
                                    @foreach($quoteProducts as $qProd)
                                    <option value="{{ $qProd->id }}" {{ old('product_id') == $qProd->id ? 'selected' : '' }}>
                                        {{ $qProd->name }} {{ $qProd->category ? '(' . $qProd->category->name . ')' : '' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="home_email" class="block text-xs font-extrabold text-slate-700 mb-2">
                                    {{ __('البريد الإلكتروني الرسمي') }} <span class="text-slate-400 font-normal">({{ __('اختياري') }})</span>
                                </label>
                                <input type="email"
                                    id="home_email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    dir="ltr"
                                    placeholder="info@company.com"
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm font-mono text-left text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all">
                            </div>
                        </div>

                        <div>
                            <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                <label for="home_quantity" class="block text-xs font-extrabold text-slate-700">
                                    {{ __('الكمية المطلوبة تقريبياً (بالقطعة)') }}
                                </label>
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    @foreach([100, 250, 500, 1000, 3000, 5000] as $qtyPreset)
                                    <button type="button"
                                        onclick="document.getElementById('home_quantity').value = '{{ $qtyPreset }}'"
                                        class="px-2.5 py-0.5 rounded-lg bg-slate-100 hover:bg-blue-100 text-slate-600 hover:text-blue-700 text-[11px] font-bold font-mono transition-colors">
                                        {{ number_format($qtyPreset) }}
                                    </button>
                                    @endforeach
                                </div>
                            </div>
                            <input type="number"
                                id="home_quantity"
                                name="quantity"
                                value="{{ old('quantity') }}"
                                min="1"
                                placeholder="{{ __('أدخل الكمية المطلوبة (مثال: 1000)') }}"
                                class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm font-mono text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all">
                        </div>

                        <div>
                            <label for="home_notes" class="block text-xs font-extrabold text-slate-700 mb-2">
                                {{ __('تفاصيل ومواصفات الطلب (المقاسات، نوع الورق، الألوان، التشطيب)') }}
                            </label>
                            <textarea id="home_notes"
                                name="notes"
                                rows="4"
                                placeholder="{{ __('اكتب كافة التفاصيل التي تساعدنا في تقديم أدق عرض سعر لك...') }}"
                                class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-xs sm:text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all leading-relaxed">{{ old('notes') }}</textarea>
                        </div>

                        <button type="submit"
                            class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-blue-700 via-blue-600 to-red-600 hover:from-blue-800 hover:to-red-700 text-white font-black text-sm sm:text-base shadow-xl shadow-blue-700/20 flex items-center justify-center gap-2.5 transition-all active:scale-[0.99]">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>{{ __('إرسال طلب عرض السعر الآن') }}</span>
                        </button>
                    </form>
                    @else
                    <div class="text-center py-10 space-y-4">
                        <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto">
                            <i class="fa-brands fa-whatsapp text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-black text-slate-900">{{ __('تواصل مباشر مع فريق التسعير والمبيعات') }}</h3>
                        <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto">
                            {{ __('نسعد باستقبال طلبات التسعير والاستفسارات مباشرة عبر الواتساب أو الهاتف الرسمي للمطبعة.') }}
                        </p>
                        <a href="{{ whatsapp_link() }}" target="_blank" rel="noopener"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-emerald-600 text-white font-bold text-sm">
                            <i class="fa-brands fa-whatsapp"></i>
                            <span>{{ __('تحدث معنا عبر واتساب') }}</span>
                        </a>
                    </div>
                    @endif
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ==========================================================================
     9. FAQ SECTION - FREQUENTLY ASKED QUESTIONS
     ========================================================================== -->
<section class="py-16 sm:py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-10 sm:mb-12">
            <span class="text-xs font-black text-blue-700 uppercase tracking-wider">{{ __('الأسئلة المتكررة') }}</span>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-1">
                {{ __('إجابات وافية حول خدمات الطباعة والتغليف') }}
            </h2>
        </div>

        @php
        $faqs = [
        [
        'q' => __('ما هو الحد الأدنى للكميات في طلبات العلب والمطبوعات؟'),
        'a' => __('يختلف الحد الأدنى حسب نوع المنتج؛ ففي العلب الكرتونية الفاخرة الصلبة يبدأ من 100 علبة، وفي كراتين الشحن المضلعة من 300 كرتون، بينما تبدأ الكروت الشخصية والأكياس الورقية من 250 إلى 500 قطعة لضمان أفضل تكلفة اقتصادية للعميل.'),
        ],
        [
        'q' => __('هل توفرون عينة قبل اعتماد الطباعة للكميات الكبيرة؟'),
        'a' => __('بالتأكيد! نقوم بمراجعة التصميم هندسياً وتقديم بروفة رقمية ثلاثية الأبعاد أو عينة فعلية (Mockup / Sample) للطلبيات التجارية للتأكد من دقة المقاسات والألوان والخامة قبل تشغيل خط الإنتاج الكامل.'),
        ],
        [
        'q' => __('كم تستغرق مدة التنفيذ والتوريد؟'),
        'a' => __('تتراوح مدة التنفيذ للمطبوعات التجارية والكروت والستيكرات بين 2 إلى 4 أيام عمل، بينما تستغرق طلبات تفصيل العلب الفاخرة والأكياس المخصصة من 7 إلى 12 يوم عمل من تاريخ اعتماد العينة والتصميم.'),
        ],
        [
        'q' => __('هل يتوفر شحن وتوصيل خارج مدينة الرياض؟'),
        'a' => __('نعم، نوفر خدمة التوصيل المباشر داخل مدينة الرياض، والشحن السريع والآمن عبر شركات الشحن المعتمدة إلى جدة، الدمام، مكة المكرمة، وكافة مدن ومناطق المملكة العربية السعودية ودول الخليج.'),
        ],
        [
        'q' => __('ما هي صيغ ملفات التصميم المفضلة للطباعة؟'),
        'a' => __('للحصول على أعلى دقة طباعة ننصح بإرسال الملفات المفتوحة بصيغة PDF الطباعي أو Adobe Illustrator (AI) أو EPS مع تحويل النصوص إلى مسارات (Outlines) وضبط نظام الألوان على CMYK.'),
        ],
        ];
        @endphp

        <div class="space-y-3.5">
            @foreach($faqs as $idx => $faq)
            <div class="rounded-2xl border border-slate-200/90 bg-slate-50/50 overflow-hidden transition-all">
                <button type="button"
                    onclick="toggleFaq({{ $idx }})"
                    class="w-full px-5 sm:px-6 py-4 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} flex items-center justify-between gap-4 font-black text-xs sm:text-base text-slate-900 hover:text-blue-700 transition-colors">
                    <span>{{ $faq['q'] }}</span>
                    <span id="faq-icon-{{ $idx }}" class="w-7 h-7 rounded-lg bg-white border border-slate-200 text-slate-500 flex items-center justify-center flex-shrink-0 transition-transform duration-200 {{ $idx === 0 ? 'rotate-180 bg-blue-600 text-white border-blue-600' : '' }}">
                        <i class="fa-solid fa-chevron-down text-[11px]"></i>
                    </span>
                </button>
                <div id="faq-answer-{{ $idx }}" class="{{ $idx === 0 ? 'block' : 'hidden' }} px-5 sm:px-6 pb-5 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3 bg-white">
                    {{ $faq['a'] }}
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

<!-- Portfolio Lightbox Detail Modal -->
<div id="portfolio-lightbox-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="min-h-screen px-4 flex items-center justify-center py-6 sm:py-8">
        <div onclick="closePortfolioModal()" class="fixed inset-0 bg-slate-950/75 backdrop-blur-sm"></div>
        <div class="relative z-10 w-full max-w-2xl bg-white rounded-3xl overflow-hidden shadow-2xl border border-slate-200">
            <div class="relative h-60 sm:h-80 md:h-96 bg-slate-900">
                <img id="pmodal-image" src="" alt="" class="w-full h-full object-cover">
                <button type="button" onclick="closePortfolioModal()" class="absolute top-4 left-4 w-10 h-10 rounded-xl bg-slate-900/75 hover:bg-red-600 text-white flex items-center justify-center backdrop-blur-md transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <span id="pmodal-category" class="absolute top-4 right-4 px-3.5 py-1 rounded-full bg-blue-600 text-white text-xs font-bold shadow-md"></span>
            </div>
            <div class="p-5 sm:p-7 space-y-3 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                <div class="flex items-center gap-2 text-xs font-bold text-blue-700">
                    <i class="fa-solid fa-building"></i>
                    <span>{{ __('العميل:') }} <strong id="pmodal-client"></strong></span>
                </div>
                <h3 id="pmodal-title" class="text-base sm:text-xl font-black text-slate-900"></h3>
                <p id="pmodal-description" class="text-xs sm:text-sm text-slate-600 leading-relaxed"></p>
                <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-2.5 sm:gap-3">
                    <button type="button"
                        onclick="closePortfolioModal(); openQuoteModal();"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-700 to-red-600 text-white text-xs sm:text-sm font-black shadow-md">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                        <span>{{ __('اطلب تنفيذ مشروع مماثل') }}</span>
                    </button>
                    <button type="button" onclick="closePortfolioModal()" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold text-center">
                        {{ __('إغلاق') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Filter Products on Homepage by Category
    function filterHomeProducts(categorySlug, btnEl) {
        document.querySelectorAll('.home-product-filter-btn').forEach(btn => {
            btn.classList.remove('bg-slate-900', 'text-white', 'font-black', 'shadow-sm');
            btn.classList.add('bg-slate-100', 'text-slate-700', 'font-bold');
        });
        if (btnEl) {
            btnEl.classList.remove('bg-slate-100', 'text-slate-700', 'font-bold');
            btnEl.classList.add('bg-slate-900', 'text-white', 'font-black', 'shadow-sm');
        }

        document.querySelectorAll('.home-product-item').forEach(item => {
            if (categorySlug === 'all' || item.dataset.category === categorySlug) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
    }

    // Filter Portfolios on Homepage by Category
    function filterHomePortfolio(categorySlug, btnEl) {
        document.querySelectorAll('.home-portfolio-filter-btn').forEach(btn => {
            btn.classList.remove('bg-blue-700', 'text-white', 'font-black', 'shadow-sm');
            btn.classList.add('bg-slate-100', 'text-slate-700', 'font-bold');
        });
        if (btnEl) {
            btnEl.classList.remove('bg-slate-100', 'text-slate-700', 'font-bold');
            btnEl.classList.add('bg-blue-700', 'text-white', 'font-black', 'shadow-sm');
        }

        document.querySelectorAll('.home-portfolio-item').forEach(item => {
            if (categorySlug === 'all' || item.dataset.category === categorySlug) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
    }

    // Portfolio Lightbox Modal
    function openPortfolioModal(data) {
        const modal = document.getElementById('portfolio-lightbox-modal');
        if (!modal || !data) return;

        document.getElementById('pmodal-image').src = data.image || 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?auto=format&fit=crop&w=800&q=80';
        document.getElementById('pmodal-image').alt = data.title || '';
        document.getElementById('pmodal-title').textContent = data.title || '';
        document.getElementById('pmodal-client').textContent = data.client || @json(__('عميل مميز'));
        document.getElementById('pmodal-category').textContent = data.category || @json(__('مطبوعات وتغليف'));
        document.getElementById('pmodal-description').textContent = data.description || '';

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closePortfolioModal() {
        const modal = document.getElementById('portfolio-lightbox-modal');
        if (!modal) return;
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // FAQ Accordion
    function toggleFaq(index) {
        const answer = document.getElementById('faq-answer-' + index);
        const icon = document.getElementById('faq-icon-' + index);
        if (!answer) return;

        const isHidden = answer.classList.contains('hidden');
        if (isHidden) {
            answer.classList.remove('hidden');
            if (icon) {
                icon.classList.add('rotate-180', 'bg-blue-600', 'text-white', 'border-blue-600');
                icon.classList.remove('bg-white', 'text-slate-500');
            }
        } else {
            answer.classList.add('hidden');
            if (icon) {
                icon.classList.remove('rotate-180', 'bg-blue-600', 'text-white', 'border-blue-600');
                icon.classList.add('bg-white', 'text-slate-500');
            }
        }
    }
</script>
@endpush

@endsection