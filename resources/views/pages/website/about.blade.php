@extends('layouts.website.app')

@section('title', 'من نحن — عن مطبعة نبراس العرب')

@section('content')

<!-- Hero Banner -->
<section class="relative bg-slate-950 text-white py-14 sm:py-20 overflow-hidden">
    <div class="absolute inset-0 bg-grid-pattern opacity-40 pointer-events-none"></div>
    <div class="absolute -top-24 -right-24 w-80 h-80 rounded-full bg-blue-600/20 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-80 h-80 rounded-full bg-red-600/15 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <nav class="flex items-center gap-2 text-xs font-bold text-slate-400 mb-4">
            <a href="{{ route('website.home') }}" class="hover:text-white transition-colors">الرئيسية</a>
            <i class="fa-solid fa-chevron-left text-[10px] text-slate-600"></i>
            <span class="text-blue-400">من نحن</span>
        </nav>

        <div class="max-w-3xl space-y-4">
            <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/10 border border-white/15 text-amber-300 text-xs font-bold">
                <i class="fa-solid fa-building-shield"></i>
                <span>تأسست عام {{ $stats['established_year'] }}م • الرياض، المملكة العربية السعودية</span>
            </span>
            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white leading-tight">
                {{ setting('site_name', 'مطبعة نبراس العرب للطباعة والتغليف') }}
            </h1>
            <p class="text-sm sm:text-lg text-slate-300 leading-relaxed">
                {{ setting('site_description', 'نبراس العرب هي وجهتكم الموثوقة لخدمات الطباعة الرقمية والأوفست، تصنيع علب التغليف الفاخرة، والهدايا الترويجية بالمملكة العربية السعودية وفق أرقى المعايير العالمية.') }}
            </p>
        </div>
    </div>
</section>

<!-- Story, Vision & Mission Section -->
<section class="py-16 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <!-- Story Text (7 Cols) -->
            <div class="lg:col-span-7 space-y-5">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-extrabold">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    <span>قصتنا وهويتنا</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 leading-tight">
                    أكثر من {{ $stats['years_experience'] }} أعوام من الإبداع في صناعة التغليف والمطبوعات الفاخرة
                </h2>
                <p class="text-xs sm:text-base text-slate-600 leading-relaxed">
                    انطلقت <strong>{{ setting('site_name', 'مطبعة نبراس العرب') }}</strong> من قلب العاصمة الرياض برؤية طموحة تهدف إلى الارتقاء بصناعة الطباعة والتغليف في السوق السعودي، وتوفير حلول متكاملة تضاهي أرقى المعايير العالمية وتواكب تطلعات رؤية المملكة 2030 في دعم الصناعة الوطنية والتميز المؤسسي.
                </p>
                <p class="text-xs sm:text-base text-slate-600 leading-relaxed">
                    نحن لا نطبع الأوراق والعلب فحسب، بل نبتكر تجربة حسية وبصرية متكاملة تزيد من جاذبية منتجات عملائنا على أرفف العرض وفي المتاجر الإلكترونية، بدءاً من هندسة القالب واختيار الخامات وحتى أدق تفاصيل التشطيب النهائي.
                </p>

                <!-- Official Credentials Row -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-3">
                    <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-2xs">
                        <span class="text-xs text-slate-400 font-bold block">سنة التأسيس</span>
                        <span class="text-xl font-black text-blue-700 font-mono mt-0.5 block">{{ $stats['established_year'] }}م</span>
                    </div>
                    @if(setting('commercial_registration'))
                    <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-2xs">
                        <span class="text-xs text-slate-400 font-bold block">السجل التجاري</span>
                        <span class="text-base font-black text-slate-900 font-mono mt-1 block">{{ setting('commercial_registration') }}</span>
                    </div>
                    @endif
                    @if(setting('tax_number'))
                    <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-2xs">
                        <span class="text-xs text-slate-400 font-bold block">الرقم الضريبي</span>
                        <span class="text-sm font-black text-slate-900 font-mono mt-1 block">{{ setting('tax_number') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Visual Grid (5 Cols) -->
            <div class="lg:col-span-5 grid grid-cols-2 gap-4">
                <div class="space-y-4">
                    <div class="rounded-3xl overflow-hidden h-52 shadow-lg border border-slate-200">
                        <img src="https://images.unsplash.com/photo-1549465220-1a8b9238cd48?auto=format&fit=crop&w=600&q=80" alt="علب فاخرة" class="w-full h-full object-cover">
                    </div>
                    <div class="rounded-3xl bg-gradient-to-br from-blue-700 to-blue-900 text-white p-5 shadow-lg">
                        <p class="text-3xl font-black font-mono">+5,400</p>
                        <p class="text-xs text-blue-200 font-bold mt-1">مشروع ناجح تم تسليمه بأعلى معايير الدقة</p>
                    </div>
                </div>
                <div class="space-y-4 pt-6">
                    <div class="rounded-3xl bg-slate-900 text-white p-5 shadow-lg">
                        <p class="text-3xl font-black text-amber-400 font-mono">100%</p>
                        <p class="text-xs text-slate-300 font-bold mt-1">التزام بمواصفات الجودة ومواعيد التسليم</p>
                    </div>
                    <div class="rounded-3xl overflow-hidden h-52 shadow-lg border border-slate-200">
                        <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=600&q=80" alt="مطبوعات الشركات" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>

        <!-- Vision, Mission & Values Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-7 rounded-3xl border border-slate-200/80 shadow-sm space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center">
                    <i class="fa-solid fa-eye text-xl"></i>
                </div>
                <h3 class="text-lg font-black text-slate-900">رؤيتنا</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    أن نكون الوجهة الصناعية والإبداعية الأولى في المملكة العربية السعودية والخليج العربي لحلول التغليف الفاخر والمطبوعات التجارية المبتكرة.
                </p>
            </div>

            <div class="bg-white p-7 rounded-3xl border border-slate-200/80 shadow-sm space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center">
                    <i class="fa-solid fa-bullseye text-xl"></i>
                </div>
                <h3 class="text-lg font-black text-slate-900">رسالتنا</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    تمكين العلامات التجارية والشركات من إبراز قيمة منتجاتها عبر تقديم حلول طباعة وتغليف عالية الجودة بأسعار تنافسية وخدمة عملاء استثنائية.
                </p>
            </div>

            <div class="bg-white p-7 rounded-3xl border border-slate-200/80 shadow-sm space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i class="fa-solid fa-gem text-xl"></i>
                </div>
                <h3 class="text-lg font-black text-slate-900">قيمنا الجوهرية</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    الإتقان الهندسي، الأمانة والشفافية في التسعير، الابتكار المستمر في الخامات والتشطيبات، والالتزام الصارم بمواعيد التوريد.
                </p>
            </div>
        </div>

    </div>
</section>

@endsection

