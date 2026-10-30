@extends('layouts.dashboard.app')

@section('title', __('تفاصيل طلب عرض السعر') . ' #' . $quoteRequest->id)

@section('content')
<div class="space-y-6">

    <!-- Header & Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                    <span>{{ __('طلب عرض سعر') }}</span>
                </h1>
            </div>
            <p class="text-xs sm:text-sm text-slate-500 mt-1.5">{{ __('استعراض تفاصيل طلب التسعير ومعلومات العميل وخيارات التواصل والمتابعة') }}</p>
        </div>

        <!-- Header Actions -->
        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.quote-requests.index') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-slate-700 bg-white border border-slate-200/80 hover:bg-slate-50 hover:text-slate-900 shadow-2xs transition-all duration-200 active:scale-[0.98]">
                <i class="fa-solid fa-arrow-right text-xs"></i>
                <span>{{ __('العودة للقائمة') }}</span>
            </a>
        </div>
    </div>

    <!-- KPI Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Status Card -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">{{ __('حالة الطلب الحالية') }}</p>
                <p class="text-base sm:text-lg font-black text-slate-900 mt-1">{{ $quoteRequest->status_label }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl {{ $quoteRequest->status_badge_classes }} flex items-center justify-center">
                <i class="fa-solid fa-signal text-xl"></i>
            </div>
        </div>

        <!-- Product Card -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div class="min-w-0 pr-1">
                <p class="text-xs font-semibold text-slate-400">{{ __('المنتج المعني') }}</p>
                @if($quoteRequest->product)
                <a href="{{ route('admin.products.show', $quoteRequest->product) }}" class="text-base sm:text-lg font-black text-blue-700 hover:underline mt-1 block truncate max-w-[170px]" title="{{ $quoteRequest->product->name }}">
                    {{ $quoteRequest->product->name }}
                </a>
                @else
                <p class="text-base sm:text-lg font-bold text-slate-500 mt-1">{{ __('طلب مخصص عام') }}</p>
                @endif
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-box-open text-xl"></i>
            </div>
        </div>

        <!-- Quantity Card -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">{{ __('الكمية المطلوبة') }}</p>
                <p class="text-xl sm:text-2xl font-black text-slate-800 mt-1 font-mono">
                    {{ $quoteRequest->quantity ? number_format($quoteRequest->quantity) : __('غير محددة') }}
                    @if($quoteRequest->quantity)
                    <span class="text-xs font-normal text-slate-500 mr-1">{{ __('قطعة') }}</span>
                    @endif
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center">
                <i class="fa-solid fa-cubes-stacked text-xl"></i>
            </div>
        </div>

        <!-- Date Card -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">{{ __('تاريخ وتوقيت الطلب') }}</p>
                <p class="text-sm sm:text-base font-black text-emerald-600 mt-1 font-mono">
                    {{ $quoteRequest->created_at ? $quoteRequest->created_at->format('Y-m-d H:i') : '—' }}
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i class="fa-solid fa-calendar-check text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Main Content Layout (2 Columns) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Right Side: Details & Notes (8 Columns) -->
        <div class="lg:col-span-8 space-y-6">

            <!-- Product Overview Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                <h3 class="text-base font-black text-slate-900 border-b border-slate-100 pb-3 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center">
                            <i class="fa-solid fa-box text-sm"></i>
                        </div>
                        <span>{{ __('تفاصيل المنتج والخدمة المطلوبة') }}</span>
                    </div>
                    @if($quoteRequest->product)
                    <a href="{{ route('admin.products.show', $quoteRequest->product) }}"
                        class="text-xs font-bold text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1">
                        <span>{{ __('معاينة المنتج في الكتالوج') }}</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                    @endif
                </h3>

                @if($quoteRequest->product)
                <div class="flex flex-col sm:flex-row items-start gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100">
                    @if($quoteRequest->product->featured_image)
                    <img src="{{ asset($quoteRequest->product->featured_image) }}"
                        alt="{{ $quoteRequest->product->name }}"
                        class="w-24 h-24 rounded-xl object-cover border border-slate-200 bg-white flex-shrink-0"
                        onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\' viewBox=\'0 0 100 100\'><rect width=\'100%\' height=\'100%\' fill=\'%23e2e8f0\'/><text x=\'50%\' y=\'50%\' dominant-baseline=\'middle\' text-anchor=\'middle\' fill=\'%2364748b\' font-size=\'12\'>{{ __('نبراس') }}</text></svg>';">
                    @else
                    <div class="w-24 h-24 rounded-xl bg-slate-200 text-slate-500 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-box text-2xl"></i>
                    </div>
                    @endif

                    <div class="space-y-1.5 flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h4 class="text-base font-bold text-slate-900">{{ $quoteRequest->product->name }}</h4>
                            @if($quoteRequest->product->category)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-blue-100 text-blue-800 text-[11px] font-semibold">
                                {{ $quoteRequest->product->category->name }}
                            </span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                            {{ $quoteRequest->product->short_description ?: __('منتج مسجل في كتالوج مطبعة نبراس العرب') }}
                        </p>
                    </div>
                </div>
                @else
                <div class="p-4 rounded-xl bg-amber-50/70 border border-amber-200/80 flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-wand-magic-sparkles text-base"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-amber-900">{{ __('طلب مواصفات خاصة / مخصصة') }}</h4>
                        <p class="text-xs text-amber-700 mt-1 leading-relaxed">
                            {{ __('هذا الطلب لم يتم ربطه بمنتج جاهز من الكتالوج، بل هو استفسار أو طلب تسعير مخصص بمواصفات فريدة مقدمة من العميل.') }}
                        </p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Notes & Specifications Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                <h3 class="text-base font-black text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                        <i class="fa-regular fa-message text-sm"></i>
                    </div>
                    <span>{{ __('ملاحظات وتفاصيل المواصفات من العميل') }}</span>
                </h3>

                @if($quoteRequest->notes)
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 text-slate-800 text-sm leading-relaxed whitespace-pre-wrap font-sans">
                    {{ $quoteRequest->notes }}
                </div>
                @else
                <div class="p-8 text-center bg-slate-50/60 rounded-2xl border border-dashed border-slate-200 text-slate-400">
                    <i class="fa-regular fa-comment-dots text-3xl mb-2 block"></i>
                    <p class="text-xs font-semibold">{{ __('لم يرفق العميل أي ملاحظات إضافية مع الطلب.') }}</p>
                </div>
                @endif
            </div>

            <!-- Quick Status Transition Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                <h3 class="text-base font-black text-slate-900 border-b border-slate-100 pb-3 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center">
                            <i class="fa-solid fa-arrow-progress text-sm"></i>
                        </div>
                        <span>{{ __('تحديث حالة الطلب السريع') }}</span>
                    </div>
                    <span class="text-xs text-slate-400 font-normal">{{ __('تحديث فوري دون الحاجة لدخول شاشة التعديل') }}</span>
                </h3>

                <form action="{{ route('admin.quote-requests.update-status', $quoteRequest) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-3">
                    @csrf
                    @method('PATCH')

                    <select name="status" class="w-full sm:flex-1 h-12 px-4 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 text-sm font-semibold focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                        @foreach($statuses as $statusKey => $statusLabel)
                        <option value="{{ $statusKey }}" {{ $quoteRequest->status === $statusKey ? 'selected' : '' }}>
                            {{ __($statusLabel) }}
                        </option>
                        @endforeach
                    </select>

                    <button type="submit"
                        class="w-full sm:w-auto px-6 h-12 rounded-xl text-sm font-bold text-white bg-blue-700 hover:bg-blue-800 transition-colors shadow-sm flex items-center justify-center gap-2 flex-shrink-0">
                        <i class="fa-solid fa-check text-xs"></i>
                        <span>{{ __('تطبيق الحالة الجديدة') }}</span>
                    </button>
                </form>
            </div>

        </div>

        <!-- Left Side: Customer & Direct Contact (4 Columns) -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Customer Profile Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-5">
                <div class="text-center pb-4 border-b border-slate-100">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-700 text-white font-black text-2xl flex items-center justify-center mx-auto mb-3 shadow-lg shadow-blue-900/20">
                        {{ mb_substr($quoteRequest->customer_name, 0, 1, 'UTF-8') }}
                    </div>
                    <h3 class="text-lg font-black text-slate-900">{{ $quoteRequest->customer_name }}</h3>
                    <p class="text-xs text-slate-400 mt-0.5">{{ __('عميل طالب تسعير') }}</p>
                </div>

                <!-- Contact Channels -->
                <div class="space-y-3">
                    <!-- WhatsApp Direct -->
                    <a href="{{ $quoteRequest->whatsapp_url }}"
                        target="_blank"
                        class="w-full py-3 px-4 rounded-xl text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-md shadow-emerald-900/20 hover:shadow-lg transition-all flex items-center justify-center gap-2">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                        <span>{{ __('محادثة واتساب مباشرة') }}</span>
                    </a>

                    <!-- Direct Phone Call -->
                    <a href="tel:{{ $quoteRequest->phone }}"
                        class="w-full py-2.5 px-4 rounded-xl text-xs font-bold text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200/80 transition-colors flex items-center justify-center gap-2">
                        <i class="fa-solid fa-phone text-xs"></i>
                        <span dir="ltr">{{ $quoteRequest->phone }}</span>
                    </a>

                    <!-- Email if present -->
                    @if($quoteRequest->email)
                    <a href="mailto:{{ $quoteRequest->email }}?subject={{ urlencode(__('عرض سعر من مطبعة نبراس العرب') . ' #' . $quoteRequest->id) }}"
                        class="w-full py-2.5 px-4 rounded-xl text-xs font-bold text-slate-700 bg-slate-50 hover:bg-slate-100 border border-slate-200 transition-colors flex items-center justify-center gap-2 truncate">
                        <i class="fa-regular fa-envelope text-xs text-slate-500"></i>
                        <span class="truncate">{{ $quoteRequest->email }}</span>
                    </a>
                    @endif
                </div>

                <!-- Timeline Details -->
                <div class="pt-4 border-t border-slate-100 text-xs text-slate-500 space-y-2">
                    <div class="flex justify-between items-center py-1">
                        <span class="text-slate-400">{{ __('تاريخ الإرسال:') }}</span>
                        <span class="font-mono font-semibold text-slate-700">{{ $quoteRequest->created_at ? $quoteRequest->created_at->format('Y-m-d H:i') : '—' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-1">
                        <span class="text-slate-400">{{ __('الوقت المنقضي:') }}</span>
                        <span class="text-slate-700">{{ $quoteRequest->created_at ? $quoteRequest->created_at->diffForHumans() : '—' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-1">
                        <span class="text-slate-400">{{ __('آخر تحديث:') }}</span>
                        <span class="font-mono text-slate-700">{{ $quoteRequest->updated_at ? $quoteRequest->updated_at->format('Y-m-d H:i') : '—' }}</span>
                    </div>
                </div>
            </div>

            <!-- Related Requests -->
            @if($relatedRequests->isNotEmpty())
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                <h4 class="text-xs font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <i class="fa-solid fa-clock-rotate-left text-blue-600"></i>
                    <span>{{ __('طلبات أخرى ذات صلة') }}</span>
                </h4>
                <div class="space-y-3">
                    @foreach($relatedRequests as $rel)
                    <a href="{{ route('admin.quote-requests.show', $rel) }}"
                        class="block p-3 rounded-xl bg-slate-50 hover:bg-blue-50/60 border border-slate-100 hover:border-blue-200 transition-all group">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xs font-bold text-slate-800 group-hover:text-blue-700 truncate">
                                {{ $rel->customer_name }}
                            </span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded {{ $rel->status_badge_classes }}">
                                {{ $rel->status_label }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-[11px] text-slate-400 mt-1.5">
                            <span class="truncate">{{ $rel->product ? $rel->product->name : __('طلب مخصص') }}</span>
                            <span class="font-mono text-[10px]">{{ $rel->created_at ? $rel->created_at->format('Y-m-d') : '' }}</span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

    </div>

</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-200">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 text-start space-y-4">

        <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
            <i class="fa-solid fa-trash-can text-xl"></i>
        </div>

        <div>
            <h3 class="text-lg font-bold text-slate-900">{{ __('تأكيد حذف طلب عرض السعر') }}</h3>
            <p class="text-sm text-slate-500 mt-1">
                {{ __('هل أنت متأكد من رغبتك في حذف طلب التسعير رقم') }} <strong>#{{ $quoteRequest->id }}</strong> {{ __('للعميل:') }} <strong class="text-slate-800">{{ $quoteRequest->customer_name }}</strong>؟
            </p>
            <p class="text-xs text-red-500 mt-2">
                {{ __('سيتم حذف سجل الطلب نهائياً من قاعدة البيانات ولا يمكن استرجاعه.') }}
            </p>
        </div>

        <form method="POST" action="{{ route('admin.quote-requests.destroy', $quoteRequest) }}">
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
    function openDeleteModal() {
        const modal = document.getElementById('delete-modal');
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