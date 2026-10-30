@extends('layouts.dashboard.app')

@section('title', __('تفاصيل المنتج') . ': ' . $product->name)

@php
$stats = $stats ?? [
'images_count' => $product->images()->count(),
'quotes_count' => $product->quoteRequests()->count(),
];
@endphp

@section('content')
<div class="space-y-6">

    <!-- Header & Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                    <span>{{ __('تفاصيل المنتج') }}</span>
                </h1>
            </div>
            <p class="text-xs sm:text-sm text-slate-500 mt-1.5">{{ __('عرض كافة البيانات والمواصفات الفنية وصور المعرض لمنتج نبراس العرب') }}</p>
        </div>

        <!-- Header Actions -->
        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.products.index') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-slate-700 bg-white border border-slate-200/80 hover:bg-slate-50 hover:text-slate-900 shadow-2xs transition-all duration-200 active:scale-[0.98]">
                <i class="fa-solid fa-arrow-right text-xs"></i>
                <span>{{ __('العودة للقائمة') }}</span>
            </a>
        </div>
    </div>

    <!-- KPI Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Category -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">{{ __('التصنيف التابع له') }}</p>
                <a href="{{ route('admin.categories.show', $product->category) }}" class="text-base sm:text-lg font-black text-blue-700 hover:underline mt-1 block truncate max-w-[170px]" title="{{ $product->category->name }}">
                    {{ $product->category->name }}
                </a>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center">
                <x-category-icon :icon="$product->category->icon ?? 'box'" class="w-6 h-6" />
            </div>
        </div>

        <!-- Gallery Images Count -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">{{ __('صور المعرض الإضافية') }}</p>
                <p class="text-2xl sm:text-3xl font-black text-purple-600 mt-1">{{ number_format($stats['images_count']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                <i class="fa-solid fa-images text-xl"></i>
            </div>
        </div>

        <!-- Quote Requests -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">{{ __('طلبات عروض الأسعار') }}</p>
                <p class="text-2xl sm:text-3xl font-black text-rose-600 mt-1">{{ number_format($stats['quotes_count']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
            </div>
        </div>

        <!-- Specifications Count -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">{{ __('بنود المواصفات الفنية') }}</p>
                <p class="text-2xl sm:text-3xl font-black text-indigo-600 mt-1">
                    {{ is_array($product->specifications) ? count($product->specifications) : 0 }}
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <i class="fa-solid fa-sliders text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Main Content Layout (2 Columns) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Right Side: Details & Specs & Gallery (8 Columns) -->
        <div class="lg:col-span-8 space-y-6">

            <!-- Product Detailed Specifications Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <h3 class="text-base font-black text-slate-900 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center">
                            <i class="fa-solid fa-circle-info text-sm"></i>
                        </div>
                        <span>{{ __('معلومات وبيانات المنتج الأساسية') }}</span>
                    </h3>
                </div>

                <div class="divide-y divide-slate-100 text-xs sm:text-sm">
                    <!-- Product Full Name -->
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-2 text-slate-500 font-semibold">
                            <i class="fa-solid fa-tag text-slate-400 w-4"></i>
                            <span>{{ __('اسم المنتج الكامل') }}</span>
                        </div>
                        <span class="font-bold text-slate-900 text-sm sm:text-base">{{ $product->name }}</span>
                    </div>

                    <!-- Slug -->
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-2 text-slate-500 font-semibold">
                            <i class="fa-solid fa-link text-slate-400 w-4"></i>
                            <span>{{ __('الرابط المخصص (Slug)') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span dir="ltr" class="font-mono font-bold text-blue-700 bg-blue-50 border border-blue-100 px-3 py-1 rounded-lg text-xs">
                                {{ $product->slug }}
                            </span>
                            <button type="button"
                                onclick="copySlugToClipboard('{{ $product->slug }}')"
                                class="text-slate-400 hover:text-blue-600 transition-colors p-1"
                                title="{{ __('نسخ الرابط') }}">
                                <i class="fa-regular fa-copy text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Category Info -->
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-2 text-slate-500 font-semibold">
                            <i class="fa-solid fa-folder-tree text-slate-400 w-4"></i>
                            <span>{{ __('التصنيف المعتمد') }}</span>
                        </div>
                        <a href="{{ route('admin.categories.show', $product->category) }}" class="inline-flex items-center gap-2 text-blue-700 font-bold hover:underline">
                            <x-category-icon :icon="$product->category->icon ?? 'box'" class="w-4 h-4" />
                            <span>{{ $product->category->name }}</span>
                        </a>
                    </div>

                    <!-- Short Description -->
                    <div class="py-3.5 space-y-1.5">
                        <div class="flex items-center gap-2 text-slate-500 font-semibold">
                            <i class="fa-solid fa-align-right text-slate-400 w-4"></i>
                            <span>{{ __('الوصف المختصر') }}</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-700 leading-relaxed bg-slate-50/70 p-3 rounded-xl border border-slate-100">
                            {{ $product->short_description ?: __('لا يوجد وصف مختصر مضاف لهذا المنتج.') }}
                        </p>
                    </div>

                    <!-- Detailed Description -->
                    @if($product->description)
                    <div class="py-3.5 space-y-1.5">
                        <div class="flex items-center gap-2 text-slate-500 font-semibold">
                            <i class="fa-solid fa-file-lines text-slate-400 w-4"></i>
                            <span>{{ __('الوصف التفصيلي والتعليمات') }}</span>
                        </div>
                        <div class="text-xs sm:text-sm text-slate-700 leading-relaxed bg-slate-50/70 p-4 rounded-xl border border-slate-100 whitespace-pre-line">
                            {{ $product->description }}
                        </div>
                    </div>
                    @endif

                    <!-- Created At -->
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-2 text-slate-500 font-semibold">
                            <i class="fa-solid fa-calendar-plus text-slate-400 w-4"></i>
                            <span>{{ __('تاريخ الإنشاء') }}</span>
                        </div>
                        <span class="font-mono font-medium text-slate-700 text-xs">
                            {{ $product->created_at ? $product->created_at->format('Y/m/d - h:i A') : '—' }}
                        </span>
                    </div>

                    <!-- Updated At -->
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-2 text-slate-500 font-semibold">
                            <i class="fa-solid fa-clock-rotate-left text-slate-400 w-4"></i>
                            <span>{{ __('تاريخ آخر تعديل') }}</span>
                        </div>
                        <span class="font-mono font-medium text-slate-700 text-xs">
                            {{ $product->updated_at ? $product->updated_at->format('Y/m/d - h:i A') : '—' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Inquiries & Quote Requests for this product -->
            @if($product->quoteRequests->isNotEmpty())
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <h3 class="text-base font-black text-slate-900 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-700 flex items-center justify-center">
                            <i class="fa-solid fa-file-invoice-dollar text-sm"></i>
                        </div>
                        <span>{{ __('طلبات عروض الأسعار الواردة لهذا المنتج') }}</span>
                    </h3>
                </div>

                <div class="mt-4 divide-y divide-slate-100">
                    @foreach($product->quoteRequests->take(5) as $quote)
                    <div class="py-3 flex items-center justify-between gap-3 text-xs sm:text-sm">
                        <div>
                            <p class="font-bold text-slate-800">{{ $quote->customer_name }}</p>
                            <p class="text-xs text-slate-400 font-mono mt-0.5">{{ $quote->phone }} | {{ __('الكمية:') }} {{ $quote->quantity }}</p>
                        </div>
                        <span class="text-xs text-slate-400 font-mono">{{ $quote->created_at ? $quote->created_at->format('Y-m-d') : '' }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        <!-- Left Side: Featured Image & Quick Actions (4 Columns) -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Product Featured Image Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-sm font-black text-slate-900 flex items-center gap-2">
                        <i class="fa-regular fa-image text-blue-700"></i>
                        <span>{{ __('الصورة الرئيسية للمنتج') }}</span>
                    </h3>
                    @if($product->featured_image)
                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">
                        {{ __('مرفوعة') }}
                    </span>
                    @endif
                </div>

                <div class="mt-4">
                    @if($product->featured_image)
                    <div class="rounded-xl overflow-hidden border border-slate-200 bg-slate-100 group relative shadow-inner">
                        <img src="{{ asset($product->featured_image) }}"
                            alt="{{ $product->name }}"
                            class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                            <a href="{{ asset($product->featured_image) }}" target="_blank" class="px-3 py-1.5 bg-white/95 text-slate-800 text-xs font-bold rounded-xl shadow-lg hover:bg-white transition-all flex items-center gap-1.5">
                                <i class="fa-solid fa-up-right-from-square text-[10px]"></i>
                                <span>{{ __('عرض بالحجم الكامل') }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-xs">
                        <span class="text-slate-400 text-[11px] font-mono truncate max-w-[200px]" dir="ltr">{{ basename($product->featured_image) }}</span>
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-700 hover:text-blue-800 font-bold text-[11px] flex items-center gap-1">
                            <i class="fa-solid fa-pen text-[10px]"></i>
                            <span>{{ __('تغيير الصورة') }}</span>
                        </a>
                    </div>
                    @else
                    <div class="rounded-xl border-2 border-dashed border-slate-200 p-6 text-center bg-slate-50/50">
                        <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2">
                            <i class="fa-solid fa-box-open text-2xl"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-700">{{ __('لا توجد صورة رئيسية مرفوعة') }}</p>
                        <p class="text-[11px] text-slate-400 mt-1">{{ __('يُنصح برفع صورة عالية الجودة لزيادة رغبة العملاء في طلب التسعير') }}</p>
                        <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center gap-1.5 text-xs text-blue-700 font-bold hover:underline mt-3">
                            <i class="fa-solid fa-upload text-[11px]"></i>
                            <span>{{ __('رفع صورة الآن') }}</span>
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
                        <span>{{ __('إجراءات وتحكم سريع') }}</span>
                    </h3>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        {{ __('تحكم بإعدادات وحالة هذا المنتج مباشرة أو قم بإجراء التعديلات المطلوبة.') }}
                    </p>

                    <div class="space-y-2 pt-1">
                        <!-- Edit -->
                        <a href="{{ route('admin.products.edit', $product) }}"
                            class="w-full flex items-center justify-between p-3 rounded-xl bg-white/10 hover:bg-white/15 border border-white/10 text-xs font-bold transition-colors">
                            <span class="flex items-center gap-2">
                                <i class="fa-solid fa-pen text-blue-300"></i>
                                <span>{{ __('تعديل بيانات ومواصفات المنتج') }}</span>
                            </span>
                            <i class="fa-solid fa-chevron-left text-[10px] text-slate-400"></i>
                        </a>

                        <!-- Toggle Active -->
                        <form action="{{ route('admin.products.toggle-status', $product) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="w-full flex items-center justify-between p-3 rounded-xl bg-white/10 hover:bg-white/15 border border-white/10 text-xs font-bold transition-colors text-start">
                                <span class="flex items-center gap-2">
                                    <i class="fa-solid {{ $product->is_active ? 'fa-pause text-amber-300' : 'fa-play text-emerald-300' }}"></i>
                                    <span>{{ $product->is_active ? __('تعطيل وإخفاء المنتج') : __('تفعيل وإظهار المنتج') }}</span>
                                </span>
                                <i class="fa-solid fa-chevron-left text-[10px] text-slate-400"></i>
                            </button>
                        </form>

                        <!-- Toggle Featured -->
                        <form action="{{ route('admin.products.toggle-featured', $product) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="w-full flex items-center justify-between p-3 rounded-xl bg-white/10 hover:bg-white/15 border border-white/10 text-xs font-bold transition-colors text-start">
                                <span class="flex items-center gap-2">
                                    <i class="fa-solid fa-star text-amber-300"></i>
                                    <span>{{ $product->is_featured ? __('إلغاء تمييز المنتج') : __('تمييز المنتج بالرئيسية') }}</span>
                                </span>
                                <i class="fa-solid fa-chevron-left text-[10px] text-slate-400"></i>
                            </button>
                        </form>

                        <!-- List All Products -->
                        <a href="{{ route('admin.products.index') }}"
                            class="w-full flex items-center justify-between p-3 rounded-xl bg-white/10 hover:bg-white/15 border border-white/10 text-xs font-bold transition-colors">
                            <span class="flex items-center gap-2">
                                <i class="fa-solid fa-boxes-stacked text-purple-300"></i>
                                <span>{{ __('استعراض كافة المنتجات') }}</span>
                            </span>
                            <i class="fa-solid fa-chevron-left text-[10px] text-slate-400"></i>
                        </a>

                        <!-- Delete Button -->
                        <button type="button"
                            onclick="openDeleteModal('{{ $product->id }}', '{{ addslashes($product->name) }}', {{ $product->quoteRequests->count() }})"
                            class="w-full flex items-center justify-between p-3 rounded-xl bg-red-500/20 hover:bg-red-500/30 border border-red-500/30 text-xs font-bold text-red-300 hover:text-red-200 transition-colors text-start">
                            <span class="flex items-center gap-2">
                                <i class="fa-solid fa-trash-can text-red-400"></i>
                                <span>{{ __('حذف هذا المنتج') }}</span>
                            </span>
                            <i class="fa-solid fa-chevron-left text-[10px] text-red-400"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>

    </div>


    <!-- Specifications Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 flex-wrap gap-2">
            <h3 class="text-base font-black text-slate-900 flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center">
                    <i class="fa-solid fa-sliders text-sm"></i>
                </div>
                <span>{{ __('المواصفات الفنية وخيارات التنفيذ للمطبوعة') }}</span>
            </h3>
        </div>

        <div class="mt-4">
            @if(!empty($product->localized_specifications) && is_array($product->localized_specifications) && count($product->localized_specifications) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                @foreach($product->localized_specifications as $specKey => $specVal)
                <div class="group relative flex flex-col justify-between p-4 rounded-xl bg-slate-50/70 hover:bg-white border border-slate-200/80 hover:border-indigo-200 hover:shadow-xs transition-all duration-200">
                    <!-- Card Header: Icon & Spec Title -->
                    <div class="flex items-start justify-between gap-2 pb-2.5 border-b border-slate-200/60">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-7 h-7 rounded-lg bg-indigo-50 text-indigo-700 group-hover:bg-indigo-600 group-hover:text-white flex items-center justify-center shrink-0 transition-colors duration-200">
                                <i class="fa-solid fa-sliders text-xs"></i>
                            </div>
                            <span class="text-xs sm:text-sm font-bold text-slate-800 group-hover:text-indigo-900 transition-colors truncate" title="{{ $specKey }}">
                                {{ $specKey }}
                            </span>
                        </div>
                        <span class="text-[10px] font-mono font-semibold text-slate-400 bg-white px-2 py-0.5 rounded border border-slate-200/60 shrink-0">
                            #{{ $loop->iteration }}
                        </span>
                    </div>

                    <!-- Card Body: Value -->
                    <div class="pt-3 flex-1 flex items-center">
                        <p class="text-xs sm:text-sm text-slate-700 font-medium leading-relaxed break-words">
                            {{ $specVal }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="p-6 rounded-xl border-2 border-dashed border-slate-200 text-center bg-slate-50/50">
                <i class="fa-solid fa-sliders text-slate-400 text-xl mb-2"></i>
                <p class="text-xs font-bold text-slate-700">{{ __('لم يتم تحديد مواصفات فنية لهذا المنتج') }}</p>
                <p class="text-[11px] text-slate-400 mt-1">{{ __('تساعد المواصفات الفنية العميل في معرفة نوع الورق، المقاسات، والتشطيبات المتاحة') }}</p>
                <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center gap-1 text-xs text-blue-700 font-bold hover:underline mt-2">
                    <span>{{ __('إضافة مواصفات فنية') }}</span>
                </a>
            </div>
            @endif
        </div>
    </div>



    <!-- Gallery Images Showcase Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div>
                <h3 class="text-base font-black text-slate-900 flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center">
                        <i class="fa-solid fa-images text-sm"></i>
                    </div>
                    <span>{{ __('معرض الصور الواقعية والإضافية') }}</span>
                </h3>
                <p class="text-xs text-slate-500 mt-1">{{ __('صور زوايا المنتج والتشطيبات الفاخرة') }}</p>
            </div>
        </div>

        <div class="mt-4">
            @if($product->images->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
                @foreach($product->images as $img)
                <div class="h-48 sm:h-36 md:h-32 rounded-xl border border-slate-200 overflow-hidden bg-slate-100 shadow-2xs">
                    <img src="{{ asset($img->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                </div>
                @endforeach
            </div>
            @else
            <div class="p-6 rounded-xl border-2 border-dashed border-slate-200 text-center bg-slate-50/50">
                <i class="fa-regular fa-images text-slate-400 text-xl mb-2"></i>
                <p class="text-xs font-bold text-slate-700">{{ __('لا توجد صور إضافية في المعرض') }}</p>
                <p class="text-[11px] text-slate-400 mt-1">{{ __('يمكنك إضافة صور واقعية من زوايا متعددة لإظهار تفاصيل الطباعة وجودة القص') }}</p>
                <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center gap-1 text-xs text-blue-700 font-bold hover:underline mt-2">
                    <span>{{ __('رفع صور للمعرض') }}</span>
                </a>
            </div>
            @endif
        </div>
    </div>

</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-200">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 text-start space-y-4">

        <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
            <i class="fa-solid fa-triangle-exclamation text-xl"></i>
        </div>

        <div>
            <h3 class="text-lg font-bold text-slate-900">{{ __('تأكيد حذف المنتج') }}</h3>
            <p class="text-sm text-slate-500 mt-1">
                {{ __('هل أنت متأكد من رغبتك في حذف المنتج:') }} <strong id="modal-product-name" class="text-slate-800"></strong>؟
            </p>
            <div id="modal-quotes-warning" class="hidden mt-3 p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs flex items-start gap-2">
                <i class="fa-solid fa-circle-exclamation text-amber-600 mt-0.5"></i>
                <span>{{ __('تنبيه: هذا المنتج يحتوي على طلبات تسعير سابقة في النظام. سيتم حذف المنتج وصوره المرفقة نهائياً.') }}</span>
            </div>
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
    function copySlugToClipboard(slug) {
        navigator.clipboard.writeText(slug).then(() => {
            alert('{{ __('تم نسخ الرابط المخصص بنجاح:') }} ' + slug);
        });
    }

    function openDeleteModal(productId, productName, quotesCount) {
        const modal = document.getElementById('delete-modal');
        const form = document.getElementById('delete-form');
        const nameEl = document.getElementById('modal-product-name');
        const warningEl = document.getElementById('modal-quotes-warning');

        form.action = `/admin/products/${productId}`;
        nameEl.textContent = productName;

        if (quotesCount > 0) {
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

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });
</script>
@endpush
@endsection