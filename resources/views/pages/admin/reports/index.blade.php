@extends('layouts.dashboard.app')

@section('title', 'التقارير والإحصائيات')

@section('content')
<div class="space-y-6">

    <!-- Print Only Official Header -->
    <div class="hidden print:block mb-8 border-b-2 border-slate-900 pb-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-black text-slate-900">{{ setting('site_name', 'مطبعة نبراس العرب') }}</h1>
                <p class="text-sm text-slate-600 mt-1">تقرير أداء طلبات التسعير والمطبوعات الإحصائي</p>
                <div class="text-xs text-slate-500 mt-2 space-x-3 space-x-reverse">
                    <span><strong>الفترة:</strong> {{ $startDate ? $startDate->format('Y-m-d') : 'كافة السجلات' }} {{ $endDate ? 'إلى ' . $endDate->format('Y-m-d') : '' }}</span>
                    <span>•</span>
                    <span><strong>تاريخ الاستخراج:</strong> {{ now()->format('Y-m-d H:i') }}</span>
                    <span>•</span>
                    <span><strong>المستخدم:</strong> {{ auth()->user()->name ?? 'الإدارة' }}</span>
                </div>
            </div>
            <div class="w-16 h-16 rounded-xl border border-slate-300 p-1 flex items-center justify-center">
                <img src="{{ setting_image('site_logo', 'logo.png') }}" alt="Logo" class="max-h-full object-contain">
            </div>
        </div>
    </div>

    <!-- Page Header & Action -->
    <div class="print:hidden flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                <span>التقارير والإحصائيات</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">تحليل ومتابعة مؤشرات أداء طلبات التسعير، حركة المطبوعات، ومعدلات التحويل</p>
        </div>

        <div class="flex items-center gap-3">
            <!-- Print Report Button -->
            <button type="button" onclick="window.print()"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-700 bg-white border border-slate-200/90 hover:bg-slate-50 shadow-sm transition-all duration-200 active:scale-[0.98]">
                <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>طباعة التقرير (PDF)</span>
            </button>

            <!-- Export CSV Button -->
            <a href="{{ route('admin.reports.export', request()->query()) }}"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-blue-700 via-blue-600 to-red-600 hover:from-blue-800 hover:to-red-700 shadow-md shadow-blue-900/20 hover:shadow-lg transition-all duration-200 active:scale-[0.98]">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span>تصدير Excel (CSV)</span>
            </a>
        </div>
    </div>

    <!-- KPI Statistics Cards (Exact 4-Card System) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Total Quotes -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">إجمالي طلبات التسعير</p>
                <p class="text-2xl sm:text-3xl font-black text-slate-800 mt-1">{{ number_format($totalQuotes) }}</p>
                <span class="text-[11px] font-medium text-slate-500 mt-1 inline-block">ضمن الفترة المحددة</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center">
                <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
            </div>
        </div>

        <!-- Pending Quotes -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">طلبات جديدة قيد الانتظار</p>
                <p class="text-2xl sm:text-3xl font-black text-amber-600 mt-1">{{ number_format($pendingQuotes) }}</p>
                <span class="text-[11px] font-medium text-amber-600 mt-1 inline-block">بانتظار الرد والتواصل</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <i class="fa-solid fa-clock text-xl"></i>
            </div>
        </div>

        <!-- Completed Quotes & Conversion Rate -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">عروض أسعار منجزة</p>
                <p class="text-2xl sm:text-3xl font-black text-emerald-600 mt-1">{{ number_format($completedQuotes) }}</p>
                <span class="text-[11px] font-medium text-emerald-600 mt-1 inline-block">معدل التحويل: {{ $conversionRate }}%</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i class="fa-solid fa-circle-check text-xl"></i>
            </div>
        </div>

        <!-- Total Requested Units -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400">إجمالي قطع المطبوعات</p>
                <p class="text-2xl sm:text-3xl font-black text-purple-600 mt-1">{{ number_format($totalQuantity) }}</p>
                <span class="text-[11px] font-medium text-slate-500 mt-1 inline-block">متوسط: {{ number_format($avgQuantity) }} للطلب</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                <i class="fa-solid fa-boxes-stacked text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Filters & Date Toolbar -->
    <div class="print:hidden bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
        
        <!-- Period Preset Pills -->
        <div class="flex items-center gap-2 flex-wrap pb-3 border-b border-slate-100">
            <span class="text-xs font-bold text-slate-400 ml-1">تحديد سريع للفترة:</span>
            @php
                $presets = [
                    'all' => 'كافة السجلات',
                    'today' => 'اليوم',
                    'last_7_days' => 'آخر 7 أيام',
                    'this_month' => 'هذا الشهر',
                    'last_30_days' => 'آخر 30 يوم',
                    'this_year' => 'هذا العام',
                ];
            @endphp
            @foreach($presets as $key => $title)
                <button type="button"
                    onclick="setPeriod('{{ $key }}')"
                    class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ $period === $key ? 'bg-blue-700 text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">
                    {{ $title }}
                </button>
            @endforeach
        </div>

        <!-- Filter Form Controls -->
        <form id="reports-filter-form" action="{{ route('admin.reports.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 sm:gap-4 items-center">
            <input type="hidden" name="period" id="period-input" value="{{ $period }}">

            <!-- Status Filter -->
            <div class="lg:col-span-3">
                <select name="status"
                    class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all text-slate-700">
                    <option value="all" {{ $statusFilter === 'all' || !request()->has('status') ? 'selected' : '' }}>جميع حالات الطلبات</option>
                    @foreach(\App\Models\QuoteRequest::STATUSES as $statusKey => $statusTitle)
                        <option value="{{ $statusKey }}" {{ $statusFilter === $statusKey ? 'selected' : '' }}>
                            {{ $statusTitle }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Category Filter -->
            <div class="lg:col-span-3">
                <select name="category_id"
                    class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all text-slate-700">
                    <option value="all" {{ $categoryId === 'all' || !request()->has('category_id') ? 'selected' : '' }}>كافة أقسام المطبوعات</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ (string)$categoryId === (string)$category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- From Date -->
            <div class="lg:col-span-2">
                <input type="date" name="from_date" value="{{ $fromDate }}"
                    onchange="document.getElementById('period-input').value = 'custom';"
                    placeholder="من تاريخ"
                    class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all text-slate-700">
            </div>

            <!-- To Date -->
            <div class="lg:col-span-2">
                <input type="date" name="to_date" value="{{ $toDate }}"
                    onchange="document.getElementById('period-input').value = 'custom';"
                    placeholder="إلى تاريخ"
                    class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all text-slate-700">
            </div>

            <!-- Submit & Reset Actions -->
            <div class="lg:col-span-2 flex items-center gap-2">
                <button type="submit"
                    class="flex-1 py-2.5 px-4 rounded-xl text-xs sm:text-sm font-bold text-white bg-blue-700 hover:bg-blue-800 transition-colors shadow-sm">
                    تطبيق
                </button>
                @if(request()->hasAny(['period', 'status', 'category_id', 'from_date', 'to_date']))
                <a href="{{ route('admin.reports.index') }}"
                    class="p-2.5 rounded-xl border border-slate-200 text-slate-500 hover:text-red-600 hover:bg-red-50 transition-colors"
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
            <span>عرض نتائج الفترة:</span>
            <span class="text-blue-700 font-bold">
                @if($startDate && $endDate)
                    {{ $startDate->translatedFormat('d M Y') }} إلى {{ $endDate->translatedFormat('d M Y') }}
                @else
                    كافة السجلات التاريخية
                @endif
            </span>
            <span>•</span>
            <span class="text-slate-800 font-bold font-mono">{{ number_format($totalQuotes) }}</span>
            <span>طلب مسجل</span>
        </div>
        @if(request()->hasAny(['period', 'status', 'category_id', 'from_date', 'to_date']))
        <a href="{{ route('admin.reports.index') }}" class="text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span>إلغاء التصفية</span>
        </a>
        @endif
    </div>

    <!-- Interactive Visual Charts (2x2 Grid) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 sm:gap-6">

        <!-- Chart 1: Trend Over Time -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                <h3 class="text-sm sm:text-base font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-chart-line text-blue-600"></i>
                    <span>مسار طلبات عروض الأسعار</span>
                </h3>
                <span class="text-xs text-slate-400">حجم الطلبات عبر الزمن</span>
            </div>
            <div class="h-64 sm:h-72 w-full">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Status Breakdown -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                <h3 class="text-sm sm:text-base font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-chart-pie text-purple-600"></i>
                    <span>توزيع حالات الطلبات</span>
                </h3>
                <span class="text-xs text-slate-400">نسب الإنجاز والمتابعة</span>
            </div>
            <div class="h-64 sm:h-72 w-full flex items-center justify-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Chart 3: Top Products -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                <h3 class="text-sm sm:text-base font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-medal text-emerald-600"></i>
                    <span>أكثر المطبوعات طلباً</span>
                </h3>
                <span class="text-xs text-slate-400">أعلى المنتجات طلباً للتسعير</span>
            </div>
            <div class="h-64 sm:h-72 w-full">
                <canvas id="topProductsChart"></canvas>
            </div>
        </div>

        <!-- Chart 4: Category Distribution -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                <h3 class="text-sm sm:text-base font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-layer-group text-blue-600"></i>
                    <span>الطلب حسب أقسام المطبوعات</span>
                </h3>
                <span class="text-xs text-slate-400">توزيع اهتمام العملاء</span>
            </div>
            <div class="h-64 sm:h-72 w-full flex items-center justify-center">
                <canvas id="categoryDemandChart"></canvas>
            </div>
        </div>

    </div>

    <!-- Table 1: Top Requested Products Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm sm:text-base font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-trophy text-emerald-600"></i>
                <span>جدول أداء المنتجات الأكثر طلباً</span>
            </h3>
            <span class="text-xs font-semibold text-slate-500">حصة كل منتج من إجمالي الطلبات</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50/75 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider">
                        <th class="py-3 px-4">#</th>
                        <th class="py-3 px-4">اسم المنتج</th>
                        <th class="py-3 px-4">القسم والتصنيف</th>
                        <th class="py-3 px-4 text-center">عدد طلبات التسعير</th>
                        <th class="py-3 px-4 text-center">إجمالي الكميات</th>
                        <th class="py-3 px-4 text-center">صفقات مكتملة</th>
                        <th class="py-3 px-4">نسبة الطلب</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($topProductsList as $index => $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-3.5 px-4 font-mono font-bold text-slate-400">{{ $index + 1 }}</td>
                            <td class="py-3.5 px-4">
                                @if($item['product'])
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-slate-100 overflow-hidden flex-shrink-0 border border-slate-200">
                                            @if($item['product']->featured_image)
                                                <img src="{{ $item['product']->featured_image }}" alt="{{ $item['product']->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                    <i class="fa-solid fa-cube text-xs"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <a href="{{ route('admin.products.show', $item['product']->id) }}" class="font-bold text-slate-800 hover:text-blue-600 transition-colors">
                                            {{ $item['product']->name }}
                                        </a>
                                    </div>
                                @else
                                    <span class="text-slate-400 italic">غير معرف</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                @if($item['product'] && $item['product']->category)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200/60">
                                        {{ $item['product']->category->name }}
                                    </span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center font-bold text-slate-800 font-mono">
                                {{ number_format($item['total_requests']) }}
                            </td>
                            <td class="py-3.5 px-4 text-center font-mono text-slate-700">
                                {{ number_format($item['total_units']) }} <span class="text-xs text-slate-400">قطعة</span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-bold bg-emerald-50 text-emerald-700">
                                    {{ $item['completed_count'] }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 min-w-[140px]">
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 bg-slate-100 rounded-full h-2 overflow-hidden">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $item['percentage'] }}%"></div>
                                    </div>
                                    <span class="text-xs font-bold font-mono text-slate-600">{{ $item['percentage'] }}%</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400 text-xs sm:text-sm">
                                لا توجد بيانات مسجلة ضمن هذه الفترة.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Table 2: Filtered Detailed Quote Requests Log -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h3 class="text-sm sm:text-base font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-list-check text-blue-600"></i>
                <span>سجل طلبات عروض الأسعار المفصل</span>
            </h3>
            <a href="{{ route('admin.quote-requests.index') }}" class="text-xs font-bold text-blue-700 hover:text-blue-800 transition-colors">
                الانتقال لإدارة كافة الطلبات ←
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50/75 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider">
                        <th class="py-3 px-4">رقم الطلب</th>
                        <th class="py-3 px-4">العميل ومعلومات الاتصال</th>
                        <th class="py-3 px-4">المنتج المطلوب</th>
                        <th class="py-3 px-4 text-center">الكمية</th>
                        <th class="py-3 px-4 text-center">الحالة</th>
                        <th class="py-3 px-4">تاريخ الطلب</th>
                        <th class="py-3 px-4 print:hidden text-center">إجراء سريع</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($detailedQuotes as $quote)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-3.5 px-4 font-mono font-bold text-slate-500">
                                #{{ $quote->id }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-800">{{ $quote->customer_name }}</div>
                                <div class="text-xs text-slate-500 font-mono mt-0.5" dir="ltr">{{ $quote->phone }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($quote->product)
                                    <div class="font-medium text-slate-800">{{ $quote->product->name }}</div>
                                    @if($quote->product->category)
                                        <span class="text-[11px] text-slate-400">{{ $quote->product->category->name }}</span>
                                    @endif
                                @else
                                    <span class="text-slate-400 italic">طلب مخصص</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center font-mono font-bold text-slate-800">
                                {{ number_format($quote->quantity) }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold border {{ $quote->status_badge_classes }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $quote->status_dot_classes }}"></span>
                                    <span>{{ $quote->status_label }}</span>
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 whitespace-nowrap">
                                <div class="font-medium">{{ $quote->created_at->format('Y-m-d') }}</div>
                                <div class="text-[11px] text-slate-400">{{ $quote->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="py-3.5 px-4 print:hidden text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ $quote->whatsapp_url }}" target="_blank"
                                       title="مراسلة واتساب"
                                       class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white border border-emerald-200 transition-colors text-xs font-bold">
                                        <i class="fa-brands fa-whatsapp"></i>
                                        <span>واتساب</span>
                                    </a>
                                    <a href="{{ route('admin.quote-requests.show', $quote->id) }}"
                                       title="عرض التفاصيل"
                                       class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:bg-blue-600 hover:text-white transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400 text-xs sm:text-sm">
                                لم يتم العثور على أي طلبات تسعير تطابق الفلاتر المحددة.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($detailedQuotes->hasPages())
            <div class="p-4 border-t border-slate-100 print:hidden">
                {{ $detailedQuotes->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Styles for Printing -->
<style>
@media print {
    body {
        background: #ffffff !important;
        color: #0f172a !important;
    }
    aside, header, footer, .print\:hidden {
        display: none !important;
    }
    .print\:block {
        display: block !important;
    }
    main {
        padding: 0 !important;
        max-width: 100% !important;
        margin: 0 !important;
    }
    .shadow-sm, .shadow-md, .shadow-lg, .shadow-xl {
        box-shadow: none !important;
    }
    .border, .border-b, .border-t {
        border-color: #cbd5e1 !important;
    }
    canvas {
        max-height: 250px !important;
    }
    table {
        page-break-inside: auto;
    }
    tr {
        page-break-inside: avoid;
        page-break-after: auto;
    }
}
</style>
@endsection

@push('scripts')
<script src="{{ asset('assets/vendor/chartjs/chart.umd.min.js') }}"></script>
<script>
    function setPeriod(period) {
        document.getElementById('period-input').value = period;
        document.getElementById('reports-filter-form').submit();
    }

    if (typeof Chart !== 'undefined') {
        Chart.defaults.font.family = 'Cairo, system-ui, sans-serif';
        Chart.defaults.color = '#64748b';

        // 1. Trend Chart
        const trendCtx = document.getElementById('trendChart');
        if (trendCtx) {
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($trendData['labels']) !!},
                    datasets: [{
                        label: 'عدد طلبات التسعير',
                        data: {!! json_encode($trendData['counts']) !!},
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.08)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#2563eb',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    rtl: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            rtl: true,
                            backgroundColor: '#0f172a',
                            titleFont: { size: 12, weight: 'bold' },
                            bodyFont: { size: 12 },
                            padding: 10,
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0, stepSize: 1 },
                            grid: { color: '#f1f5f9' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // 2. Status Doughnut Chart
        const statusCtx = document.getElementById('statusChart');
        if (statusCtx) {
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($statusBreakdown['labels']) !!},
                    datasets: [{
                        data: {!! json_encode($statusBreakdown['counts']) !!},
                        backgroundColor: {!! json_encode($statusBreakdown['colors']) !!},
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    rtl: true,
                    cutout: '68%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            rtl: true,
                            labels: {
                                boxWidth: 12,
                                padding: 12,
                                font: { size: 11 }
                            }
                        },
                        tooltip: {
                            rtl: true,
                            backgroundColor: '#0f172a',
                            padding: 10,
                            cornerRadius: 8
                        }
                    }
                }
            });
        }

        // 3. Top Products Horizontal Bar Chart
        const topProductsCtx = document.getElementById('topProductsChart');
        if (topProductsCtx) {
            new Chart(topProductsCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($topProductsData['labels']) !!},
                    datasets: [{
                        label: 'عدد الطلبات',
                        data: {!! json_encode($topProductsData['requests']) !!},
                        backgroundColor: '#10b981',
                        borderRadius: 6,
                        barThickness: 18
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    rtl: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            rtl: true,
                            backgroundColor: '#0f172a',
                            padding: 10,
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: { precision: 0, stepSize: 1 },
                            grid: { color: '#f1f5f9' }
                        },
                        y: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // 4. Category Demand Bar Chart
        const categoryDemandCtx = document.getElementById('categoryDemandChart');
        if (categoryDemandCtx) {
            new Chart(categoryDemandCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($categoryDemandData['labels']) !!},
                    datasets: [{
                        label: 'طلبات التسعير',
                        data: {!! json_encode($categoryDemandData['counts']) !!},
                        backgroundColor: [
                            '#2563eb',
                            '#8b5cf6',
                            '#ec4899',
                            '#f59e0b',
                            '#10b981',
                            '#06b6d4',
                            '#64748b'
                        ],
                        borderRadius: 6,
                        barThickness: 22
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    rtl: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            rtl: true,
                            backgroundColor: '#0f172a',
                            padding: 10,
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0, stepSize: 1 },
                            grid: { color: '#f1f5f9' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }
    }
</script>
@endpush
