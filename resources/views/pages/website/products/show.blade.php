@extends('layouts.website.app')

@section('title', $product->name)
@section('meta_description', $product->short_description ?: \Illuminate\Support\Str::limit(strip_tags($product->description), 155))

@section('content')

@php
    // Combine featured image + gallery images uniquely
    $allImages = collect();
    if ($product->featured_image_url) {
        $allImages->push($product->featured_image_url);
    }
    foreach ($product->images as $img) {
        if ($img->image_url && !$allImages->contains($img->image_url)) {
            $allImages->push($img->image_url);
        }
    }
    if ($allImages->isEmpty()) {
        $allImages->push('https://images.unsplash.com/photo-1549465220-1a8b9238cd48?auto=format&fit=crop&w=900&q=80');
    }
    $specs = is_array($product->specifications) ? $product->specifications : [];
@endphp

<!-- Top Breadcrumb Bar -->
<div class="bg-slate-900 text-slate-300 border-b border-slate-800 py-3.5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-3 flex-wrap">
        <nav class="flex items-center gap-2 text-xs font-bold flex-wrap min-w-0">
            <a href="{{ route('website.home') }}" class="text-slate-400 hover:text-white transition-colors">{{ __('الرئيسية') }}</a>
            <i class="fa-solid fa-chevron-left text-[10px] text-slate-600"></i>
            <a href="{{ route('website.products.index') }}" class="text-slate-400 hover:text-white transition-colors">{{ __('المنتجات') }}</a>
            @if($product->category)
            <i class="fa-solid fa-chevron-left text-[10px] text-slate-600"></i>
            <a href="{{ route('website.categories.show', $product->category->slug) }}" class="text-blue-400 hover:text-blue-300 transition-colors">
                {{ $product->category->name }}
            </a>
            @endif
            <i class="fa-solid fa-chevron-left text-[10px] text-slate-600"></i>
            <span class="text-white truncate max-w-[180px] sm:max-w-xs">{{ $product->name }}</span>
        </nav>

        <a href="{{ route('website.products.index') }}" class="shrink-0 text-xs font-bold text-slate-400 hover:text-white flex items-center gap-1.5 transition-colors">
            <i class="fa-solid fa-arrow-right text-[10px]"></i>
            <span>{{ __('العودة للكتالوج') }}</span>
        </a>
    </div>
</div>

