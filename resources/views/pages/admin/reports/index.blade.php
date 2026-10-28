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

    <!-- Page Header & Action Buttons -->
    <div class="print:hidden flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                <span>التقارير والإحصائيات</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">تحليل ومتابعة مؤشرات أداء طلبات التسعير، حركة المطبوعات، ومعدلات التحويل</p>
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-3">
            <!-- Print Report Button -->
            <button type="button" onclick="window.print()"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-700 bg-white border border-slate-200/90 hover:bg-slate-50 shadow-xs transition-all duration-200 active:scale-[0.98]">
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

    <!-- KPI Statistics Cards (4-Card System) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-4 md:gap-5">
        <!-- Total Quotes -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div class="min-w-0">
                <p class="text-xs font-semibold text-slate-400 truncate">إجمالي طلبات التسعير</p>
                <p class="text-2xl sm:text-3xl font-black text-slate-800 mt-1 font-mono">{{ number_format($totalQuotes) }}</p>
                <span class="text-[11px] font-medium text-slate-500 mt-0.5 inline-block">ضمن الفترة المحددة</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0 mr-2">
                <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
            </div>
        </div>

        <!-- Pending Quotes -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div class="min-w-0">
                <p class="text-xs font-semibold text-slate-400 truncate">طلبات جديدة قيد الانتظار</p>
                <p class="text-2xl sm:text-3xl font-black text-amber-600 mt-1 font-mono">{{ number_format($pendingQuotes) }}</p>
                <span class="text-[11px] font-medium text-amber-600 mt-0.5 inline-block">بانتظار الرد والتواصل</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0 mr-2">
                <i class="fa-solid fa-clock text-xl"></i>
            </div>
        </div>

        <!-- Completed Quotes & Conversion Rate -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div class="min-w-0">
                <p class="text-xs font-semibold text-slate-400 truncate">عروض أسعار منجزة</p>
                <p class="text-2xl sm:text-3xl font-black text-emerald-600 mt-1 font-mono">{{ number_format($completedQuotes) }}</p>
                <span class="text-[11px] font-medium text-emerald-600 mt-0.5 inline-block">معدل التحويل: {{ $conversionRate }}%</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 mr-2">
                <i class="fa-solid fa-circle-check text-xl"></i>
            </div>
        </div>

        <!-- Total Requested Units -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div class="min-w-0">
                <p class="text-xs font-semibold text-slate-400 truncate">إجمالي قطع المطبوعات</p>
                <p class="text-2xl sm:text-3xl font-black text-purple-600 mt-1 font-mono">{{ number_format($totalQuantity) }}</p>
                <span class="text-[11px] font-medium text-slate-500 mt-0.5 inline-block">متوسط: {{ number_format($avgQuantity) }} للطلب</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center flex-shrink-0 mr-2">
                <i class="fa-solid fa-boxes-stacked text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Filters & Date Toolbar -->
    <div class="print:hidden bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
        
        <!-- Period Preset Pills -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none sm:flex-wrap sm:pb-3 border-b border-slate-100">
            <span class="text-xs font-bold text-slate-400 ml-1 flex-shrink-0">تحديد الفترة:</span>
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
                    class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all flex-shrink-0 whitespace-nowrap {{ $period === $key ? 'bg-blue-700 text-white shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">
                    {{ $title }}
                </button>
            @endforeach
        </div>

        <!-- Filter Form Controls -->
        <form id="reports-filter-form" action="{{ route('admin.reports.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 sm:gap-4 items-center">
            <input type="hidden" name="period" id="period-input" value="{{ $period }}">

            <!-- Status Filter -->
            <div class="lg:col-span-3">
                <label class="block text-[11px] font-bold text-slate-500 mb-1">حالة الطلب</label>
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
                <label class="block text-[11px] font-bold text-slate-500 mb-1">قسم المطبوعات</label>
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
                <label class="block text-[11px] font-bold text-slate-500 mb-1">من تاريخ</label>
                <input type="date" name="from_date" value="{{ $fromDate }}"
                    onchange="document.getElementById('period-input').value = 'custom';"
                    class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all text-slate-700">
            </div>

            <!-- To Date -->
            <div class="lg:col-span-2">
                <label class="block text-[11px] font-bold text-slate-500 mb-1">إلى تاريخ</label>
                <input type="date" name="to_date" value="{{ $toDate }}"
                    onchange="document.getElementById('period-input').value = 'custom';"
                    class="w-full px-3.5 py-2.5 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all text-slate-700">
            </div>

            <!-- Submit & Reset Actions -->
            <div class="lg:col-span-2 flex items-center gap-2 pt-0 sm:pt-4">
                <button type="submit"
                    class="flex-1 py-2.5 px-4 rounded-xl text-xs sm:text-sm font-bold text-white bg-blue-700 hover:bg-blue-800 transition-colors shadow-xs">
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
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs font-semibold text-slate-500 px-1">
        <div class="flex items-center gap-2 flex-wrap">
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

    <!-- Visual Interactive Charts (2x2 Grid) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">

        <!-- Chart 1: Trend Over Time -->
        <div class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                <h3 class="text-sm sm:text-base font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-chart-line text-blue-600"></i>
                    <span>مسار طلبات عروض الأسعار</span>
                </h3>
                <span class="text-[11px] sm:text-xs text-slate-400">حجم الطلبات عبر الزمن</span>
            </div>
            <div class="h-60 sm:h-72 w-full">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Status Breakdown -->
        <div class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                <h3 class="text-sm sm:text-base font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-chart-pie text-purple-600"></i>
                    <span>توزيع حالات الطلبات</span>
                </h3>
                <span class="text-[11px] sm:text-xs text-slate-400">نسب الإنجاز والمتابعة</span>
            </div>
            <div class="h-60 sm:h-72 w-full flex items-center justify-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Chart 3: Top Products -->
        <div class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                <h3 class="text-sm sm:text-base font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-medal text-emerald-600"></i>
                    <span>أكثر المطبوعات طلباً</span>
                </h3>
                <span class="text-[11px] sm:text-xs text-slate-400">أعلى المنتجات طلباً للتسعير</span>
            </div>
            <div class="h-60 sm:h-72 w-full">
                <canvas id="topProductsChart"></canvas>
            </div>
        </div>

        <!-- Chart 4: Category Distribution -->
        <div class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                <h3 class="text-sm sm:text-base font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-layer-group text-blue-600"></i>
                    <span>الطلب حسب أقسام المطبوعات</span>
                </h3>
                <span class="text-[11px] sm:text-xs text-slate-400">توزيع اهتمام العملاء</span>
            </div>
            <div class="h-60 sm:h-72 w-full flex items-center justify-center">
                <canvas id="categoryDemandChart"></canvas>
            </div>
        </div>

    </div>

    <!-- SECTION 1: Top Products Performance (Responsive Card Grid - No Tables) -->
    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 px-1">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center">
                    <i class="fa-solid fa-trophy text-sm"></i>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-800">أداء المنتجات الأكثر طلباً</h3>
                    <p class="text-xs text-slate-500">حصة كل منتج من إجمالي طلبات التسعير والكميات المنجزة</p>
                </div>
            </div>
            <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-xl self-start sm:self-auto border border-emerald-200/60">
                أعلى {{ count($topProductsList) }} منتجات نشاطاً
            </span>
        </div>

        @if(count($topProductsList) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-5">
                @foreach($topProductsList as $index => $item)
                    @php
                        $rank = $index + 1;
                        $rankBadgeColor = match($rank) {
                            1 => 'bg-amber-400 text-amber-950 ring-2 ring-amber-300',
                            2 => 'bg-slate-300 text-slate-900 ring-2 ring-slate-200',
                            3 => 'bg-amber-700 text-amber-100 ring-2 ring-amber-600',
                            default => 'bg-slate-100 text-slate-600'
                        };
                    @endphp
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all duration-200 p-4 sm:p-5 flex flex-col justify-between relative group">
                        
                        <!-- Top Meta: Rank & Category -->
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="w-7 h-7 rounded-lg text-xs font-black font-mono flex items-center justify-center {{ $rankBadgeColor }}">
                                #{{ $rank }}
                            </span>
                            @if($item['product'] && $item['product']->category)
                                <span class="px-2.5 py-0.5 rounded-lg text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200/60 truncate max-w-[140px]">
                                    {{ $item['product']->category->name }}
                                </span>
                            @else
                                <span class="text-[11px] text-slate-400">-</span>
                            @endif
                        </div>

                        <!-- Product Thumbnail & Title -->
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden flex-shrink-0 flex items-center justify-center">
                                @if($item['product'] && $item['product']->featured_image)
                                    <img src="{{ $item['product']->featured_image }}" alt="{{ $item['product']->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <i class="fa-solid fa-cube text-slate-300 text-base"></i>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                @if($item['product'])
                                    <a href="{{ route('admin.products.show', $item['product']->id) }}" class="font-bold text-sm text-slate-800 hover:text-blue-600 transition-colors line-clamp-2" title="{{ $item['product']->name }}">
                                        {{ $item['product']->name }}
                                    </a>
                                @else
                                    <span class="text-sm text-slate-400 italic">غير معرف</span>
                                @endif
                            </div>
                        </div>

                        <!-- Demand Percentage Bar -->
                        <div class="mb-4 bg-slate-50 rounded-xl p-2.5 border border-slate-100">
                            <div class="flex items-center justify-between text-xs mb-1.5">
                                <span class="text-slate-500 font-semibold text-[11px]">نسبة الطلب من الإجمالي</span>
                                <span class="font-black font-mono text-blue-700 text-xs">{{ $item['percentage'] }}%</span>
                            </div>
                            <div class="w-full bg-slate-200/80 rounded-full h-2 overflow-hidden">
                                <div class="bg-gradient-to-l from-blue-700 to-blue-500 h-2 rounded-full transition-all duration-500" style="width: {{ min(100, max(4, $item['percentage'])) }}%"></div>
                            </div>
                        </div>

                        <!-- Product KPI Metrics Grid -->
                        <div class="grid grid-cols-3 gap-2 pt-3 border-t border-slate-100 text-center">
                            <!-- Requests -->
                            <div class="p-2 rounded-xl bg-slate-50/70">
                                <p class="text-[10px] font-semibold text-slate-400 truncate">طلبات</p>
                                <p class="text-sm font-black text-slate-800 font-mono mt-0.5">{{ number_format($item['total_requests']) }}</p>
                            </div>
                            <!-- Units -->
                            <div class="p-2 rounded-xl bg-slate-50/70">
                                <p class="text-[10px] font-semibold text-slate-400 truncate">قطع</p>
                                <p class="text-sm font-black text-purple-700 font-mono mt-0.5">{{ number_format($item['total_units']) }}</p>
                            </div>
                            <!-- Completed -->
                            <div class="p-2 rounded-xl bg-emerald-50/60 border border-emerald-100/60">
                                <p class="text-[10px] font-semibold text-emerald-700 truncate">منجزة</p>
                                <p class="text-sm font-black text-emerald-700 font-mono mt-0.5">{{ number_format($item['completed_count']) }}</p>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl border border-slate-200/80 p-8 sm:p-12 text-center shadow-xs">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-xl mb-3">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
                <h4 class="font-bold text-slate-700 text-sm sm:text-base">لا توجد بيانات مطبوعات مسجلة</h4>
                <p class="text-xs text-slate-400 mt-1">لم يتم تسجيل أي طلبات تسعير للمنتجات خلال الفترة المحددة</p>
            </div>
        @endif
    </div>

    <!-- SECTION 2: Detailed Quote Requests Log (Responsive Card Grid - No Tables) -->
    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-1">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center">
                    <i class="fa-solid fa-list-check text-sm"></i>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-800">سجل طلبات عروض الأسعار المفصل</h3>
                    <p class="text-xs text-slate-500">استعراض تفاصيل طلبات العملاء وإجراءات التواصل السريع</p>
                </div>
            </div>
            <a href="{{ route('admin.quote-requests.index') }}" class="text-xs font-bold text-blue-700 hover:text-blue-800 transition-colors self-start sm:self-auto flex items-center gap-1">
                <span>الانتقال لإدارة كافة الطلبات</span>
                <i class="fa-solid fa-arrow-left text-[11px]"></i>
            </a>
        </div>

        @if($detailedQuotes->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-5">
                @foreach($detailedQuotes as $quote)
                    <div class="bg-white rounded-2xl border border-slate-200/80 hover:border-blue-300 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col justify-between overflow-hidden group">
                        
                        <!-- Card Header: Status & Quote ID -->
                        <div class="p-4 sm:p-5 pb-3 border-b border-slate-100 flex items-center justify-between gap-2">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold border {{ $quote->status_badge_classes }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $quote->status_dot_classes }}"></span>
                                <span>{{ $quote->status_label }}</span>
                            </span>

                            <span class="font-mono text-xs font-bold px-2 py-0.5 rounded-md bg-slate-100 text-slate-600">
                                #{{ $quote->id }}
                            </span>
                        </div>

                        <!-- Card Body: Customer & Request Information -->
                        <div class="p-4 sm:p-5 space-y-3.5 flex-1">
                            
                            <!-- Customer Details -->
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <h4 class="font-bold text-slate-900 text-sm truncate" title="{{ $quote->customer_name }}">
                                        {{ $quote->customer_name }}
                                    </h4>
                                    <a href="tel:{{ $quote->phone }}" class="text-xs text-slate-500 hover:text-blue-600 font-mono mt-0.5 inline-flex items-center gap-1" dir="ltr">
                                        <i class="fa-solid fa-phone text-[10px] text-slate-400"></i>
                                        <span>{{ $quote->phone }}</span>
                                    </a>
                                </div>
                                <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center flex-shrink-0 font-bold text-xs font-mono">
                                    {{ mb_substr($quote->customer_name, 0, 1) }}
                                </div>
                            </div>

                            <!-- Product Info Box -->
                            <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between gap-2">
                                <div class="min-w-0">
                                    <p class="text-[10px] font-semibold text-slate-400">المنتج المطلوب</p>
                                    @if($quote->product)
                                        <p class="text-xs font-bold text-slate-800 truncate mt-0.5" title="{{ $quote->product->name }}">
                                            {{ $quote->product->name }}
                                        </p>
                                        @if($quote->product->category)
                                            <span class="text-[10px] text-blue-600 font-medium">{{ $quote->product->category->name }}</span>
                                        @endif
                                    @else
                                        <p class="text-xs font-bold text-slate-500 italic mt-0.5">طلب مخصص (عام)</p>
                                    @endif
                                </div>
                                <div class="flex-shrink-0 text-left">
                                    <p class="text-[10px] font-semibold text-slate-400">الكمية</p>
                                    <span class="inline-flex items-center gap-1 text-xs font-black font-mono text-slate-800 mt-0.5">
                                        {{ number_format($quote->quantity) }}
                                        <span class="text-[10px] font-normal text-slate-400">قطعة</span>
                                    </span>
                                </div>
                            </div>

                            <!-- Date & Time -->
                            <div class="flex items-center justify-between text-xs text-slate-400 pt-1">
                                <span class="flex items-center gap-1">
                                    <i class="fa-regular fa-calendar text-[11px]"></i>
                                    <span>{{ $quote->created_at->format('Y-m-d') }}</span>
                                </span>
                                <span class="text-[11px] font-medium text-slate-400">
                                    {{ $quote->created_at->diffForHumans() }}
                                </span>
                            </div>

                        </div>

                        <!-- Card Footer: Quick Actions -->
                        <div class="p-3 sm:p-4 bg-slate-50/60 border-t border-slate-100 flex items-center gap-2 print:hidden">
                            <!-- WhatsApp Action -->
                            <a href="{{ $quote->whatsapp_url }}" target="_blank"
                               class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white border border-emerald-200/70 transition-all text-xs font-bold active:scale-[0.98]">
                                <i class="fa-brands fa-whatsapp text-sm"></i>
                                <span>واتساب</span>
                            </a>

                            <!-- View Details Action -->
                            <a href="{{ route('admin.quote-requests.show', $quote->id) }}"
                               class="inline-flex items-center justify-center gap-1 py-2 px-3.5 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all text-xs font-bold active:scale-[0.98]">
                                <i class="fa-solid fa-eye text-xs"></i>
                                <span>التفاصيل</span>
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Pagination Bar -->
            @if($detailedQuotes->hasPages())
                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs print:hidden">
                    {{ $detailedQuotes->links() }}
                </div>
            @endif
        @else
            <div class="bg-white rounded-2xl border border-slate-200/80 p-8 sm:p-12 text-center shadow-xs">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-xl mb-3">
                    <i class="fa-solid fa-file-circle-xmark"></i>
                </div>
                <h4 class="font-bold text-slate-700 text-sm sm:text-base">لم يتم العثور على أي طلبات</h4>
                <p class="text-xs text-slate-400 mt-1">لا توجد طلبات تسعير تطابق الفلاتر المحددة حالياً</p>
                @if(request()->hasAny(['period', 'status', 'category_id', 'from_date', 'to_date']))
                    <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center gap-1 mt-4 px-4 py-2 rounded-xl text-xs font-bold text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors">
                        <i class="fa-solid fa-rotate-right text-xs"></i>
                        <span>إعادة ضبط الفلاتر</span>
                    </a>
                @endif
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
    .shadow-xs, .shadow-sm, .shadow-md, .shadow-lg, .shadow-xl {
        box-shadow: none !important;
    }
    .border, .border-b, .border-t {
        border-color: #cbd5e1 !important;
    }
    canvas {
        max-height: 250px !important;
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
