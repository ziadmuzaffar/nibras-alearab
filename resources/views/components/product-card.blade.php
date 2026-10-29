@props(['product'])

@php
    $specs = is_array($product->specifications) ? array_slice($product->specifications, 0, 2, true) : [];
    $imageUrl = $product->featured_image_url;
    $categorySlug = $product->category?->slug ?? 'general';
@endphp

<article data-category="{{ $categorySlug }}"
    class="product-card group bg-white rounded-3xl border border-slate-200/85 hover:border-blue-300/90 overflow-hidden flex flex-col h-full relative">

    <!-- Product Image Container -->
    <div class="relative h-56 sm:h-60 bg-slate-100 overflow-hidden">
        <a href="{{ route('website.products.show', $product->slug) }}" class="block w-full h-full">
            @if($imageUrl)
            <img src="{{ $imageUrl }}"
                alt="{{ $product->name }}"
                loading="lazy"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out"
                onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1589939705384-5185137a7f0f?auto=format&fit=crop&w=800&q=80';">
            @else
            <div class="w-full h-full bg-gradient-to-br from-slate-100 to-blue-50 flex flex-col items-center justify-center text-slate-400 p-6 text-center">
                <x-category-icon :icon="$product->category?->icon ?? 'box'" class="w-10 h-10 text-blue-600/50 mb-2" />
                <span class="text-xs font-bold text-slate-500">{{ $product->name }}</span>
            </div>
            @endif
        </a>

        <!-- Subtle Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent opacity-60 group-hover:opacity-75 transition-opacity pointer-events-none"></div>

        <!-- Top Badges Row -->
        <div class="absolute top-3.5 inset-x-3.5 flex items-center justify-between gap-2 pointer-events-none">
            @if($product->category)
            <a href="{{ route('website.categories.show', $product->category->slug) }}"
                class="pointer-events-auto inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/95 backdrop-blur-md text-slate-800 hover:bg-blue-600 hover:text-white text-[11px] font-extrabold shadow-md transition-colors">
                <x-category-icon :icon="$product->category->icon ?? 'box'" class="w-3.5 h-3.5 text-blue-600 group-hover:text-current" />
                <span class="truncate max-w-[140px]">{{ $product->category->name }}</span>
            </a>
            @else
            <span></span>
            @endif

            @if($product->is_featured)
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-400 text-slate-950 text-[11px] font-black shadow-md">
                <i class="fa-solid fa-star text-[10px]"></i>
                <span>مميز</span>
            </span>
            @endif
        </div>

        <!-- Bottom Image Overlay Info -->
        <div class="absolute bottom-3 inset-x-3.5 flex items-center justify-between text-white text-xs pointer-events-none">
            @if($product->images && $product->images->count() > 1)
            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg bg-slate-900/75 backdrop-blur-sm text-[11px] font-bold">
                <i class="fa-regular fa-images text-blue-300"></i>
                <span>{{ $product->images->count() }} صور</span>
            </span>
            @else
            <span></span>
            @endif

            <a href="{{ route('website.products.show', $product->slug) }}"
                class="pointer-events-auto w-8 h-8 rounded-xl bg-white/90 hover:bg-white text-slate-900 flex items-center justify-center shadow-md opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300"
                title="عرض التفاصيل والمواصفات">
                <i class="fa-solid fa-expand text-xs"></i>
            </a>
        </div>
    </div>

    <!-- Card Body -->
    <div class="p-5 sm:p-6 flex-1 flex flex-col justify-between space-y-4">
        <div class="space-y-2.5">
            <!-- Product Title -->
            <h3 class="text-base sm:text-lg font-black text-slate-900 group-hover:text-blue-700 transition-colors leading-snug line-clamp-2">
                <a href="{{ route('website.products.show', $product->slug) }}">
                    {{ $product->name }}
                </a>
            </h3>

            <!-- Short Description -->
            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed line-clamp-2">
                {{ $product->short_description ?: \Illuminate\Support\Str::limit(strip_tags($product->description), 110) }}
            </p>

            <!-- Technical Specifications Preview Chips -->
            @if(!empty($specs))
            <div class="pt-2 space-y-1.5 border-t border-slate-100">
                @foreach($specs as $specKey => $specVal)
                <div class="flex items-center justify-between gap-2 text-[11px] bg-slate-50/90 px-2.5 py-1.5 rounded-xl border border-slate-100">
                    <span class="font-bold text-slate-500 flex items-center gap-1.5 flex-shrink-0">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                        <span>{{ $specKey }}:</span>
                    </span>
                    <span class="font-bold text-slate-800 truncate text-left">{{ $specVal }}</span>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Card Footer Actions -->
        <div class="pt-3 border-t border-slate-100 flex items-center gap-2">
            @if(setting('enable_quotes', '1') === '1')
            <button type="button"
                onclick="openQuoteModal({{ $product->id }}, '{{ addslashes($product->name) }}')"
                class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-blue-700 to-blue-600 hover:from-blue-800 hover:to-red-600 text-white text-xs sm:text-sm font-black shadow-md shadow-blue-700/15 transition-all active:scale-[0.98]">
                <i class="fa-solid fa-file-invoice-dollar text-xs"></i>
                <span>اطلب تسعير</span>
            </button>
            @endif

            <a href="{{ route('website.products.show', $product->slug) }}"
                class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200/80 text-slate-700 hover:text-slate-950 text-xs font-bold transition-colors">
                <span>المواصفات</span>
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
            </a>

            @if(setting('whatsapp') || setting('mobile'))
            <a href="{{ whatsapp_link('مرحباً مطبعة نبراس العرب، أود الاستفسار وطلب تسعير لمنتج: ' . $product->name) }}"
                target="_blank"
                rel="noopener"
                title="استفسر عبر واتساب عن {{ $product->name }}"
                class="w-10 h-10 rounded-xl bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white border border-emerald-200/70 flex items-center justify-center flex-shrink-0 transition-all">
                <i class="fa-brands fa-whatsapp text-base"></i>
            </a>
            @endif
        </div>
    </div>
</article>