<!-- Product Detail Main Section -->
<section class="py-8 sm:py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">

            <!-- Right Column: Interactive Product Gallery (6 Cols) -->
            <div class="lg:col-span-6 min-w-0 space-y-4 lg:sticky lg:top-28">

                <!-- Main Display Image -->
                <div class="relative rounded-3xl overflow-hidden bg-white border border-slate-200/90 shadow-lg h-[280px] sm:h-[400px] md:h-[440px] group">
                    <img id="main-product-image"
                        src="{{ $allImages->first() }}"
                        alt="{{ $product->name }}"
                        class="w-full h-full object-cover transition-all duration-500"
                        onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1589939705384-5185137a7f0f?auto=format&fit=crop&w=900&q=80';">

                    <!-- Badges Overlay -->
                    <div class="absolute top-3.5 sm:top-4 inset-x-3.5 sm:inset-x-4 flex flex-wrap items-center justify-between gap-2">
                        @if($product->category)
                        <a href="{{ route('website.categories.show', $product->category->slug) }}"
                            class="inline-flex items-center gap-1.5 px-3 sm:px-3.5 py-1.5 rounded-full bg-white/95 backdrop-blur-md text-slate-900 text-[11px] sm:text-xs font-black shadow-md max-w-[68%] sm:max-w-none">
                            <x-category-icon :icon="$product->category->icon ?? 'box'" class="w-4 h-4 text-blue-600 shrink-0" />
                            <span class="truncate">{{ $product->category->name }}</span>
                        </a>
                        @endif

                        @if($product->is_featured)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-amber-400 text-slate-950 text-[11px] sm:text-xs font-black shadow-md shrink-0">
                            <i class="fa-solid fa-star"></i>
                            <span>{{ __('منتج مميز') }}</span>
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Thumbnails Strip -->
                @if($allImages->count() > 1)
                <div class="grid grid-cols-4 sm:grid-cols-5 gap-2.5 sm:gap-3">
                    @foreach($allImages as $idx => $imgUrl)
                    <button type="button"
                        onclick="switchProductImage('{{ $imgUrl }}', this)"
                        class="product-thumb-btn rounded-2xl overflow-hidden h-16 sm:h-20 border-2 {{ $idx === 0 ? 'border-blue-600 ring-2 ring-blue-600/20' : 'border-slate-200 opacity-75 hover:opacity-100' }} bg-white transition-all">
                        <img src="{{ $imgUrl }}" alt="{{ $product->name }} - {{ $idx + 1 }}" class="w-full h-full object-cover">
                    </button>
                    @endforeach
                </div>
                @endif

                <!-- Quality Guarantee Strip -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 sm:gap-3 pt-2">
                    <div class="bg-white p-3 sm:p-3.5 rounded-2xl border border-slate-200/80 flex sm:flex-col items-center justify-center gap-2.5 sm:gap-1 text-center">
                        <i class="fa-solid fa-swatchbook text-blue-600 text-base sm:text-lg shrink-0"></i>
                        <p class="text-xs sm:text-[11px] font-black text-slate-800">{{ __('خامات أصلية فاخرة') }}</p>
                    </div>
                    <div class="bg-white p-3 sm:p-3.5 rounded-2xl border border-slate-200/80 flex sm:flex-col items-center justify-center gap-2.5 sm:gap-1 text-center">
                        <i class="fa-solid fa-wand-magic-sparkles text-amber-500 text-base sm:text-lg shrink-0"></i>
                        <p class="text-xs sm:text-[11px] font-black text-slate-800">{{ __('تشطيبات مخصصة') }}</p>
                    </div>
                    <div class="bg-white p-3 sm:p-3.5 rounded-2xl border border-slate-200/80 flex sm:flex-col items-center justify-center gap-2.5 sm:gap-1 text-center">
                        <i class="fa-solid fa-truck-fast text-emerald-600 text-base sm:text-lg shrink-0"></i>
                        <p class="text-xs sm:text-[11px] font-black text-slate-800">{{ __('توريد لجميع المناطق') }}</p>
                    </div>
                </div>

            </div>

            <!-- Left Column: Product Info, Specifications & Direct Quote Form (6 Cols) -->
            <div class="lg:col-span-6 min-w-0 space-y-6 sm:space-y-7">

                <!-- Product Header & Description -->
                <div class="bg-white rounded-3xl border border-slate-200/85 p-5 sm:p-8 shadow-sm space-y-4">
                    <div class="flex flex-wrap items-center justify-between gap-2 text-xs text-slate-400 font-semibold">
                        <span>{{ __('كود المنتج:') }} <strong class="font-mono text-slate-700">#PRD-{{ str_pad($product->id, 3, '0', STR_PAD_LEFT) }}</strong></span>
                        <span class="inline-flex items-center gap-1.5 text-emerald-600 font-bold">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>{{ __('متاح للتنفيذ والتصنيع') }}</span>
                        </span>
                    </div>

                    <h1 class="text-xl sm:text-3xl font-black text-slate-900 leading-tight">
                        {{ $product->name }}
                    </h1>

                    @if($product->short_description)
                    <p class="text-xs sm:text-base font-bold text-blue-800 bg-blue-50/70 border border-blue-100 p-3.5 rounded-2xl leading-relaxed">
                        {{ $product->short_description }}
                    </p>
                    @endif

                    @if($product->description)
                    <div class="text-xs sm:text-sm text-slate-600 leading-relaxed space-y-2 pt-1">
                        <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider">{{ __('تفاصيل ووصف المنتج:') }}</h3>
                        <p class="whitespace-pre-line">{{ $product->description }}</p>
                    </div>
                    @endif

                    <!-- Quick Action Buttons -->
                    <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        @if(setting('enable_quotes', '1') === '1')
                        <a href="#product-quote-box"
                            class="flex-1 inline-flex items-center justify-center gap-2.5 px-5 sm:px-6 py-3.5 rounded-2xl bg-gradient-to-r from-blue-700 via-blue-600 to-red-600 hover:from-blue-800 hover:to-red-700 text-white font-black text-xs sm:text-sm shadow-lg shadow-blue-700/20 transition-all">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                            <span>{{ __('اطلب عرض سعر لهذا المنتج') }}</span>
                        </a>
                        @endif

                        @if(setting('whatsapp') || setting('mobile'))
                        <a href="{{ whatsapp_link(__('مرحباً مطبعة نبراس العرب، أود الاستفسار وطلب تسعير لمنتج:') . ' ' . $product->name) }}"
                            target="_blank"
                            rel="noopener"
                            class="inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm shadow-md transition-all">
                            <i class="fa-brands fa-whatsapp text-lg"></i>
                            <span>{{ __('استفسر عبر واتساب') }}</span>
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Technical Specifications Card -->
                @if(!empty($specs))
                <div class="bg-white rounded-3xl border border-slate-200/85 p-5 sm:p-8 shadow-sm space-y-4">
                    <div class="flex flex-wrap items-center justify-between gap-2 pb-3 border-b border-slate-100">
                        <h2 class="text-sm sm:text-lg font-black text-slate-900 flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-sliders text-sm"></i>
                            </span>
                            <span>{{ __('المواصفات الفنية والخيارات المتاحة') }}</span>
                        </h2>
                        <span class="text-[11px] font-bold text-slate-400 shrink-0">{{ __('قابلة للتخصيص') }}</span>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @foreach($specs as $specKey => $specVal)
                        <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-1.5 text-xs sm:text-sm">
                            <span class="font-extrabold text-slate-500 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-600 shrink-0"></span>
                                <span>{{ $specKey }}</span>
                            </span>
                            <span class="font-bold text-slate-900 sm:text-left">{{ $specVal }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Embedded Product Quote Request Form -->
                @if(setting('enable_quotes', '1') === '1')
                <div id="product-quote-box" class="bg-slate-900 text-white rounded-3xl p-5 sm:p-8 shadow-2xl border border-slate-800 space-y-5 relative overflow-hidden">
                    <div class="absolute -top-20 -left-20 w-56 h-56 rounded-full bg-blue-600/20 blur-3xl pointer-events-none"></div>

                    <div class="relative z-10 border-b border-slate-800 pb-4">
                        <span class="inline-block px-3 py-0.5 rounded-full bg-red-600/20 border border-red-500/30 text-red-300 text-[11px] font-bold mb-1.5">
                            {{ __('طلب تسعير مباشر') }}
                        </span>
                        <h3 class="text-base sm:text-xl font-black text-white">
                            {{ __('احصل على عرض سعر لـ') }} «{{ $product->name }}»
                        </h3>
                        <p class="text-xs text-slate-400 mt-1">
                            {{ __('حدد الكمية المطلوبة والمواصفات الخاصة بك وسنتواصل معك فوراً بعرض السعر.') }}
                        </p>
                    </div>

                    <form action="{{ route('website.quote.store') }}" method="POST" class="relative z-10 space-y-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-300 mb-1.5">{{ __('الاسم الكامل أو الجهة') }} <span class="text-red-400">*</span></label>
                                <input type="text"
                                    name="customer_name"
                                    value="{{ old('customer_name') }}"
                                    required
                                    placeholder="{{ __('الاسم أو اسم الشركة...') }}"
                                    class="w-full px-4 py-2.5 rounded-xl bg-slate-950/90 border border-slate-700 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-300 mb-1.5">{{ __('رقم الجوال') }} <span class="text-red-400">*</span></label>
                                <input type="tel"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    required
                                    dir="ltr"
                                    placeholder="05XXXXXXXX"
                                    class="w-full px-4 py-2.5 rounded-xl bg-slate-950/90 border border-slate-700 text-sm font-mono text-left text-white placeholder-slate-500 focus:outline-none focus:border-blue-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <div class="flex flex-wrap items-center justify-between gap-1.5 mb-1.5">
                                    <label class="text-xs font-bold text-slate-300">{{ __('الكمية المطلوبة') }}</label>
                                    <div class="flex gap-1 flex-wrap">
                                        @foreach([100, 500, 1000] as $preset)
                                        <button type="button" onclick="document.getElementById('prod_page_qty').value='{{ $preset }}'" class="px-2 py-0.5 rounded bg-slate-800 hover:bg-blue-600 text-[10px] font-mono text-slate-300 hover:text-white transition-colors">{{ $preset }}</button>
                                        @endforeach
                                    </div>
                                </div>
                                <input type="number"
                                    id="prod_page_qty"
                                    name="quantity"
                                    value="{{ old('quantity') }}"
                                    min="1"
                                    placeholder="{{ __('مثال: 500') }}"
                                    class="w-full px-4 py-2.5 rounded-xl bg-slate-950/90 border border-slate-700 text-sm font-mono text-white placeholder-slate-500 focus:outline-none focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-300 mb-1.5">{{ __('البريد الإلكتروني (اختياري)') }}</label>
                                <input type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    dir="ltr"
                                    placeholder="name@company.com"
                                    class="w-full px-4 py-2.5 rounded-xl bg-slate-950/90 border border-slate-700 text-sm font-mono text-left text-white placeholder-slate-500 focus:outline-none focus:border-blue-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-300 mb-1.5">{{ __('المقاسات المطلوبة أو ملاحظات إضافية') }}</label>
                            <textarea name="notes"
                                rows="3"
                                placeholder="{{ __('اذكر المقاسات أو ألوان الطباعة أو التشطيب المطلوب...') }}"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-950/90 border border-slate-700 text-xs sm:text-sm text-white placeholder-slate-500 focus:outline-none focus:border-blue-500">{{ old('notes') }}</textarea>
                        </div>

                        <button type="submit"
                            class="w-full py-3.5 px-6 rounded-xl bg-gradient-to-r from-blue-600 to-red-600 hover:from-blue-500 hover:to-red-500 text-white font-black text-xs sm:text-sm shadow-xl flex items-center justify-center gap-2 transition-all">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>{{ __('إرسال طلب التسعير لهذا المنتج') }}</span>
                        </button>
                    </form>
                </div>
                @endif

            </div>

        </div>

        <!-- Related Products Section -->
        @if($relatedProducts->count() > 0)
        <div class="mt-14 sm:mt-16 pt-10 sm:pt-12 border-t border-slate-200/80">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 mb-8">
                <div>
                    <span class="text-xs font-black text-blue-700 uppercase tracking-wider">{{ __('منتجات ذات صلة') }}</span>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 mt-0.5">{{ __('قد يهمك أيضاً من منتجات المطبعة') }}</h2>
                </div>
                <a href="{{ route('website.products.index') }}" class="self-start sm:self-auto shrink-0 text-xs sm:text-sm font-bold text-blue-700 hover:text-red-600 flex items-center gap-1.5">
                    <span>{{ __('عرض كل المنتجات') }}</span>
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
                @foreach($relatedProducts as $relProd)
                    <x-product-card :product="$relProd" />
                @endforeach
            </div>
        </div>
        @endif

    </div>
</section>

@push('scripts')
<script>
    function switchProductImage(imgUrl, btnEl) {
        const mainImg = document.getElementById('main-product-image');
        if (mainImg) {
            mainImg.src = imgUrl;
        }
        document.querySelectorAll('.product-thumb-btn').forEach(btn => {
            btn.classList.remove('border-blue-600', 'ring-2', 'ring-blue-600/20', 'opacity-100');
            btn.classList.add('border-slate-200', 'opacity-75');
        });
        if (btnEl) {
            btnEl.classList.remove('border-slate-200', 'opacity-75');
            btnEl.classList.add('border-blue-600', 'ring-2', 'ring-blue-600/20', 'opacity-100');
        }
    }
</script>
@endpush

@endsection

