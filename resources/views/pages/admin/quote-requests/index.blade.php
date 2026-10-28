@extends('layouts.dashboard.app')

@section('title', 'طلبات عروض الأسعار')

@section('content')
<div class="space-y-6">

    <!-- Page Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                <span>طلبات عروض الأسعار</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">متابعة وإدارة طلبات التسعير الواردة من العملاء والشركات والتواصل الفوري معهم</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.quote-requests.create') }}"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-700 via-blue-600 to-red-600 hover:from-blue-800 hover:to-red-700 shadow-md shadow-blue-900/20 hover:shadow-lg transition-all duration-200 active:scale-[0.98]">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                <span>إضافة طلب تسعير جديد</span>
            </a>
        </div>
    </div>

    <!-- KPI Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Total Quotes -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">إجمالي طلبات التسعير</p>
                <p class="text-2xl sm:text-3xl font-black text-slate-800 mt-1">{{ number_format($stats['total']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center">
                <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
            </div>
        </div>

        <!-- Pending Quotes -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">طلبات جديدة قيد الانتظار</p>
                <p class="text-2xl sm:text-3xl font-black text-amber-600 mt-1">{{ number_format($stats['pending']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <i class="fa-solid fa-clock text-xl"></i>
            </div>
        </div>

        <!-- In Progress / Contacted -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">قيد التواصل والتسعير</p>
                <p class="text-2xl sm:text-3xl font-black text-purple-600 mt-1">{{ number_format($stats['in_progress']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                <i class="fa-solid fa-headset text-xl"></i>
            </div>
        </div>

        <!-- Completed Quotes -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">عروض أسعار منجزة</p>
                <p class="text-2xl sm:text-3xl font-black text-emerald-600 mt-1">{{ number_format($stats['completed']) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i class="fa-solid fa-circle-check text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Filters & Search Bar -->
    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('admin.quote-requests.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 sm:gap-4 items-center">

            <!-- Search Query -->
            <div class="lg:col-span-4 relative">
                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="ابحث باسم العميل، الهاتف، البريد، أو المنتج..."
                    class="w-full pl-4 pr-10 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                @if(request('search'))
                <a href="{{ route('admin.quote-requests.index', array_merge(request()->except('search'))) }}" class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 hover:text-slate-600">
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
                    <option value="all" {{ request('status') === 'all' || !request()->has('status') ? 'selected' : '' }}>جميع الحالات</option>
                    @foreach(\App\Models\QuoteRequest::STATUSES as $statusKey => $statusTitle)
                    <option value="{{ $statusKey }}" {{ request('status') === $statusKey ? 'selected' : '' }}>
                        {{ $statusTitle }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Product Filter -->
            <div class="lg:col-span-3">
                <select name="product_id"
                    class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all text-slate-700">
                    <option value="all" {{ request('product_id') === 'all' || !request()->has('product_id') ? 'selected' : '' }}>جميع المنتجات</option>
                    <option value="custom" {{ request('product_id') === 'custom' ? 'selected' : '' }}>طلب مخصص (بدون منتج)</option>
                    @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Sort By & Action Buttons -->
            <div class="lg:col-span-2 flex items-center gap-2">
                <select name="sort"
                    class="w-full px-3 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all text-slate-700">
                    <option value="newest" {{ request('sort') === 'newest' || !request()->has('sort') ? 'selected' : '' }}>الأحدث أولاً</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>الأقدم أولاً</option>
                    <option value="customer_asc" {{ request('sort') === 'customer_asc' ? 'selected' : '' }}>اسم العميل (أ-ي)</option>
                    <option value="quantity_desc" {{ request('sort') === 'quantity_desc' ? 'selected' : '' }}>الأكبر كمية</option>
                    <option value="status" {{ request('sort') === 'status' ? 'selected' : '' }}>حسب الحالة</option>
                </select>

                <button type="submit"
                    class="py-2.5 px-4 rounded-xl text-xs sm:text-sm font-bold text-white bg-blue-700 hover:bg-blue-800 transition-colors shadow-sm flex-shrink-0">
                    تطبيق
                </button>

                @if(request()->hasAny(['search', 'status', 'product_id', 'sort']))
                <a href="{{ route('admin.quote-requests.index') }}"
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
            <span class="text-blue-700 font-bold font-mono">{{ $quoteRequests->count() }}</span>
            <span>من أصل</span>
            <span class="text-slate-800 font-bold font-mono">{{ $quoteRequests->total() }}</span>
            <span>طلب عرض سعر</span>
        </div>
        @if(request()->hasAny(['search', 'status', 'product_id', 'sort']))
        <a href="{{ route('admin.quote-requests.index') }}" class="text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span>إلغاء التصفية</span>
        </a>
        @endif
    </div>

    <!-- Quote Requests Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
        @forelse ($quoteRequests as $quote)
        <div class="bg-white rounded-2xl border border-slate-200/90 hover:border-blue-400/80 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden group">

            <!-- Card Header Banner -->
            <div class="p-5 pb-4 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white relative overflow-hidden">
                <div class="absolute -bottom-8 -left-8 w-24 h-24 rounded-full bg-blue-500/20 blur-xl pointer-events-none"></div>
                <div class="absolute -top-8 -right-8 w-24 h-24 rounded-full bg-red-500/15 blur-xl pointer-events-none"></div>

                <div class="relative z-10 flex items-center justify-between gap-2 mb-3">
                    <!-- Status Badge -->
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold border backdrop-blur-md {{ $quote->status_badge_classes }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $quote->status_dot_classes }}"></span>
                        <span>{{ $quote->status_label }}</span>
                    </span>

                    <!-- Request ID Badge -->
                    <span class="font-mono text-xs font-semibold px-2 py-0.5 rounded-md bg-white/10 text-slate-300 border border-white/10">
                        #{{ $quote->id }}
                    </span>
                </div>

                <!-- Customer Name -->
                <div class="relative z-10">
                    <h3 class="text-base font-black text-white group-hover:text-blue-200 transition-colors truncate" title="{{ $quote->customer_name }}">
                        {{ $quote->customer_name }}
                    </h3>
                    <p class="text-xs text-slate-300 flex items-center gap-1.5 mt-1 font-mono">
                        <i class="fa-solid fa-phone text-[11px] text-blue-400"></i>
                        <span dir="ltr">{{ $quote->phone }}</span>
                    </p>
                </div>
            </div>

            <!-- Card Body / Meta Information -->
            <div class="p-5 space-y-4 flex-1 flex flex-col justify-between">
                <div class="space-y-3">

                    <!-- Associated Product / Inquiry Type -->
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-box text-xs"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] text-slate-400 font-semibold leading-none">المنتج المطلوب</p>
                                @if($quote->product)
                                <p class="text-xs font-bold text-slate-800 mt-1 truncate" title="{{ $quote->product->name }}">
                                    {{ $quote->product->name }}
                                </p>
                                @else
                                <p class="text-xs font-bold text-slate-500 mt-1 italic">
                                    طلب مخصص عام (بدون منتج)
                                </p>
                                @endif
                            </div>
                        </div>

                        <!-- Quantity Pill -->
                        @if($quote->quantity)
                        <div class="flex-shrink-0 text-left">
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-slate-200/70 text-slate-800 text-[11px] font-bold font-mono">
                                <span>{{ number_format($quote->quantity) }}</span>
                                <span class="text-[10px] font-normal text-slate-500">قطعة</span>
                            </span>
                        </div>
                        @endif
                    </div>

                    <!-- Customer Email if available -->
                    @if($quote->email)
                    <div class="flex items-center gap-2 text-xs text-slate-600 px-1">
                        <i class="fa-regular fa-envelope text-slate-400 text-xs"></i>
                        <span class="truncate font-mono text-[11px]">{{ $quote->email }}</span>
                    </div>
                    @endif

                    <!-- Notes preview -->
                    @if($quote->notes)
                    <div class="p-3 rounded-xl bg-amber-50/50 border border-amber-100/70 text-xs text-slate-700">
                        <div class="flex items-center gap-1.5 text-amber-800 font-bold mb-1 text-[11px]">
                            <i class="fa-regular fa-comment-dots"></i>
                            <span>تفاصيل وملاحظات الطلب:</span>
                        </div>
                        <p class="line-clamp-2 text-slate-600 text-xs leading-relaxed" title="{{ $quote->notes }}">
                            {{ $quote->notes }}
                        </p>
                    </div>
                    @endif

                </div>

                <!-- Footer Time Info -->
                <div class="flex items-center justify-between text-xs text-slate-400 pt-3 border-t border-slate-100 mt-2">
                    <span class="flex items-center gap-1.5">
                        <i class="fa-regular fa-calendar text-slate-400 text-xs"></i>
                        <span>تاريخ الطلب</span>
                    </span>
                    <span class="font-mono text-[11px] text-slate-500 font-semibold">
                        {{ $quote->created_at ? $quote->created_at->format('Y-m-d') : '—' }}
                    </span>
                </div>
            </div>

            <!-- Card Bottom Actions -->
            <div class="px-4 py-3 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between gap-2">
                <!-- View Details -->
                <a href="{{ route('admin.quote-requests.show', $quote) }}"
                    class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:text-blue-700 hover:border-blue-300 hover:bg-blue-50/50 shadow-2xs transition-all">
                    <i class="fa-solid fa-eye text-xs text-slate-500"></i>
                    <span>عرض</span>
                </a>

                <!-- Edit -->
                <a href="{{ route('admin.quote-requests.edit', $quote) }}"
                    class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl bg-blue-50 border border-blue-200/80 text-xs font-bold text-blue-700 hover:bg-blue-100 hover:border-blue-300 shadow-2xs transition-all">
                    <i class="fa-solid fa-pen-to-square text-xs text-blue-600"></i>
                    <span>تعديل</span>
                </a>

                <!-- WhatsApp Direct Chat Button -->
                <a href="{{ $quote->whatsapp_url }}"
                    target="_blank"
                    class="p-2 rounded-xl text-emerald-600 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200/80 transition-colors"
                    title="محادثة واتساب سريعة مع العميل">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                </a>

                <!-- Delete Modal Trigger -->
                <button type="button"
                    onclick="openDeleteModal('{{ $quote->id }}', '{{ addslashes($quote->customer_name) }}')"
                    class="p-2 rounded-xl text-slate-400 hover:text-red-600 hover:bg-red-50 border border-transparent hover:border-red-200 transition-colors"
                    title="حذف طلب التسعير">
                    <i class="fa-regular fa-trash-can text-sm"></i>
                </button>
            </div>

        </div>
        @empty
        <!-- Empty State -->
        <div class="col-span-full bg-white rounded-2xl border border-slate-200/80 p-12 text-center shadow-sm">
            <div class="max-w-md mx-auto flex flex-col items-center">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-blue-50 to-indigo-50 border border-blue-100 text-blue-600 flex items-center justify-center mb-4 shadow-inner">
                    <i class="fa-solid fa-file-invoice text-3xl"></i>
                </div>
                <h3 class="text-lg font-black text-slate-800">لا توجد طلبات عروض أسعار حالياً</h3>
                <p class="text-xs sm:text-sm text-slate-500 mt-1 mb-6 leading-relaxed">
                    @if(request()->hasAny(['search', 'status', 'product_id', 'sort']))
                    لم نجد أي طلب يطابق شروط وفلاتر البحث المحددة. جرب تعديل الفلاتر أو إعادة ضبطها.
                    @else
                    يمكنك إضافة طلب تسعير يدوي جديد أو انتظار طلبات واستفسارات العملاء القادمة عبر الموقع.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'status', 'product_id', 'sort']))
                <a href="{{ route('admin.quote-requests.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                    <i class="fa-solid fa-arrow-rotate-right text-xs"></i>
                    <span>إعادة ضبط الفلاتر</span>
                </a>
                @else
                <a href="{{ route('admin.quote-requests.create') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-blue-700 to-blue-600 hover:from-blue-800 hover:to-blue-700 shadow-md shadow-blue-900/20 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>إضافة طلب جديد</span>
                </a>
                @endif
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($quoteRequests->hasPages())
    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        {{ $quoteRequests->links() }}
    </div>
    @endif

</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-200">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 text-right space-y-4">

        <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center">
            <i class="fa-solid fa-trash-can text-xl"></i>
        </div>

        <div>
            <h3 class="text-lg font-bold text-slate-900">تأكيد حذف طلب التسعير</h3>
            <p class="text-sm text-slate-500 mt-1">
                هل أنت متأكد من رغبتك في حذف طلب التسعير للعميل: <strong id="modal-customer-name" class="text-slate-800"></strong>؟
            </p>
            <p class="text-xs text-red-500 mt-2">
                سيتم حذف سجل الطلب نهائياً من قاعدة البيانات ولا يمكن استرجاعه.
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
    function openDeleteModal(quoteId, customerName) {
        const modal = document.getElementById('delete-modal');
        const form = document.getElementById('delete-form');
        const titleEl = document.getElementById('modal-customer-name');

        form.action = `/admin/quote-requests/${quoteId}`;
        titleEl.textContent = customerName;

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
