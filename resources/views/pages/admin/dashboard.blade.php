@extends('layouts.dashboard.app')

@section('title', 'لوحة التحكم الرئيسية')

@section('content')
<div class="space-y-6">

    <!-- Welcome Hero Card -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-blue-950 to-blue-900 text-white p-6 sm:p-8 shadow-xl">
        <div class="relative z-10 max-w-2xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-600/30 text-red-300 border border-red-500/30 mb-3">
                <span class="w-1.5 h-1.5 rounded-full bg-red-400 animate-pulse"></span>
                مطبعة نبراس العرب
            </span>
            <h1 class="text-2xl sm:text-3xl font-black tracking-tight">أهلاً بك في لوحة تحكم نبراس العرب</h1>
            <p class="text-sm text-slate-300 mt-2 leading-relaxed">
                مرحباً بك مجدداً. يمكنك من هنا إدارة المنتجات، التصنيفات، عروض الأسعار، واستعراض طلبات العملاء بكل سهولة وسرعة.
            </p>

            <div class="mt-6 flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.categories.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-sm bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white shadow-lg shadow-red-950/40 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    <span>إدارة التصنيفات</span>
                </a>
                <a href="{{ route('admin.categories.create') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-sm bg-white/10 hover:bg-white/20 text-white border border-white/20 backdrop-blur-md transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>إضافة تصنيف جديد</span>
                </a>
            </div>
        </div>

        <div class="absolute -left-10 -bottom-10 w-72 h-72 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Quick Access Modules Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        
        <!-- Categories Card -->
        <a href="{{ route('admin.categories.index') }}" 
           class="group p-6 bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-blue-500/50 transition-all flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 group-hover:bg-blue-600 group-hover:text-white transition-all flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                </div>
                <span class="text-xs font-bold text-blue-600 group-hover:translate-x-1 transition-transform">دخول ←</span>
            </div>
            <div class="mt-4">
                <h3 class="text-base font-bold text-slate-900 group-hover:text-blue-700 transition-colors">إدارة التصنيفات</h3>
                <p class="text-xs text-slate-500 mt-1">تعديل وإضافة أقسام المنتجات، التحكم بالأيقونات، صور التصنيفات والترتيب.</p>
            </div>
        </a>

        <!-- Products Card -->
        <div class="p-6 bg-white rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between opacity-80">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <span class="text-xs text-slate-400 font-medium">قريباً</span>
            </div>
            <div class="mt-4">
                <h3 class="text-base font-bold text-slate-800">إدارة المنتجات والمواصفات</h3>
                <p class="text-xs text-slate-500 mt-1">إضافة تفاصيل المنتجات، مواصفات الطباعة، الأبعاد والأوزان والأسعار.</p>
            </div>
        </div>

        <!-- Quotes Card -->
        <div class="p-6 bg-white rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between opacity-80">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <span class="text-xs text-slate-400 font-medium">قريباً</span>
            </div>
            <div class="mt-4">
                <h3 class="text-base font-bold text-slate-800">طلبات عروض الأسعار</h3>
                <p class="text-xs text-slate-500 mt-1">متابعة طلبات التسعير الواردة من العملاء والرد عليها مباشرة.</p>
            </div>
        </div>

    </div>

</div>
@endsection