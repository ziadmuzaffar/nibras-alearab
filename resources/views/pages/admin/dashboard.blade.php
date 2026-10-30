@extends('layouts.dashboard.app')

@section('title', __('لوحة التحكم الرئيسية'))

@section('content')
<div class="space-y-6">

    <!-- Welcome Hero Card -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-blue-950 to-blue-900 text-white p-6 sm:p-8 shadow-xl">
        <div class="relative z-10 max-w-2xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-600/30 text-red-300 border border-red-500/30 mb-3">
                <span class="w-1.5 h-1.5 rounded-full bg-red-400 animate-pulse"></span>
                {{ __('مطبعة نبراس العرب | لوحة الإدارة') }}
            </span>
            <h1 class="text-2xl sm:text-3xl font-black tracking-tight">{{ __('أهلاً بك،') }} {{ auth()->user()->name ?? __('المدير') }}</h1>
            <p class="text-sm text-slate-300 mt-2 leading-relaxed">
                {{ __('رؤية شاملة ومباشرة على نشاط المطبعة اليومي، متابعة طلبات عروض الأسعار الواردة، وإدارة المنتجات والمشاريع بكل سلاسة واحترافية.') }}
            </p>

            <div class="mt-6 flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.quote-requests.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-sm bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white shadow-lg shadow-red-950/40 transition-all">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                    <span>{{ __('طلبات عروض الأسعار') }}</span>
                    @if($pendingQuotes > 0)
                    <span class="px-2 py-0.5 rounded-full text-xs bg-white text-red-700 font-mono font-bold">{{ $pendingQuotes }} {{ __('جديدة') }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.reports.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-sm bg-white/10 hover:bg-white/20 text-white border border-white/20 backdrop-blur-md transition-all">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>{{ __('مركز التقارير والإحصائيات') }}</span>
                </a>
                <a href="{{ route('admin.products.create') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-sm bg-white/10 hover:bg-white/20 text-white border border-white/20 backdrop-blur-md transition-all">
                    <i class="fa-solid fa-plus"></i>
                    <span>{{ __('إضافة منتج جديد') }}</span>
                </a>
            </div>
        </div>

        <div class="absolute -left-10 -bottom-10 w-72 h-72 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- KPI Statistics Cards (Matching Exact Design of Other Pages) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Total Quote Requests -->
        <a href="{{ route('admin.quote-requests.index') }}" class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:border-blue-400 transition-all flex items-center justify-between group">
            <div>
                <p class="text-xs font-semibold text-slate-400">{{ __('إجمالي طلبات التسعير') }}</p>
                <p class="text-2xl sm:text-3xl font-black text-slate-800 mt-1 group-hover:text-blue-600 transition-colors">{{ number_format($totalQuotes) }}</p>
                <span class="text-[11px] font-medium text-emerald-600 mt-1 inline-block">{{ __('مكتملة:') }} {{ $completedQuotes }} ({{ $conversionRate }}%)</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 group-hover:bg-blue-600 group-hover:text-white transition-all flex items-center justify-center">
                <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
            </div>
        </a>

        <!-- Pending Inquiries -->
        <a href="{{ route('admin.quote-requests.index', ['status' => 'pending']) }}" class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:border-amber-400 transition-all flex items-center justify-between group">
            <div>
                <p class="text-xs font-semibold text-slate-400">{{ __('طلبات جديدة قيد الانتظار') }}</p>
                <p class="text-2xl sm:text-3xl font-black text-amber-600 mt-1">{{ number_format($pendingQuotes) }}</p>
                <span class="text-[11px] font-medium text-amber-600 mt-1 inline-block">{{ __('بانتظار المتابعة الفورية') }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 group-hover:bg-amber-500 group-hover:text-white transition-all flex items-center justify-center">
                <i class="fa-solid fa-clock text-xl"></i>
            </div>
        </a>

        <!-- Products Catalog -->
        <a href="{{ route('admin.products.index') }}" class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:border-blue-400 transition-all flex items-center justify-between group">
            <div>
                <p class="text-xs font-semibold text-slate-400">{{ __('إجمالي المنتجات والمطبوعات') }}</p>
                <p class="text-2xl sm:text-3xl font-black text-slate-800 mt-1 group-hover:text-blue-600 transition-colors">{{ number_format($totalProducts) }}</p>
                <span class="text-[11px] font-medium text-slate-500 mt-1 inline-block">{{ $activeProducts }} {{ __('منتج نشط') }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-all flex items-center justify-center">
                <i class="fa-solid fa-boxes-stacked text-xl"></i>
            </div>
        </a>

        <!-- Portfolios / Showcase -->
        <a href="{{ route('admin.portfolios.index') }}" class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-sm hover:border-blue-400 transition-all flex items-center justify-between group">
            <div>
                <p class="text-xs font-semibold text-slate-400">{{ __('معرض الأعمال والمشاريع') }}</p>
                <p class="text-2xl sm:text-3xl font-black text-slate-800 mt-1 group-hover:text-blue-600 transition-colors">{{ number_format($totalPortfolios) }}</p>
                <span class="text-[11px] font-medium text-slate-500 mt-1 inline-block">{{ $totalCategories }} {{ __('قسم مطبوعات') }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-all flex items-center justify-center">
                <i class="fa-solid fa-images text-xl"></i>
            </div>
        </a>
    </div>

    <!-- Charts & Analytics Preview Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- 7-Day Inquiries Activity Chart (2 cols) -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <i class="fa-solid fa-chart-area text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">{{ __('نشاط طلبات التسعير (آخر 7 أيام)') }}</h3>
                        <p class="text-xs text-slate-400">{{ __('معدل ورود طلبات عروض الأسعار اليومية') }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.reports.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors">
                    {{ __('التقرير المفصل ←') }}
                </a>
            </div>
            <div class="h-64 w-full">
                <canvas id="dashboardWeeklyChart"></canvas>
            </div>
        </div>

        <!-- Status Breakdown Donut (1 col) -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                        <i class="fa-solid fa-pie-chart text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">{{ __('حالات الطلبات') }}</h3>
                        <p class="text-xs text-slate-400">{{ __('التوزيع العام للطلبات') }}</p>
                    </div>
                </div>
            </div>
            <div class="h-64 w-full flex items-center justify-center">
                <canvas id="dashboardStatusChart"></canvas>
            </div>
        </div>

    </div>

    <!-- Latest Quote Requests Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-red-50 text-red-600 flex items-center justify-center">
                    <i class="fa-solid fa-clock-rotate-left text-sm"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900">{{ __('أحدث طلبات عروض الأسعار الواردة') }}</h3>
                    <p class="text-xs text-slate-400">{{ __('آخر الطلبات المسجلة من العملاء عبر الموقع') }}</p>
                </div>
            </div>
            <a href="{{ route('admin.quote-requests.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors">
                {{ __('عرض جميع الطلبات') }} ({{ $totalQuotes }}) ←
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead>
                    <tr class="bg-slate-50/75 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider">
                        <th class="py-3 px-4">{{ __('رقم الطلب') }}</th>
                        <th class="py-3 px-4">{{ __('العميل') }}</th>
                        <th class="py-3 px-4">{{ __('المنتج المطلوب') }}</th>
                        <th class="py-3 px-4 text-center">{{ __('الكمية') }}</th>
                        <th class="py-3 px-4 text-center">{{ __('الحالة') }}</th>
                        <th class="py-3 px-4">{{ __('الوقت') }}</th>
                        <th class="py-3 px-4 text-center">{{ __('إجراء سريع') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($recentQuotes as $quote)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-3 px-4 font-mono font-bold text-slate-500">#{{ $quote->id }}</td>
                        <td class="py-3 px-4">
                            <span class="font-bold text-slate-900 block">{{ $quote->customer_name }}</span>
                            <span class="text-[11px] text-slate-400 font-mono" dir="ltr">{{ $quote->phone }}</span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="font-medium text-slate-900">{{ $quote->product ? $quote->product->name : __('غير محدد') }}</span>
                        </td>
                        <td class="py-3 px-4 text-center font-mono font-bold text-slate-800">
                            {{ number_format($quote->quantity) }}
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $quote->status_badge_classes }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $quote->status_dot_classes }}"></span>
                                {{ $quote->status_label }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-slate-400 whitespace-nowrap">
                            {{ $quote->created_at->locale(app()->getLocale())->diffForHumans() }}
                        </td>
                        <td class="py-3 px-4 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ $quote->whatsapp_url }}" target="_blank"
                                    title="{{ __('مراسلة واتساب') }}"
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white border border-emerald-200 transition-colors text-xs font-bold">
                                    <i class="fa-brands fa-whatsapp"></i>
                                    <span>{{ __('واتساب') }}</span>
                                </a>
                                <a href="{{ route('admin.quote-requests.show', $quote->id) }}"
                                    class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:bg-blue-600 hover:text-white transition-colors">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-6 text-center text-slate-400 text-sm">
                            {{ __('لا توجد طلبات تسعير مسجلة حالياً.') }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/vendor/chartjs/chart.umd.min.js') }}"></script>
<script>
    if (typeof Chart !== 'undefined') {
        Chart.defaults.font.family = 'Cairo, system-ui, sans-serif';
        Chart.defaults.color = '#64748b';
        const isRtl = document.documentElement.dir === 'rtl';

        // 1. Weekly Mini Trend
        const weeklyCtx = document.getElementById('dashboardWeeklyChart');
        if (weeklyCtx) {
            new Chart(weeklyCtx, {
                type: 'line',
                data: {
                    labels: {
                        !!json_encode($last7Days - > pluck('label')) !!
                    },
                    datasets: [{
                        label: @json(__('طلبات جديدة')),
                        data: {
                            !!json_encode($last7Days - > pluck('count')) !!
                        },
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#2563eb',
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    rtl: isRtl,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                stepSize: 1
                            },
                            grid: {
                                color: '#f1f5f9'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        // 2. Status Donut
        const statusCtx = document.getElementById('dashboardStatusChart');
        if (statusCtx) {
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: [@json(__('قيد الانتظار')), @json(__('تم التواصل')), @json(__('قيد الدراسة')), @json(__('مكتمل')), @json(__('ملغي'))],
                    datasets: [{
                        data: [{
                                {
                                    $statusBreakdown['pending']
                                }
                            },
                            {
                                {
                                    $statusBreakdown['contacted']
                                }
                            },
                            {
                                {
                                    $statusBreakdown['in_progress']
                                }
                            },
                            {
                                {
                                    $statusBreakdown['completed']
                                }
                            },
                            {
                                {
                                    $statusBreakdown['cancelled']
                                }
                            }
                        ],
                        backgroundColor: ['#f59e0b', '#3b82f6', '#8b5cf6', '#10b981', '#64748b'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    rtl: isRtl,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            rtl: isRtl,
                            labels: {
                                boxWidth: 10,
                                padding: 10,
                                font: {
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });
        }
    }
</script>
@endpush