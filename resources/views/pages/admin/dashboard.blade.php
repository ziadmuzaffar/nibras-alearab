@extends('layouts.dashboard.app')

@section('title', __('dashboard.dashboard_page_title'))

@section('content')
<div class="space-y-6 sm:space-y-8">

    <!-- Primary Vital KPIs (4 Cards System) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Card 1: Total Quotes -->
        <div class="relative overflow-hidden bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('dashboard.kpi_total_quotes') }}</span>
                    <h3 class="text-2xl sm:text-3xl font-black text-slate-800 mt-1 font-mono tracking-tight">
                        {{ number_format($totalQuotes) }}
                    </h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                    <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-500 flex items-center gap-1.5">
                    <i class="fa-solid fa-calendar-day text-[11px] text-blue-500"></i>
                    <span>{{ __('dashboard.kpi_today') }} <strong class="text-slate-700 font-mono">{{ number_format($todayQuotes) }}</strong></span>
                </span>
                <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">
                    <span>{{ __('dashboard.kpi_this_month', ['count' => $thisMonthQuotes]) }}</span>
                </span>
            </div>
        </div>

        <!-- Card 2: Pending Quotes -->
        <div class="relative overflow-hidden bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('dashboard.kpi_pending_quotes') }}</span>
                    <h3 class="text-2xl sm:text-3xl font-black text-amber-600 mt-1 font-mono tracking-tight">
                        {{ number_format($pendingQuotes) }}
                    </h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:scale-110 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300">
                    <i class="fa-solid fa-clock text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-500 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full {{ $pendingQuotes > 0 ? 'bg-amber-500 animate-ping' : 'bg-slate-300' }}"></span>
                    <span>{{ __('dashboard.kpi_unread') }} <strong class="text-amber-700 font-mono">{{ $unreadQuotes }}</strong></span>
                </span>
                <a href="{{ route('admin.quote-requests.index', ['status' => 'pending']) }}" class="text-[11px] font-bold text-amber-600 hover:text-amber-800 transition-colors inline-flex items-center gap-1">
                    <span>{{ __('dashboard.kpi_view_list') }}</span>
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                </a>
            </div>
        </div>

        <!-- Card 3: Completed Quotes & Conversion -->
        <div class="relative overflow-hidden bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('dashboard.kpi_completed_quotes') }}</span>
                    <h3 class="text-2xl sm:text-3xl font-black text-emerald-600 mt-1 font-mono tracking-tight">
                        {{ number_format($completedQuotes) }}
                    </h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                    <i class="fa-solid fa-circle-check text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-500 flex items-center gap-1">
                    <span>{{ __('dashboard.kpi_completion_rate') }}</span>
                    <strong class="text-emerald-700 font-bold">{{ $conversionRate }}%</strong>
                </span>
                <div class="w-16 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ min($conversionRate, 100) }}%"></div>
                </div>
            </div>
        </div>

        <!-- Card 4: Total Quantity Requested -->
        <div class="relative overflow-hidden bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ __('dashboard.kpi_total_quantities') }}</span>
                    <h3 class="text-2xl sm:text-3xl font-black text-purple-600 mt-1 font-mono tracking-tight">
                        {{ number_format($totalQuantityRequested) }}
                    </h3>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-110 group-hover:bg-purple-600 group-hover:text-white transition-all duration-300">
                    <i class="fa-solid fa-boxes-stacked text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-500">
                    {{ __('dashboard.kpi_avg_per_request') }}
                    <strong class="text-purple-700 font-mono">{{ $totalQuotes > 0 ? number_format(round($totalQuantityRequested / $totalQuotes)) : 0 }}</strong>
                </span>
                <span class="text-[11px] font-semibold text-slate-400">{{ __('dashboard.kpi_printed_piece') }}</span>
            </div>
        </div>
    </div>

    <!-- Secondary Catalog & Platform Metrics Strip -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <!-- Products -->
        <a href="{{ route('admin.products.index') }}" class="p-4 rounded-xl bg-white border border-slate-200/80 shadow-xs hover:border-blue-400 transition-all duration-200 group flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                <i class="fa-solid fa-box-open text-base"></i>
            </div>
            <div class="min-w-0">
                <div class="text-[11px] font-bold text-slate-400 truncate">{{ __('dashboard.metric_products_services') }}</div>
                <div class="text-lg font-black text-slate-800 font-mono">{{ number_format($totalProducts) }}</div>
                <div class="text-[10px] text-emerald-600 font-semibold">{{ $activeProducts }} {{ __('dashboard.metric_active') }}</div>
            </div>
        </a>

        <!-- Categories -->
        <a href="{{ route('admin.categories.index') }}" class="p-4 rounded-xl bg-white border border-slate-200/80 shadow-xs hover:border-purple-400 transition-all duration-200 group flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center flex-shrink-0 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                <i class="fa-solid fa-layer-group text-base"></i>
            </div>
            <div class="min-w-0">
                <div class="text-[11px] font-bold text-slate-400 truncate">{{ __('dashboard.metric_categories') }}</div>
                <div class="text-lg font-black text-slate-800 font-mono">{{ number_format($totalCategories) }}</div>
                <div class="text-[10px] text-purple-600 font-semibold">{{ $activeCategories }} {{ __('dashboard.metric_active_category') }}</div>
            </div>
        </a>

        <!-- Portfolios -->
        <a href="{{ route('admin.portfolios.index') }}" class="p-4 rounded-xl bg-white border border-slate-200/80 shadow-xs hover:border-pink-400 transition-all duration-200 group flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-pink-50 text-pink-700 flex items-center justify-center flex-shrink-0 group-hover:bg-pink-600 group-hover:text-white transition-colors">
                <i class="fa-solid fa-images text-base"></i>
            </div>
            <div class="min-w-0">
                <div class="text-[11px] font-bold text-slate-400 truncate">{{ __('dashboard.metric_portfolio') }}</div>
                <div class="text-lg font-black text-slate-800 font-mono">{{ number_format($totalPortfolios) }}</div>
                <div class="text-[10px] text-slate-400 font-semibold">{{ __('dashboard.metric_executed_projects') }}</div>
            </div>
        </a>

        <!-- Contacted / In Progress -->
        <a href="{{ route('admin.quote-requests.index', ['status' => 'in_progress']) }}" class="p-4 rounded-xl bg-white border border-slate-200/80 shadow-xs hover:border-indigo-400 transition-all duration-200 group flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center flex-shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                <i class="fa-solid fa-headset text-base"></i>
            </div>
            <div class="min-w-0">
                <div class="text-[11px] font-bold text-slate-400 truncate">{{ __('dashboard.metric_under_study') }}</div>
                <div class="text-lg font-black text-slate-800 font-mono">{{ number_format($inProgressQuotes + $contactedQuotes) }}</div>
                <div class="text-[10px] text-indigo-600 font-semibold">{{ __('dashboard.metric_processing') }}</div>
            </div>
        </a>
    </div>

    <!-- Interactive Visual Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Chart 1: 7-Day Trend (Spans 2 cols on lg) -->
        <div class="lg:col-span-2 bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-slate-100 mb-4">
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-chart-line text-blue-600"></i>
                        <span>{{ __('dashboard.chart_trend_title') }}</span>
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">{{ __('dashboard.chart_trend_subtitle') }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-bold text-blue-700 bg-blue-50 border border-blue-100">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        <span>{{ __('dashboard.chart_week_total') }} {{ number_format($thisWeekQuotes) }}</span>
                    </span>
                </div>
            </div>
            <div class="h-64 sm:h-72 w-full relative">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Status Breakdown Doughnut -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-chart-pie text-red-600"></i>
                        <span>{{ __('dashboard.chart_status_title') }}</span>
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">{{ __('dashboard.chart_status_subtitle') }}</p>
                </div>
                <span class="text-xs font-mono font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded-md">
                    {{ $totalQuotes }} {{ __('dashboard.chart_quote_count') }}
                </span>
            </div>

            <div class="h-52 sm:h-56 w-full relative">
                <canvas id="statusChart"></canvas>
            </div>

            <!-- Custom Status Legend Badges -->
            <div class="mt-4 pt-3 border-t border-slate-100 grid grid-cols-2 gap-2 text-xs">
                <div class="flex items-center justify-between p-1.5 rounded-lg bg-amber-50/60 border border-amber-100 text-amber-900">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <span class="text-[11px]">{{ __('dashboard.status_pending_badge') }}</span>
                    </span>
                    <strong class="font-mono text-xs">{{ $statusBreakdown['pending'] }}</strong>
                </div>

                <div class="flex items-center justify-between p-1.5 rounded-lg bg-blue-50/60 border border-blue-100 text-blue-900">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        <span class="text-[11px]">{{ __('dashboard.status_contacted_badge') }}</span>
                    </span>
                    <strong class="font-mono text-xs">{{ $statusBreakdown['contacted'] }}</strong>
                </div>

                <div class="flex items-center justify-between p-1.5 rounded-lg bg-purple-50/60 border border-purple-100 text-purple-900">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                        <span class="text-[11px]">{{ __('dashboard.status_pricing_badge') }}</span>
                    </span>
                    <strong class="font-mono text-xs">{{ $statusBreakdown['in_progress'] }}</strong>
                </div>

                <div class="flex items-center justify-between p-1.5 rounded-lg bg-emerald-50/60 border border-emerald-100 text-emerald-900">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span class="text-[11px]">{{ __('dashboard.status_completed_badge') }}</span>
                    </span>
                    <strong class="font-mono text-xs">{{ $statusBreakdown['completed'] }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Workflow Lifecycle Funnel -->
    <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
            <div>
                <h3 class="text-sm sm:text-base font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-arrows-split-up-and-left text-slate-600"></i>
                    <span>{{ __('dashboard.pipeline_title') }}</span>
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">{{ __('dashboard.pipeline_subtitle') }}</p>
            </div>
            <a href="{{ route('admin.quote-requests.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors inline-flex items-center gap-1">
                <span>{{ __('dashboard.pipeline_manage_all') }}</span>
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            <!-- Stage 1 -->
            <div class="p-3.5 rounded-xl border border-amber-200 bg-amber-50/40 relative">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-amber-800">1. {{ __('dashboard.stage_pending_title') }}</span>
                    <span class="text-xs font-bold font-mono px-2 py-0.5 rounded-full bg-amber-100 text-amber-800">{{ $pendingQuotes }}</span>
                </div>
                <p class="text-[11px] text-slate-500 mt-1">{{ __('dashboard.stage_pending_desc') }}</p>
                <div class="mt-2.5 h-1.5 bg-amber-200/60 rounded-full overflow-hidden">
                    <div class="bg-amber-500 h-1.5 rounded-full" style="width: {{ $totalQuotes > 0 ? round(($pendingQuotes / $totalQuotes) * 100) : 0 }}%"></div>
                </div>
            </div>

            <!-- Stage 2 -->
            <div class="p-3.5 rounded-xl border border-blue-200 bg-blue-50/40 relative">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-blue-800">2. {{ __('dashboard.stage_contacted_title') }}</span>
                    <span class="text-xs font-bold font-mono px-2 py-0.5 rounded-full bg-blue-100 text-blue-800">{{ $contactedQuotes }}</span>
                </div>
                <p class="text-[11px] text-slate-500 mt-1">{{ __('dashboard.stage_contacted_desc') }}</p>
                <div class="mt-2.5 h-1.5 bg-blue-200/60 rounded-full overflow-hidden">
                    <div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ $totalQuotes > 0 ? round(($contactedQuotes / $totalQuotes) * 100) : 0 }}%"></div>
                </div>
            </div>

            <!-- Stage 3 -->
            <div class="p-3.5 rounded-xl border border-purple-200 bg-purple-50/40 relative">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-purple-800">3. {{ __('dashboard.stage_pricing_title') }}</span>
                    <span class="text-xs font-bold font-mono px-2 py-0.5 rounded-full bg-purple-100 text-purple-800">{{ $inProgressQuotes }}</span>
                </div>
                <p class="text-[11px] text-slate-500 mt-1">{{ __('dashboard.stage_pricing_desc') }}</p>
                <div class="mt-2.5 h-1.5 bg-purple-200/60 rounded-full overflow-hidden">
                    <div class="bg-purple-500 h-1.5 rounded-full" style="width: {{ $totalQuotes > 0 ? round(($inProgressQuotes / $totalQuotes) * 100) : 0 }}%"></div>
                </div>
            </div>

            <!-- Stage 4 -->
            <div class="p-3.5 rounded-xl border border-emerald-200 bg-emerald-50/40 relative">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-emerald-800">4. {{ __('dashboard.stage_completed_title') }}</span>
                    <span class="text-xs font-bold font-mono px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">{{ $completedQuotes }}</span>
                </div>
                <p class="text-[11px] text-slate-500 mt-1">{{ __('dashboard.stage_completed_desc') }}</p>
                <div class="mt-2.5 h-1.5 bg-emerald-200/60 rounded-full overflow-hidden">
                    <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $totalQuotes > 0 ? round(($completedQuotes / $totalQuotes) * 100) : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2-Column Responsive Section: Recent Quotes (Card-based Flex/Grid) + Popular Categories -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Recent Quote Requests (8 cols on lg) -->
        <div class="lg:col-span-8 bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
            <div>
                <!-- Header -->
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div>
                        <h3 class="text-sm sm:text-base font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-clock-rotate-left text-blue-600"></i>
                            <span>{{ __('dashboard.recent_quotes_title') }}</span>
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">{{ __('dashboard.recent_quotes_subtitle') }}</p>
                    </div>
                    <a href="{{ route('admin.quote-requests.index') }}"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors">
                        <span>{{ __('dashboard.view_all_count', ['count' => $totalQuotes]) }}</span>
                        <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    </a>
                </div>

                <!-- Card-Based List (Completely Responsive Grid/Flex Cards) -->
                <div class="mt-4 space-y-3">
                    @forelse($recentQuotes as $quote)
                    <div class="group relative rounded-xl border border-slate-200/80 p-3.5 sm:p-4 hover:border-blue-300 hover:shadow-xs transition-all duration-200 bg-white">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">

                            <!-- Left / Primary Info: Avatar, Customer Name & Details -->
                            <div class="flex items-start gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-700 to-red-600 text-white flex items-center justify-center font-bold text-sm flex-shrink-0 shadow-xs">
                                    {{ mb_substr($quote->customer_name, 0, 1) }}
                                </div>
                                <div class="min-w-0 space-y-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h4 class="text-sm font-bold text-slate-900 truncate">
                                            {{ $quote->customer_name }}
                                        </h4>
                                        @if($quote->is_unread)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                            <span>{{ __('dashboard.badge_new') }}</span>
                                        </span>
                                        @endif
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold border {{ $quote->status_badge_classes }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $quote->status_dot_classes }}"></span>
                                            <span>{{ $quote->status_label }}</span>
                                        </span>
                                    </div>

                                    <!-- Product & Quantity Meta -->
                                    <div class="flex items-center gap-3 text-xs text-slate-500 flex-wrap">
                                        <span class="flex items-center gap-1 text-slate-700 font-medium">
                                            <i class="fa-solid fa-box text-slate-400 text-[10px]"></i>
                                            <span>{{ $quote->product?->name ?? __('dashboard.custom_or_general') }}</span>
                                        </span>
                                        <span class="text-slate-300">•</span>
                                        <span class="flex items-center gap-1 font-mono font-bold text-blue-700">
                                            <i class="fa-solid fa-layer-group text-slate-400 text-[10px]"></i>
                                            <span>{{ number_format($quote->quantity) }} {{ __('dashboard.piece') }}</span>
                                        </span>
                                        <span class="text-slate-300">•</span>
                                        <span class="flex items-center gap-1 text-slate-400 text-[11px]">
                                            <i class="fa-regular fa-clock text-[10px]"></i>
                                            <span>{{ $quote->created_at->locale(app()->getLocale())->diffForHumans() }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right / Quick Actions: WhatsApp & Details View -->
                            <div class="flex items-center gap-2 self-end sm:self-center flex-shrink-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-100 w-full sm:w-auto justify-end">
                                @if($quote->phone)
                                <a href="{{ $quote->whatsapp_url }}" target="_blank"
                                    class="inline-flex items-center justify-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 transition-colors"
                                    title="{{ __('dashboard.quick_whatsapp') }}">
                                    <i class="fa-brands fa-whatsapp text-sm"></i>
                                    <span class="hidden md:inline">{{ __('dashboard.whatsapp') }}</span>
                                </a>
                                @endif

                                <a href="{{ route('admin.quote-requests.show', $quote->id) }}"
                                    class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                                    <span>{{ __('dashboard.details') }}</span>
                                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50/50">
                        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                            <i class="fa-solid fa-inbox text-xl"></i>
                        </div>
                        <h4 class="text-sm font-bold text-slate-700">{{ __('dashboard.no_recent_quotes') }}</h4>
                        <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">{{ __('dashboard.no_recent_quotes_desc') }}</p>
                    </div>
                    @endforelse
                </div>
            </div>

            @if(count($recentQuotes) > 0)
            <div class="mt-4 pt-3 border-t border-slate-100 text-center">
                <a href="{{ route('admin.quote-requests.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors inline-flex items-center gap-1">
                    <span>{{ __('dashboard.go_to_full_quotes') }}</span>
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                </a>
            </div>
            @endif
        </div>

        <!-- Right Side: Popular Categories & Quick Shortcuts (4 cols on lg) -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Popular Categories -->
            <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                    <h3 class="text-sm sm:text-base font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-folder-tree text-purple-600"></i>
                        <span>{{ __('dashboard.top_categories_title') }}</span>
                    </h3>
                    <a href="{{ route('admin.categories.index') }}" class="text-xs font-bold text-purple-600 hover:text-purple-800">
                        {{ __('dashboard.manage') }}
                    </a>
                </div>

                <div class="space-y-3.5">
                    @forelse($popularCategories as $category)
                    @php
                    $percentage = $totalProducts > 0 ? round(($category->products_count / $totalProducts) * 100) : 0;
                    @endphp
                    <div>
                        <div class="flex items-center justify-between text-xs mb-1">
                            <span class="font-bold text-slate-700 truncate max-w-[180px]">{{ $category->name }}</span>
                            <div class="flex items-center gap-2">
                                <span class="font-mono text-slate-500">{{ $category->products_count }} {{ __('dashboard.product_count') }}</span>
                                <span class="font-mono font-bold text-purple-700 text-[11px]">{{ $percentage }}%</span>
                            </div>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-600 to-purple-600 h-2 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-slate-400 text-center py-4">{{ __('dashboard.no_categories') }}</p>
                    @endforelse
                </div>
            </div>

            <!-- Quick Management Shortcuts -->
            <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                <h3 class="text-sm sm:text-base font-bold text-slate-900 pb-3 border-b border-slate-100 mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-compass text-slate-600"></i>
                    <span>{{ __('dashboard.quick_shortcuts_title') }}</span>
                </h3>

                <div class="grid grid-cols-2 gap-2.5">
                    <a href="{{ route('admin.products.create') }}" class="p-3 rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-200/80 hover:border-blue-200 transition-colors flex flex-col items-center text-center gap-1.5 group">
                        <i class="fa-solid fa-plus-circle text-blue-600 text-lg group-hover:scale-110 transition-transform"></i>
                        <span class="text-xs font-bold text-slate-700 group-hover:text-blue-700">{{ __('dashboard.add_product') }}</span>
                    </a>

                    <a href="{{ route('admin.categories.create') }}" class="p-3 rounded-xl bg-slate-50 hover:bg-purple-50 border border-slate-200/80 hover:border-purple-200 transition-colors flex flex-col items-center text-center gap-1.5 group">
                        <i class="fa-solid fa-folder-plus text-purple-600 text-lg group-hover:scale-110 transition-transform"></i>
                        <span class="text-xs font-bold text-slate-700 group-hover:text-purple-700">{{ __('dashboard.add_category') }}</span>
                    </a>

                    <a href="{{ route('admin.reports.index') }}" class="p-3 rounded-xl bg-slate-50 hover:bg-emerald-50 border border-slate-200/80 hover:border-emerald-200 transition-colors flex flex-col items-center text-center gap-1.5 group">
                        <i class="fa-solid fa-file-excel text-emerald-600 text-lg group-hover:scale-110 transition-transform"></i>
                        <span class="text-xs font-bold text-slate-700 group-hover:text-emerald-700">{{ __('dashboard.shortcut_reports') }}</span>
                    </a>

                    <a href="{{ route('admin.settings.index') }}" class="p-3 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200/80 hover:border-slate-300 transition-colors flex flex-col items-center text-center gap-1.5 group">
                        <i class="fa-solid fa-gear text-slate-600 text-lg group-hover:scale-110 transition-transform"></i>
                        <span class="text-xs font-bold text-slate-700 group-hover:text-slate-900">{{ __('dashboard.shortcut_settings') }}</span>
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/vendor/chartjs/chart.umd.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Chart === 'undefined') {
            console.warn('Chart.js library is not loaded');
            return;
        }

        const isRtl = {{ app()->getLocale() === 'ar' ? 'true' : 'false' }};
        Chart.defaults.font.family = 'Cairo, system-ui, sans-serif';
        Chart.defaults.color = '#64748b';

        // 1. 7-Day Trend Line Chart
        const trendCanvas = document.getElementById('trendChart');
        if (trendCanvas) {
            const trendData = {!! json_encode($last7Days) !!};
            const labels = trendData.map(item => item.label);
            const counts = trendData.map(item => item.count);

            new Chart(trendCanvas, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '{{ __("dashboard.chart_quotes_dataset") }}',
                        data: counts,
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.08)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#2563eb',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    rtl: isRtl,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            rtl: isRtl,
                            backgroundColor: '#0f172a',
                            titleFont: {
                                size: 12,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 12
                            },
                            padding: 10,
                            cornerRadius: 8
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

        // 2. Status Doughnut Chart
        const statusCanvas = document.getElementById('statusChart');
        if (statusCanvas) {
            const statusCounts = [
                {{ (int) $statusBreakdown['pending'] }},
                {{ (int) $statusBreakdown['contacted'] }},
                {{ (int) $statusBreakdown['in_progress'] }},
                {{ (int) $statusBreakdown['completed'] }},
                {{ (int) $statusBreakdown['cancelled'] }}
            ];

            const totalStatus = statusCounts.reduce((a, b) => a + b, 0);

            new Chart(statusCanvas, {
                type: 'doughnut',
                data: {
                    labels: [
                        '{{ __("dashboard.statuses.pending") }}',
                        '{{ __("dashboard.statuses.contacted") }}',
                        '{{ __("dashboard.statuses.in_progress") }}',
                        '{{ __("dashboard.statuses.completed") }}',
                        '{{ __("dashboard.statuses.cancelled") }}'
                    ],
                    datasets: [{
                        data: totalStatus > 0 ? statusCounts : [1],
                        backgroundColor: totalStatus > 0 ? [
                            '#f59e0b', // pending - amber
                            '#3b82f6', // contacted - blue
                            '#a855f7', // in_progress - purple
                            '#10b981', // completed - emerald
                            '#94a3b8' // cancelled - slate
                        ] : ['#e2e8f0'],
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: totalStatus > 0,
                            rtl: isRtl,
                            backgroundColor: '#0f172a',
                            titleFont: {
                                size: 12,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 12
                            },
                            padding: 10,
                            cornerRadius: 8
                        }
                    }
                }
            });
        }
    });
</script>
@endpush