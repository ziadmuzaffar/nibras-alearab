@extends('layouts.dashboard.app')

@section('title', 'تفاصيل العمل: ' . $portfolio->title)

@section('content')
<div class="space-y-6">

    <!-- Header & Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                    <span>تفاصيل العمل</span>
                </h1>
            </div>
            <p class="text-xs sm:text-sm text-slate-500 mt-1.5">استعراض تفاصيل وبيانات العمل المنفذ وصورته في سابقة</p>
        </div>

        <!-- Header Actions -->
        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.portfolios.index') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-slate-700 bg-white border border-slate-200/80 hover:bg-slate-50 hover:text-slate-900 shadow-2xs transition-all duration-200 active:scale-[0.98]">
                <i class="fa-solid fa-arrow-right text-xs"></i>
                <span>العودة للقائمة</span>
            </a>
        </div>
    </div>

    <!-- KPI Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Category -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">التصنيف أو القسم</p>
                @if($portfolio->category)
                <a href="{{ route('admin.categories.show', $portfolio->category) }}" class="text-base sm:text-lg font-black text-blue-700 hover:underline mt-1 block truncate max-w-[170px]" title="{{ $portfolio->category->name }}">
                    {{ $portfolio->category->name }}
                </a>
                @else
                <p class="text-base sm:text-lg font-bold text-slate-500 mt-1">عام (بدون تصنيف)</p>
                @endif
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center">
                @if($portfolio->category)
                <x-category-icon :icon="$portfolio->category->icon ?? 'box'" class="w-6 h-6" />
                @else
                <i class="fa-solid fa-folder-open text-xl"></i>
                @endif
            </div>
        </div>

        <!-- Client Name -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">العميل / الجهة</p>
                <p class="text-base sm:text-lg font-black text-purple-700 mt-1 truncate max-w-[170px]" title="{{ $portfolio->client_name ?: 'غير محدد' }}">
                    {{ $portfolio->client_name ?: 'عميل خاص' }}
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center">
                <i class="fa-solid fa-handshake text-xl"></i>
            </div>
        </div>

        <!-- Date Created -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">تاريخ الإضافة</p>
                <p class="text-base sm:text-lg font-black text-emerald-600 mt-1 font-mono">
                    {{ $portfolio->created_at ? $portfolio->created_at->format('Y-m-d') : '—' }}
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i class="fa-solid fa-calendar-check text-xl"></i>
            </div>
        </div>

        <!-- Project ID -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">رقم السجل</p>
                <p class="text-2xl sm:text-3xl font-black text-slate-800 mt-1 font-mono">#{{ $portfolio->id }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center">
                <i class="fa-solid fa-hashtag text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Main Content Layout (2 Columns) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Right Side: Details & Image (8 Columns) -->
        <div class="lg:col-span-8 space-y-6">

            <!-- Showcase Image Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="p-5 sm:p-6 pb-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-base font-black text-slate-900 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center">
                            <i class="fa-solid fa-image text-sm"></i>
                        </div>
                        <span>معاينة صورة العمل</span>
                    </h3>

                    @if($portfolio->image)
                    <a href="{{ $portfolio->image_url }}" target="_blank"
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:text-blue-800 hover:underline">
                        <span>فتح بالدقة الكاملة</span>
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                    @endif
                </div>

                <div class="p-5 sm:p-6">
                    <div class="w-full rounded-2xl overflow-hidden bg-slate-900 border border-slate-200/80 relative shadow-inner group">
                        @if($portfolio->image)
                        <img src="{{ $portfolio->image_url }}"
                            alt="{{ $portfolio->title }}"
                            class="w-full max-h-[500px] object-cover mx-auto"
                            onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'600\' height=\'400\' viewBox=\'0 0 600 400\'><rect width=\'100%\' height=\'100%\' fill=\'%231e293b\'/><text x=\'50%\' y=\'50%\' dominant-baseline=\'middle\' text-anchor=\'middle\' fill=\'%2394a3b8\' font-size=\'22\'>نبراس العرب</text></svg>';">
                        @else
                        <div class="h-64 flex items-center justify-center text-slate-500">
                            <span>لا توجد صورة متوفرة</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Description & Details Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-base font-black text-slate-900 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center">
                            <i class="fa-solid fa-file-lines text-sm"></i>
                        </div>
                        <span>تفاصيل وشرح المشروع</span>
                    </h3>
                </div>

                <div>
                    <h4 class="text-lg font-black text-slate-900 mb-2 leading-relaxed">
                        {{ $portfolio->title }}
                    </h4>

                    @if($portfolio->description)
                    <div class="prose prose-slate max-w-none text-slate-600 text-sm leading-relaxed whitespace-pre-line bg-slate-50/70 p-4 rounded-xl border border-slate-200/60">
                        {{ $portfolio->description }}
                    </div>
                    @else
                    <p class="text-sm text-slate-400 italic">
                        لم تتم إضافة وصف تفصيلي لهذا العمل بعد. يمكنك تعديل السجل لإضافة المواصفات والملاحظات.
                    </p>
                    @endif
                </div>
            </div>

            <!-- Related Portfolios in same category -->
            @if($relatedPortfolios->isNotEmpty())
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 sm:p-6 space-y-4">
                <h3 class="text-base font-black text-slate-900 flex items-center gap-2.5 pb-3 border-b border-slate-100">
                    <div class="w-8 h-8 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center">
                        <i class="fa-solid fa-shapes text-sm"></i>
                    </div>
                    <span>أعمال أخرى مرتبطة في نفس القسم</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach($relatedPortfolios as $related)
                    <a href="{{ route('admin.portfolios.show', $related) }}"
                        class="group block bg-slate-50 hover:bg-white rounded-xl border border-slate-200/80 hover:border-blue-400 p-3 transition-all hover:shadow-md">
                        <div class="h-28 w-full rounded-lg overflow-hidden bg-slate-900 mb-2.5 relative">
                            <img src="{{ $related->image_url }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        <h5 class="text-xs font-bold text-slate-800 group-hover:text-blue-700 transition-colors line-clamp-1">
                            {{ $related->title }}
                        </h5>
                        @if($related->client_name)
                        <p class="text-[11px] text-slate-400 truncate mt-0.5">{{ $related->client_name }}</p>
                        @endif
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        <!-- Left Side: Metadata & Quick Actions (4 Columns) -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Information Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 space-y-4">
                <h3 class="text-base font-black text-slate-900 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    <span>بطاقة تعريف العمل</span>
                </h3>

                <div class="space-y-3.5 text-xs">
                    <!-- Category -->
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <span class="text-slate-500 font-semibold">التصنيف:</span>
                        @if($portfolio->category)
                        <a href="{{ route('admin.categories.show', $portfolio->category) }}"
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 font-bold border border-blue-100 hover:bg-blue-100 transition-colors">
                            <x-category-icon :icon="$portfolio->category->icon ?? 'box'" class="w-3.5 h-3.5" />
                            <span class="truncate max-w-[130px]">{{ $portfolio->category->name }}</span>
                        </a>
                        @else
                        <span class="text-slate-400 font-medium">غير محدد</span>
                        @endif
                    </div>

                    <!-- Client Name -->
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <span class="text-slate-500 font-semibold">اسم العميل:</span>
                        <span class="font-bold text-slate-800 truncate max-w-[150px]">
                            {{ $portfolio->client_name ?: 'غير محدد' }}
                        </span>
                    </div>

                    <!-- Created At -->
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <span class="text-slate-500 font-semibold">تاريخ الإضافة:</span>
                        <span class="font-mono text-slate-700 font-semibold">
                            {{ $portfolio->created_at ? $portfolio->created_at->format('Y-m-d H:i') : '—' }}
                        </span>
                    </div>

                    <!-- Updated At -->
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-semibold">آخر تعديل:</span>
                        <span class="font-mono text-slate-700 font-semibold">
                            {{ $portfolio->updated_at ? $portfolio->updated_at->format('Y-m-d H:i') : '—' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Category Card if exists -->
            @if($portfolio->category)
            <div class="bg-gradient-to-br from-slate-900 to-blue-950 text-white rounded-2xl p-5 shadow-lg space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600/50 border border-blue-400/30 flex items-center justify-center text-blue-300">
                        <x-category-icon :icon="$portfolio->category->icon ?? 'box'" class="w-5 h-5" />
                    </div>
                    <div>
                        <h4 class="text-sm font-black">{{ $portfolio->category->name }}</h4>
                        <p class="text-[11px] text-blue-200/70">قسم المطبوعات والتغليف</p>
                    </div>
                </div>
                <p class="text-xs text-slate-300 leading-relaxed">
                    هذا العمل معتمد كنموذج إرشادي يوضح جودة تنفيذ طلبات قسم {{ $portfolio->category->name }}.
                </p>
                <a href="{{ route('admin.categories.show', $portfolio->category) }}"
                    class="inline-flex items-center gap-2 text-xs font-bold text-blue-300 hover:text-white pt-1">
                    <span>استعراض كافة تفاصيل القسم</span>
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                </a>
            </div>
            @endif

            <!-- Quick Management Actions -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 space-y-3">
                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider pb-2 border-b border-slate-100">
                    إجراءات سريعة
                </h4>

                <a href="{{ route('admin.portfolios.edit', $portfolio) }}"
                    class="w-full py-2.5 px-4 rounded-xl text-xs font-bold text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200/80 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>تعديل بيانات العمل</span>
                </a>

                <a href="{{ route('admin.portfolios.create') }}"
                    class="w-full py-2.5 px-4 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>إضافة عمل جديد</span>
                </a>

                <button type="button"
                    onclick="openDeleteModal('{{ $portfolio->id }}', '{{ addslashes($portfolio->title) }}')"
                    class="w-full py-2.5 px-4 rounded-xl text-xs font-bold text-red-600 hover:bg-red-50 border border-red-200/80 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span>حذف هذا العمل نهائياً</span>
                </button>
            </div>

        </div>

    </div>

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
            <h3 class="text-lg font-bold text-slate-900">تأكيد حذف العمل</h3>
            <p class="text-sm text-slate-500 mt-1">
                هل أنت متأكد من رغبتك في حذف العمل: <strong id="modal-portfolio-title" class="text-slate-800"></strong>؟
            </p>
            <p class="text-xs text-red-500 mt-2">
                سيتم حذف سجل المشروع نهائياً وإزالة الصورة المرتبطة به.
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