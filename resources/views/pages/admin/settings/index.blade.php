@extends('layouts.dashboard.app')

@section('title', 'إعدادات النظام والهوية')

@section('content')
<div class="space-y-6 pb-16">

    <!-- Top Header & Breadcrumbs -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition-colors">لوحة التحكم</a>
                <i class="fa-solid fa-chevron-left text-[10px] text-slate-400"></i>
                <span class="text-slate-800">إعدادات النظام والهوية</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-200/80 text-blue-600 flex items-center justify-center shadow-sm">
                    <i class="fa-solid fa-sliders text-base"></i>
                </span>
                <span>إعدادات النظام والهوية المؤسسية</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                إدارة شاملة لبيانات وهوية مطبعة نبراس العرب، وسائل التواصل، البيانات المالية، والأكواد المخصصة
            </p>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            <button type="button" onclick="confirmResetDefaults()"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200/80 hover:text-slate-900 transition-all">
                <i class="fa-solid fa-rotate-left text-xs text-slate-500"></i>
                <span>استعادة الافتراضية</span>
            </button>
        </div>
    </div>

    <!-- Quick Status Alert Summary -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
        <!-- Site Name Status -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-building text-base"></i>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-[11px] font-medium text-slate-500 truncate">اسم المنشأة</p>
                <p class="text-xs sm:text-sm font-bold text-slate-900 truncate">{{ $settings['site_name'] ?? 'نبراس العرب' }}</p>
            </div>
        </div>

        <!-- VAT Status -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-receipt text-base"></i>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-[11px] font-medium text-slate-500 truncate">الرقم الضريبي</p>
                <p class="text-xs sm:text-sm font-bold text-slate-900 truncate font-mono">
                    {{ !empty($settings['tax_number']) ? $settings['tax_number'] : 'غير محدد' }}
                </p>
            </div>
        </div>

        <!-- Banner Notice Status -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl {{ ($settings['header_notice_active'] ?? '0') === '1' ? 'bg-amber-50 text-amber-600' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-bullhorn text-base"></i>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-[11px] font-medium text-slate-500 truncate">شريط التنبيهات</p>
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full {{ ($settings['header_notice_active'] ?? '0') === '1' ? 'bg-amber-500 animate-pulse' : 'bg-slate-300' }}"></span>
                    <span class="text-xs sm:text-sm font-bold text-slate-900">
                        {{ ($settings['header_notice_active'] ?? '0') === '1' ? 'مفعّل حالياً' : 'متوقف' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Maintenance Status -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl {{ ($settings['maintenance_mode'] ?? '0') === '1' ? 'bg-red-50 text-red-600' : 'bg-emerald-50 text-emerald-600' }} flex items-center justify-center flex-shrink-0">
                <i class="fa-solid {{ ($settings['maintenance_mode'] ?? '0') === '1' ? 'fa-triangle-exclamation' : 'fa-circle-check' }} text-base"></i>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-[11px] font-medium text-slate-500 truncate">حالة الموقع</p>
                <span class="text-xs sm:text-sm font-bold {{ ($settings['maintenance_mode'] ?? '0') === '1' ? 'text-red-600' : 'text-emerald-600' }}">
                    {{ ($settings['maintenance_mode'] ?? '0') === '1' ? 'وضع الصيانة' : 'يعمل بصورة طبيعية' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Main Settings Form -->
    <form id="settings-main-form"
        action="{{ route('admin.settings.update') }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-6">
        @csrf
        <input type="hidden" name="_tab" id="active-tab-input" value="{{ $activeTab }}">

        <!-- Navigation Tabs Bar -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-1.5 shadow-sm overflow-x-auto scrollbar-thin">
            <div class="flex items-center gap-1.5 min-w-max">
                @foreach ($tabs as $key => $tab)
                <button type="button"
                    onclick="switchSettingsTab('{{ $key }}')"
                    id="tab-btn-{{ $key }}"
                    class="tab-btn flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition-all duration-200 {{ $activeTab === $key ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30 active-tab' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                    <i class="fa-solid {{ $tab['icon'] }} text-xs {{ $activeTab === $key ? 'text-white' : 'text-slate-400' }}"></i>
                    <span>{{ $tab['name'] }}</span>
                </button>
                @endforeach
            </div>
        </div>

        <!-- Tabs Content Container -->
        <div class="space-y-6">

            <!-- ==========================================
                 TAB 1: GENERAL & BRANDING
            =========================================== -->
            <div id="tab-pane-general" class="tab-pane {{ $activeTab === 'general' ? 'block' : 'hidden' }} space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                    <!-- Left: Form Fields (8 Cols) -->
                    <div class="lg:col-span-8 space-y-6">
                        <!-- Basic Info Card -->
                        <div class="bg-white p-5 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-5">
                            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                                    <span>بيانات الهوية والمنشأة</span>
                                </h3>
                                <span class="text-xs text-slate-400 font-medium">البيانات الأساسية التي تظهر في الواجهة والفوتر</span>
                            </div>

                            <!-- Site Name -->
                            <div>
                                <label for="site_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    اسم المنشأة / المطبعة <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                        <i class="fa-solid fa-print"></i>
                                    </div>
                                    <input type="text"
                                        id="site_name"
                                        name="site_name"
                                        value="{{ old('site_name', $settings['site_name'] ?? '') }}"
                                        placeholder="مثال: مطبعة نبراس العرب للطباعة والتغليف"
                                        required
                                        class="w-full pr-10 pl-4 py-3 rounded-xl border {{ $errors->has('site_name') ? 'border-red-400 bg-red-50/30' : 'border-slate-200 bg-slate-50/50' }} text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                                </div>
                                @error('site_name')
                                <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tagline & Established Year -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="sm:col-span-2">
                                    <label for="site_tagline" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                        الشعار اللفظي (Slogan / Tagline)
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                            <i class="fa-solid fa-quote-right"></i>
                                        </div>
                                        <input type="text"
                                            id="site_tagline"
                                            name="site_tagline"
                                            value="{{ old('site_tagline', $settings['site_tagline'] ?? '') }}"
                                            placeholder="مثال: ريادة في عالم الطباعة الفاخرة والتغليف المبتكر"
                                            class="w-full pr-10 pl-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                                    </div>
                                </div>

                                <div>
                                    <label for="established_year" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                        سنة التأسيس
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                            <i class="fa-solid fa-calendar-days"></i>
                                        </div>
                                        <input type="text"
                                            id="established_year"
                                            name="established_year"
                                            value="{{ old('established_year', $settings['established_year'] ?? '2015') }}"
                                            placeholder="2015"
                                            class="w-full pr-10 pl-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm font-mono focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                                    </div>
                                </div>
                            </div>

                            <!-- Site Description -->
                            <div>
                                <label for="site_description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    نبذة تعريفية عن المطبعة (About Summary)
                                </label>
                                <textarea
                                    id="site_description"
                                    name="site_description"
                                    rows="4"
                                    placeholder="اكتب نبذة مختصرة وجذابة عن المطبعة، تخصصاتها، وما تقدمه لعملائها بالمملكة..."
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all leading-relaxed">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
                                <p class="text-[11px] text-slate-400 mt-1">يتم استخدام هذه النبذة في فوتر الموقع وصفحة "من نحن" وكذلك في الميتا تاغ ومحركات البحث.</p>
                            </div>
                        </div>

                        <!-- Brand Logos Card -->
                        <div class="bg-white p-5 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-6">
                            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span>
                                    <span>الشعارات والوسائط البصرية</span>
                                </h3>
                                <span class="text-xs text-slate-400 font-medium">PNG, SVG, WEBP أو JPG (الحد الأقصى 4MB)</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Main Logo (Light Backgrounds) -->
                                <div class="space-y-3 p-4 rounded-xl border border-slate-200 bg-slate-50/40">
                                    <div class="flex items-center justify-between">
                                        <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                                            الشعار الأساسي (الخلفيات الفاتحة)
                                        </label>
                                        @if(!empty($settings['site_logo']))
                                        <label class="inline-flex items-center gap-1.5 text-[11px] text-red-600 hover:text-red-800 cursor-pointer">
                                            <input type="checkbox" name="remove_site_logo" value="1" class="rounded text-red-600 focus:ring-red-500">
                                            <span>حذف الشعار</span>
                                        </label>
                                        @endif
                                    </div>

                                    <!-- Preview Box -->
                                    <div class="w-full h-28 rounded-xl bg-white border border-dashed border-slate-300 flex items-center justify-center p-3 relative overflow-hidden group">
                                        @if(!empty($settings['site_logo']) && file_exists(public_path($settings['site_logo'])))
                                        <img id="logo-preview-img" src="{{ asset($settings['site_logo']) }}" alt="الشعار الرئيسي" class="max-h-full max-w-full object-contain">
                                        @else
                                        <img id="logo-preview-img" src="{{ asset('logo.png') }}" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'120\' height=\'40\' viewBox=\'0 0 120 40\'><rect width=\'100%\' height=\'100%\' fill=\'%23f1f5f9\'/><text x=\'50%\' y=\'50%\' dominant-baseline=\'middle\' text-anchor=\'middle\' fill=\'%2364748b\' font-size=\'14\' font-weight=\'bold\'>شعار المطبعة</text></svg>'" alt="الشعار" class="max-h-full max-w-full object-contain">
                                        @endif
                                    </div>

                                    <input type="file"
                                        id="site_logo"
                                        name="site_logo"
                                        accept="image/png,image/jpeg,image/svg+xml,image/webp"
                                        onchange="previewImage(this, 'logo-preview-img')"
                                        class="block w-full text-xs text-slate-500 file:mr-0 file:ml-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                </div>

                                <!-- Dark Mode / Alternate Logo -->
                                <div class="space-y-3 p-4 rounded-xl border border-slate-800 bg-slate-900 text-white">
                                    <div class="flex items-center justify-between">
                                        <label class="block text-xs font-bold text-slate-200 uppercase tracking-wider">
                                            شعار الخلفيات الداكنة (Dark Logo)
                                        </label>
                                        @if(!empty($settings['site_logo_dark']))
                                        <label class="inline-flex items-center gap-1.5 text-[11px] text-red-400 hover:text-red-300 cursor-pointer">
                                            <input type="checkbox" name="remove_site_logo_dark" value="1" class="rounded text-red-600 focus:ring-red-500">
                                            <span>حذف</span>
                                        </label>
                                        @endif
                                    </div>

                                    <!-- Preview Box -->
                                    <div class="w-full h-28 rounded-xl bg-slate-950/80 border border-dashed border-slate-700 flex items-center justify-center p-3 relative overflow-hidden group">
                                        @if(!empty($settings['site_logo_dark']) && file_exists(public_path($settings['site_logo_dark'])))
                                        <img id="dark-logo-preview-img" src="{{ asset($settings['site_logo_dark']) }}" alt="شعار الخلفية الداكنة" class="max-h-full max-w-full object-contain">
                                        @else
                                        <div id="dark-logo-preview-placeholder" class="text-center text-slate-500 text-xs">
                                            <i class="fa-solid fa-moon text-lg mb-1 block"></i>
                                            <span>يظهر في الهيدر الداكن</span>
                                        </div>
                                        <img id="dark-logo-preview-img" src="" alt="" class="max-h-full max-w-full object-contain hidden">
                                        @endif
                                    </div>

                                    <input type="file"
                                        id="site_logo_dark"
                                        name="site_logo_dark"
                                        accept="image/png,image/jpeg,image/svg+xml,image/webp"
                                        onchange="previewImage(this, 'dark-logo-preview-img', 'dark-logo-preview-placeholder')"
                                        class="block w-full text-xs text-slate-400 file:mr-0 file:ml-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-800 file:text-blue-300 hover:file:bg-slate-700 cursor-pointer">
                                </div>
                            </div>

                            <!-- Favicon Upload -->
                            <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/40 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 shadow-sm flex items-center justify-center p-1 overflow-hidden">
                                        @if(!empty($settings['site_favicon']) && file_exists(public_path($settings['site_favicon'])))
                                        <img id="favicon-preview-img" src="{{ asset($settings['site_favicon']) }}" alt="Favicon" class="w-7 h-7 object-contain">
                                        @else
                                        <img id="favicon-preview-img" src="{{ asset('favicon.ico') }}" onerror="this.src='{{ asset('logo.png') }}'" alt="Favicon" class="w-7 h-7 object-contain">
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-800">أيقونة الموقع (Favicon)</p>
                                        <p class="text-[11px] text-slate-500">تظهر في علامة تبويب المتصفح والمفضلة (32x32 أو 64x64 بكسل بصيغة PNG أو ICO)</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    @if(!empty($settings['site_favicon']))
                                    <label class="inline-flex items-center gap-1.5 text-[11px] text-red-600 hover:text-red-800 cursor-pointer">
                                        <input type="checkbox" name="remove_site_favicon" value="1" class="rounded text-red-600 focus:ring-red-500">
                                        <span>حذف</span>
                                    </label>
                                    @endif
                                    <input type="file"
                                        id="site_favicon"
                                        name="site_favicon"
                                        accept="image/x-icon,image/png,image/svg+xml"
                                        onchange="previewImage(this, 'favicon-preview-img')"
                                        class="text-xs text-slate-500 file:mr-0 file:ml-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Brand Live Preview Widget (4 Cols) -->
                    <div class="lg:col-span-4 space-y-6">
                        <!-- Preview Card -->
                        <div class="bg-gradient-to-br from-slate-900 via-slate-900 to-blue-950 text-white p-6 rounded-2xl shadow-xl border border-slate-800 space-y-4">
                            <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                                <span class="text-xs font-bold text-blue-400 uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="fa-solid fa-eye"></i>
                                    <span>معاينة بطاقة الهوية</span>
                                </span>
                                <span class="text-[10px] bg-blue-900/60 text-blue-200 px-2 py-0.5 rounded-full border border-blue-700/40">مباشر</span>
                            </div>

                            <div class="flex items-center gap-3.5">
                                <div class="w-14 h-14 rounded-2xl bg-white p-1.5 shadow-lg flex items-center justify-center overflow-hidden">
                                    <img src="{{ !empty($settings['site_logo']) ? asset($settings['site_logo']) : asset('logo.png') }}" onerror="this.src='{{ asset('logo.png') }}'" alt="Logo" class="max-h-full max-w-full object-contain">
                                </div>
                                <div>
                                    <h4 class="font-bold text-white text-base leading-tight">{{ $settings['site_name'] ?? 'نبراس العرب' }}</h4>
                                    <p class="text-xs text-blue-300/90 mt-0.5 font-medium">{{ $settings['site_tagline'] ?? 'ريادة في عالم الطباعة والتغليف' }}</p>
                                </div>
                            </div>

                            <p class="text-xs text-slate-300 leading-relaxed pt-2 border-t border-slate-800/80 line-clamp-3">
                                {{ $settings['site_description'] ?? 'وجهتكم الأولى لخدمات الطباعة الرقمية وتصنيع العلب الفاخرة.' }}
                            </p>

                            <div class="pt-3 border-t border-slate-800/80 flex items-center justify-between text-[11px] text-slate-400">
                                <span>تأسست عام {{ $settings['established_year'] ?? '2015' }}م</span>
                                <span class="flex items-center gap-1 text-emerald-400 font-semibold">
                                    <i class="fa-solid fa-circle-check text-xs"></i>
                                    <span>سجل تجاري موثق</span>
                                </span>
                            </div>
                        </div>

                        <!-- Quick Guide -->
                        <div class="bg-blue-50/60 border border-blue-200/80 p-5 rounded-2xl space-y-2 text-xs text-blue-900">
                            <h5 class="font-bold text-blue-950 flex items-center gap-2">
                                <i class="fa-solid fa-circle-info text-blue-600"></i>
                                <span>إرشادات الهوية البصرية:</span>
                            </h5>
                            <ul class="space-y-1.5 pr-4 list-disc text-blue-800">
                                <li>يُفضل استخدام شعار بصيغة <b>PNG بخلفية شفافة</b> أو صيغة <b>SVG</b>.</li>
                                <li>الحجم الموصى به للشعار: عرض 300-600 بكسل بارتفاع 80-160 بكسل.</li>
                                <li>أيقونة الموقع (Favicon) تُعطي انطباعاً رسمياً واحترافياً عند إضافتها.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==========================================
                 TAB 2: CONTACT & LOCATION
            =========================================== -->
            <div id="tab-pane-contact" class="tab-pane {{ $activeTab === 'contact' ? 'block' : 'hidden' }} space-y-6">
                <div class="bg-white p-5 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-6">
                    <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                            <span>أرقام التواصل والواتساب المباشر</span>
                        </h3>
                        <span class="text-xs text-slate-400 font-medium">تظهر للعملاء في أزرار الاتصال السريع والفوتر</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                الهاتف الثابت (Landline)
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                                <input type="text"
                                    id="phone"
                                    name="phone"
                                    value="{{ old('phone', $settings['phone'] ?? '') }}"
                                    placeholder="+966 11 456 7890"
                                    dir="ltr"
                                    class="w-full pr-10 pl-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm font-mono text-left focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                            </div>
                        </div>

                        <!-- Mobile -->
                        <div>
                            <label for="mobile" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                رقم الجوال المباشر (Mobile)
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-mobile-screen-button"></i>
                                </div>
                                <input type="text"
                                    id="mobile"
                                    name="mobile"
                                    value="{{ old('mobile', $settings['mobile'] ?? '') }}"
                                    placeholder="+966 50 123 4567"
                                    dir="ltr"
                                    class="w-full pr-10 pl-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm font-mono text-left focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                            </div>
                        </div>

                        <!-- WhatsApp Number -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="whatsapp" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                    رقم الواتساب الرسمي (WhatsApp)
                                </label>
                                @if(!empty($settings['whatsapp']))
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['whatsapp']) }}" target="_blank" class="text-[11px] text-emerald-600 hover:underline font-semibold flex items-center gap-1">
                                    <span>تجربة المحادثة</span>
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                                @endif
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-emerald-500">
                                    <i class="fa-brands fa-whatsapp text-lg"></i>
                                </div>
                                <input type="text"
                                    id="whatsapp"
                                    name="whatsapp"
                                    value="{{ old('whatsapp', $settings['whatsapp'] ?? '') }}"
                                    placeholder="966501234567"
                                    dir="ltr"
                                    class="w-full pr-10 pl-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm font-mono text-left focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition-all">
                            </div>
                            <p class="text-[11px] text-slate-400 mt-1">يُكتب بصيغة دولية بدون مسافات أو إشارة + (مثال: 966501234567)</p>
                        </div>
                    </div>

                    <!-- WhatsApp Auto Greeting Message -->
                    <div>
                        <label for="whatsapp_default_message" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            رسالة الواتساب الترحيبية التلقائية
                        </label>
                        <textarea
                            id="whatsapp_default_message"
                            name="whatsapp_default_message"
                            rows="2"
                            placeholder="مرحباً مطبعة نبراس العرب، أود الاستفسار عن خدمات الطباعة والتغليف..."
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition-all">{{ old('whatsapp_default_message', $settings['whatsapp_default_message'] ?? '') }}</textarea>
                        <p class="text-[11px] text-slate-400 mt-1">هذه الرسالة تظهر مكتوبة وجاهزة للعميل عند النقر على أيقونة الواتساب في الموقع لتسهيل بدء المحادثة.</p>
                    </div>
                </div>

                <!-- Emails Card -->
                <div class="bg-white p-5 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-6">
                    <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                            <span>عناوين البريد الإلكتروني</span>
                        </h3>
                        <span class="text-xs text-slate-400 font-medium">لاستقبال الاستفسارات والطلبات الرسمية</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <!-- Contact Email -->
                        <div>
                            <label for="contact_email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                البريد العام (General Inquiries)
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <input type="email"
                                    id="contact_email"
                                    name="contact_email"
                                    value="{{ old('contact_email', $settings['contact_email'] ?? '') }}"
                                    placeholder="info@nibras-alarab.com"
                                    dir="ltr"
                                    class="w-full pr-10 pl-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm text-left focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                            </div>
                        </div>

                        <!-- Sales Email -->
                        <div>
                            <label for="sales_email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                بريد المبيعات والتسعير (Sales)
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </div>
                                <input type="email"
                                    id="sales_email"
                                    name="sales_email"
                                    value="{{ old('sales_email', $settings['sales_email'] ?? '') }}"
                                    placeholder="sales@nibras-alarab.com"
                                    dir="ltr"
                                    class="w-full pr-10 pl-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm text-left focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                            </div>
                        </div>

                        <!-- Support Email -->
                        <div>
                            <label for="support_email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                بريد خدمة العملاء (Support)
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-headset"></i>
                                </div>
                                <input type="email"
                                    id="support_email"
                                    name="support_email"
                                    value="{{ old('support_email', $settings['support_email'] ?? '') }}"
                                    placeholder="support@nibras-alarab.com"
                                    dir="ltr"
                                    class="w-full pr-10 pl-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm text-left focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Location & Working Hours Card -->
                <div class="bg-white p-5 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-6">
                    <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-600"></span>
                            <span>العنوان الجغرافي ومواعيد العمل</span>
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Physical Address -->
                        <div>
                            <label for="address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                العنوان الفعلي للمطبعة / المعرض
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <input type="text"
                                    id="address"
                                    name="address"
                                    value="{{ old('address', $settings['address'] ?? '') }}"
                                    placeholder="المملكة العربية السعودية، الرياض، حي الملز..."
                                    class="w-full pr-10 pl-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                            </div>
                        </div>

                        <!-- Map URL -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="map_url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                    رابط خرائط جوجل (Google Maps URL)
                                </label>
                                @if(!empty($settings['map_url']))
                                <a href="{{ $settings['map_url'] }}" target="_blank" class="text-[11px] text-blue-600 hover:underline flex items-center gap-1 font-semibold">
                                    <span>فتح الخريطة</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                </a>
                                @endif
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-map-location-dot"></i>
                                </div>
                                <input type="url"
                                    id="map_url"
                                    name="map_url"
                                    value="{{ old('map_url', $settings['map_url'] ?? '') }}"
                                    placeholder="https://maps.google.com/?q=24.6748,46.7303"
                                    dir="ltr"
                                    class="w-full pr-10 pl-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm text-left focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                            </div>
                        </div>
                    </div>

                    <!-- Working Hours -->
                    <div>
                        <label for="working_hours" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            ساعات وأيام العمل الرسمية
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <input type="text"
                                id="working_hours"
                                name="working_hours"
                                value="{{ old('working_hours', $settings['working_hours'] ?? '') }}"
                                placeholder="مثال: السبت - الخميس: 8:30 صباحاً إلى 10:00 مساءً | الجمعة: مغلق"
                                class="w-full pr-10 pl-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==========================================
                 TAB 3: SOCIAL MEDIA
            =========================================== -->
            <div id="tab-pane-social" class="tab-pane {{ $activeTab === 'social' ? 'block' : 'hidden' }} space-y-6">
                <div class="bg-white p-5 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-6">
                    <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-pink-600"></span>
                            <span>الحسابات الرسمية على منصات التواصل الاجتماعي</span>
                        </h3>
                        <span class="text-xs text-slate-400 font-medium">ضع روابط الحسابات المباشرة (تظهر أيقوناتها تلقائياً في الفوتر والهيدر)</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <!-- Instagram -->
                        <div class="p-4 rounded-xl border border-slate-200/90 bg-gradient-to-l from-pink-50/30 to-slate-50/30 space-y-2">
                            <div class="flex items-center justify-between">
                                <label for="instagram" class="flex items-center gap-2 text-xs font-bold text-slate-800">
                                    <span class="w-7 h-7 rounded-lg bg-gradient-to-tr from-amber-500 via-rose-500 to-purple-600 text-white flex items-center justify-center text-sm shadow-sm">
                                        <i class="fa-brands fa-instagram"></i>
                                    </span>
                                    <span>إنستغرام (Instagram)</span>
                                </label>
                                @if(!empty($settings['instagram']))
                                <a href="{{ $settings['instagram'] }}" target="_blank" class="text-[11px] text-pink-600 hover:underline flex items-center gap-1 font-semibold">
                                    <span>معاينة الرابط</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                </a>
                                @endif
                            </div>
                            <input type="url"
                                id="instagram"
                                name="instagram"
                                value="{{ old('instagram', $settings['instagram'] ?? '') }}"
                                placeholder="https://instagram.com/nibrasalarab"
                                dir="ltr"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-sm text-left focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all">
                        </div>

                        <!-- Twitter / X -->
                        <div class="p-4 rounded-xl border border-slate-200/90 bg-gradient-to-l from-slate-100/50 to-slate-50/30 space-y-2">
                            <div class="flex items-center justify-between">
                                <label for="twitter" class="flex items-center gap-2 text-xs font-bold text-slate-800">
                                    <span class="w-7 h-7 rounded-lg bg-black text-white flex items-center justify-center text-sm shadow-sm">
                                        <i class="fa-brands fa-x-twitter"></i>
                                    </span>
                                    <span>إكس / تويتر (X - Twitter)</span>
                                </label>
                                @if(!empty($settings['twitter']))
                                <a href="{{ $settings['twitter'] }}" target="_blank" class="text-[11px] text-slate-800 hover:underline flex items-center gap-1 font-semibold">
                                    <span>معاينة الرابط</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                </a>
                                @endif
                            </div>
                            <input type="url"
                                id="twitter"
                                name="twitter"
                                value="{{ old('twitter', $settings['twitter'] ?? '') }}"
                                placeholder="https://x.com/nibrasalarab"
                                dir="ltr"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-sm text-left focus:outline-none focus:ring-2 focus:ring-slate-700 focus:border-transparent transition-all">
                        </div>

                        <!-- TikTok -->
                        <div class="p-4 rounded-xl border border-slate-200/90 bg-gradient-to-l from-slate-100/50 to-slate-50/30 space-y-2">
                            <div class="flex items-center justify-between">
                                <label for="tiktok" class="flex items-center gap-2 text-xs font-bold text-slate-800">
                                    <span class="w-7 h-7 rounded-lg bg-slate-900 text-cyan-400 flex items-center justify-center text-sm shadow-sm">
                                        <i class="fa-brands fa-tiktok"></i>
                                    </span>
                                    <span>تيك توك (TikTok)</span>
                                </label>
                                @if(!empty($settings['tiktok']))
                                <a href="{{ $settings['tiktok'] }}" target="_blank" class="text-[11px] text-cyan-700 hover:underline flex items-center gap-1 font-semibold">
                                    <span>معاينة الرابط</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                </a>
                                @endif
                            </div>
                            <input type="url"
                                id="tiktok"
                                name="tiktok"
                                value="{{ old('tiktok', $settings['tiktok'] ?? '') }}"
                                placeholder="https://tiktok.com/@nibrasalarab"
                                dir="ltr"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-sm text-left focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all">
                        </div>

                        <!-- Snapchat -->
                        <div class="p-4 rounded-xl border border-slate-200/90 bg-gradient-to-l from-amber-50/40 to-slate-50/30 space-y-2">
                            <div class="flex items-center justify-between">
                                <label for="snapchat" class="flex items-center gap-2 text-xs font-bold text-slate-800">
                                    <span class="w-7 h-7 rounded-lg bg-yellow-400 text-slate-900 flex items-center justify-center text-sm shadow-sm">
                                        <i class="fa-brands fa-snapchat"></i>
                                    </span>
                                    <span>سناب شات (Snapchat)</span>
                                </label>
                                @if(!empty($settings['snapchat']))
                                <a href="{{ $settings['snapchat'] }}" target="_blank" class="text-[11px] text-amber-700 hover:underline flex items-center gap-1 font-semibold">
                                    <span>معاينة الرابط</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                </a>
                                @endif
                            </div>
                            <input type="url"
                                id="snapchat"
                                name="snapchat"
                                value="{{ old('snapchat', $settings['snapchat'] ?? '') }}"
                                placeholder="https://snapchat.com/add/nibrasalarab"
                                dir="ltr"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-sm text-left focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all">
                        </div>

                        <!-- LinkedIn -->
                        <div class="p-4 rounded-xl border border-slate-200/90 bg-gradient-to-l from-blue-50/30 to-slate-50/30 space-y-2">
                            <div class="flex items-center justify-between">
                                <label for="linkedin" class="flex items-center gap-2 text-xs font-bold text-slate-800">
                                    <span class="w-7 h-7 rounded-lg bg-blue-700 text-white flex items-center justify-center text-sm shadow-sm">
                                        <i class="fa-brands fa-linkedin-in"></i>
                                    </span>
                                    <span>لينكد إن (LinkedIn)</span>
                                </label>
                                @if(!empty($settings['linkedin']))
                                <a href="{{ $settings['linkedin'] }}" target="_blank" class="text-[11px] text-blue-700 hover:underline flex items-center gap-1 font-semibold">
                                    <span>معاينة الرابط</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                </a>
                                @endif
                            </div>
                            <input type="url"
                                id="linkedin"
                                name="linkedin"
                                value="{{ old('linkedin', $settings['linkedin'] ?? '') }}"
                                placeholder="https://linkedin.com/company/nibrasalarab"
                                dir="ltr"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-sm text-left focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-transparent transition-all">
                        </div>

                        <!-- Facebook -->
                        <div class="p-4 rounded-xl border border-slate-200/90 bg-gradient-to-l from-blue-50/30 to-slate-50/30 space-y-2">
                            <div class="flex items-center justify-between">
                                <label for="facebook" class="flex items-center gap-2 text-xs font-bold text-slate-800">
                                    <span class="w-7 h-7 rounded-lg bg-blue-600 text-white flex items-center justify-center text-sm shadow-sm">
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </span>
                                    <span>فيسبوك (Facebook)</span>
                                </label>
                                @if(!empty($settings['facebook']))
                                <a href="{{ $settings['facebook'] }}" target="_blank" class="text-[11px] text-blue-600 hover:underline flex items-center gap-1 font-semibold">
                                    <span>معاينة الرابط</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                </a>
                                @endif
                            </div>
                            <input type="url"
                                id="facebook"
                                name="facebook"
                                value="{{ old('facebook', $settings['facebook'] ?? '') }}"
                                placeholder="https://facebook.com/nibrasalarab"
                                dir="ltr"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-sm text-left focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                        </div>

                        <!-- YouTube -->
                        <div class="p-4 rounded-xl border border-slate-200/90 bg-gradient-to-l from-red-50/30 to-slate-50/30 space-y-2 md:col-span-2">
                            <div class="flex items-center justify-between">
                                <label for="youtube" class="flex items-center gap-2 text-xs font-bold text-slate-800">
                                    <span class="w-7 h-7 rounded-lg bg-red-600 text-white flex items-center justify-center text-sm shadow-sm">
                                        <i class="fa-brands fa-youtube"></i>
                                    </span>
                                    <span>يوتيوب (YouTube)</span>
                                </label>
                                @if(!empty($settings['youtube']))
                                <a href="{{ $settings['youtube'] }}" target="_blank" class="text-[11px] text-red-600 hover:underline flex items-center gap-1 font-semibold">
                                    <span>معاينة القناة</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                </a>
                                @endif
                            </div>
                            <input type="url"
                                id="youtube"
                                name="youtube"
                                value="{{ old('youtube', $settings['youtube'] ?? '') }}"
                                placeholder="https://youtube.com/@nibrasalarab"
                                dir="ltr"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-sm text-left focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent transition-all">
                        </div>

                    </div>
                </div>
            </div>

            <!-- ==========================================
                 TAB 4: COMMERCIAL & QUOTATIONS
            =========================================== -->
            <div id="tab-pane-commercial" class="tab-pane {{ $activeTab === 'commercial' ? 'block' : 'hidden' }} space-y-6">
                <!-- Legal & Registration Card -->
                <div class="bg-white p-5 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-6">
                    <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                            <span>البيانات التجارية والضريبية الرسمية (المملكة العربية السعودية)</span>
                        </h3>
                        <span class="text-xs text-slate-400 font-medium">تظهر في الفواتير وعروض الأسعار الرسمية والفوتر</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Tax Number (VAT) -->
                        <div>
                            <label for="tax_number" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                الرقم الضريبي (15 رقماً) <span class="text-emerald-600 font-bold">(ZATCA)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-receipt"></i>
                                </div>
                                <input type="text"
                                    id="tax_number"
                                    name="tax_number"
                                    value="{{ old('tax_number', $settings['tax_number'] ?? '') }}"
                                    placeholder="310234567800003"
                                    maxlength="15"
                                    dir="ltr"
                                    class="w-full pr-10 pl-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm font-mono text-left focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition-all">
                            </div>
                            <p class="text-[11px] text-slate-400 mt-1">الرقم الضريبي الموحد لهيئة الزكاة والضريبة والجمارك</p>
                        </div>

                        <!-- Commercial Registration -->
                        <div>
                            <label for="commercial_registration" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                رقم السجل التجاري (Commercial Registration)
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-file-contract"></i>
                                </div>
                                <input type="text"
                                    id="commercial_registration"
                                    name="commercial_registration"
                                    value="{{ old('commercial_registration', $settings['commercial_registration'] ?? '') }}"
                                    placeholder="1010789456"
                                    dir="ltr"
                                    class="w-full pr-10 pl-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm font-mono text-left focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition-all">
                            </div>
                            <p class="text-[11px] text-slate-400 mt-1">رقم السجل التجاري بوزارة التجارة</p>
                        </div>

                        <!-- Currency Code -->
                        <div>
                            <label for="currency" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                كود العملة الأساسية (Currency Code)
                            </label>
                            <input type="text"
                                id="currency"
                                name="currency"
                                value="{{ old('currency', $settings['currency'] ?? 'SAR') }}"
                                placeholder="SAR"
                                dir="ltr"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm font-mono text-left focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                        </div>

                        <!-- Currency Symbol & VAT Rate -->
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label for="currency_symbol" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    رمز العملة بالعربية
                                </label>
                                <input type="text"
                                    id="currency_symbol"
                                    name="currency_symbol"
                                    value="{{ old('currency_symbol', $settings['currency_symbol'] ?? 'ر.س') }}"
                                    placeholder="ر.س"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm font-bold focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                            </div>

                            <div>
                                <label for="vat_rate" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    نسبة الضريبة (%)
                                </label>
                                <div class="relative">
                                    <input type="number"
                                        id="vat_rate"
                                        name="vat_rate"
                                        step="0.1"
                                        value="{{ old('vat_rate', $settings['vat_rate'] ?? '15') }}"
                                        placeholder="15"
                                        dir="ltr"
                                        class="w-full pr-4 pl-8 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm font-bold text-left focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 font-bold">
                                        %
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Quotation Settings Card -->
                <div class="bg-white p-5 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-6">
                    <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                            <span>إعدادات نموذج طلب عروض الأسعار</span>
                        </h3>
                    </div>

                    <input type="hidden" name="enable_quotes_present" value="1">

                    <!-- Enable Online Quotes Toggle -->
                    <div class="flex items-center justify-between p-4 rounded-xl border border-slate-200/90 bg-slate-50/50">
                        <div class="space-y-0.5">
                            <p class="text-sm font-bold text-slate-900">تفعيل استقبال طلبات عروض الأسعار عبر الموقع</p>
                            <p class="text-xs text-slate-500">عند إلغاء التفعيل سيتم إخفاء زر ونموذج طلب التسعير وتوجيه العملاء للتواصل المباشر</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox"
                                name="enable_quotes"
                                value="1"
                                {{ ($settings['enable_quotes'] ?? '1') === '1' ? 'checked' : '' }}
                                class="sr-only peer">
                            <div class="w-12 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:right-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <!-- Auto Confirmation Message -->
                    <div>
                        <label for="quote_success_message" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            رسالة التأكيد التي تظهر للعميل بعد إرسال طلب عرض السعر
                        </label>
                        <textarea
                            id="quote_success_message"
                            name="quote_success_message"
                            rows="3"
                            placeholder="تم استلام طلبك بنجاح! سيقوم فريق المبيعات والتسعير بدراسة المواصفات والتواصل معك قريباً..."
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all leading-relaxed">{{ old('quote_success_message', $settings['quote_success_message'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- ==========================================
                 TAB 5: ANNOUNCEMENT & MAINTENANCE
            =========================================== -->
            <div id="tab-pane-announcement" class="tab-pane {{ $activeTab === 'announcement' ? 'block' : 'hidden' }} space-y-6">
                <input type="hidden" name="header_notice_present" value="1">

                <!-- Header Announcement Banner Card -->
                <div class="bg-white p-5 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-6">
                    <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                            <span>شريط الإعلانات والعروض الترويجية العلوي (Top Header Bar)</span>
                        </h3>
                    </div>

                    <!-- Banner Active Toggle -->
                    <div class="flex items-center justify-between p-4 rounded-xl border border-amber-200 bg-amber-50/40">
                        <div class="space-y-0.5">
                            <p class="text-sm font-bold text-slate-900 flex items-center gap-2">
                                <span>تفعيل شريط التنبيه الترويجي أعلى الموقع</span>
                                <span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800">ميزة تسويقية</span>
                            </p>
                            <p class="text-xs text-slate-600">شريط رفيع وجذاب يظهر في أعلى صفحات الموقع لجذب انتباه العملاء للعروض والخصومات</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox"
                                name="header_notice_active"
                                id="header_notice_active"
                                value="1"
                                onchange="updateNoticePreviewState()"
                                {{ ($settings['header_notice_active'] ?? '0') === '1' ? 'checked' : '' }}
                                class="sr-only peer">
                            <div class="w-12 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:right-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                        </label>
                    </div>

                    <!-- Banner Theme & Text -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div class="md:col-span-2">
                            <label for="header_notice" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                نص الإعلان أو العرض الترويجي
                            </label>
                            <input type="text"
                                id="header_notice"
                                name="header_notice"
                                oninput="updateNoticePreviewText()"
                                value="{{ old('header_notice', $settings['header_notice'] ?? '') }}"
                                placeholder="مثال: خصم خاص 15% على جميع طلبات التغليف والعلب الفاخرة للكميات الكبيرة!"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                        </div>

                        <div>
                            <label for="header_notice_type" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                نمط ولون الشريط
                            </label>
                            @php
                            $currentType = old('header_notice_type', $settings['header_notice_type'] ?? 'promo');
                            @endphp
                            <select id="header_notice_type"
                                name="header_notice_type"
                                onchange="updateNoticePreviewStyle()"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                                <option value="promo" {{ $currentType === 'promo' ? 'selected' : '' }}>🌟 أزرق براند ترويجي (Promo Blue)</option>
                                <option value="info" {{ $currentType === 'info' ? 'selected' : '' }}>🟢 أخضر مميز (Emerald Success)</option>
                                <option value="warning" {{ $currentType === 'warning' ? 'selected' : '' }}>🟠 برتقالي تنبيهي (Amber Warning)</option>
                                <option value="danger" {{ $currentType === 'danger' ? 'selected' : '' }}>🔴 أحمر عاجل (Red Alert)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Live Notice Preview -->
                    <div class="space-y-2 pt-2">
                        <p class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                            <i class="fa-solid fa-eye text-blue-600"></i>
                            <span>معاينة حية لشريط التنبيه كما سيظهر أعلى الموقع:</span>
                        </p>
                        <div id="notice-live-preview"
                            class="p-3 rounded-xl text-center text-xs font-bold flex items-center justify-center gap-2 shadow-sm transition-all duration-300 {{ $currentType === 'promo' ? 'bg-gradient-to-r from-blue-900 via-blue-700 to-indigo-900 text-white' : ($currentType === 'info' ? 'bg-emerald-600 text-white' : ($currentType === 'warning' ? 'bg-amber-500 text-slate-900' : 'bg-red-600 text-white')) }}">
                            <i class="fa-solid fa-bullhorn text-sm animate-bounce"></i>
                            <span id="notice-preview-text-span">{{ $settings['header_notice'] ?? 'خصم خاص 15% على جميع طلبات التغليف والعلب الفاخرة للكميات الكبيرة بمناسبة تدشين موقعنا الجديد!' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Maintenance Mode Card -->
                <div class="bg-white p-5 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-6">
                    <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-600"></span>
                            <span>وضع الصيانة المؤقت (Maintenance Mode)</span>
                        </h3>
                    </div>

                    <!-- Maintenance Toggle -->
                    <div class="flex items-center justify-between p-4 rounded-xl border border-red-200 bg-red-50/40">
                        <div class="space-y-0.5">
                            <p class="text-sm font-bold text-slate-900 flex items-center gap-2">
                                <span>تفعيل وضع الصيانة</span>
                                <span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-red-100 text-red-800">تأثير فوري</span>
                            </p>
                            <p class="text-xs text-slate-600">عند تفعيله، سيظهر للزوار صفحة الصيانة المؤقتة بينما يمكن للمدراء الدخول للوحة التحكم بشكل طبيعي</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox"
                                name="maintenance_mode"
                                value="1"
                                {{ ($settings['maintenance_mode'] ?? '0') === '1' ? 'checked' : '' }}
                                class="sr-only peer">
                            <div class="w-12 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:right-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                        </label>
                    </div>

                    <!-- Maintenance Message -->
                    <div>
                        <label for="maintenance_message" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            رسالة الصيانة التي تظهر للزوار
                        </label>
                        <textarea
                            id="maintenance_message"
                            name="maintenance_message"
                            rows="2"
                            placeholder="الموقع يخضع حالياً لبعض أعمال الصيانة والتحسينات وسنعود للعمل في أقرب وقت..."
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent transition-all leading-relaxed">{{ old('maintenance_message', $settings['maintenance_message'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- ==========================================
                 TAB 6: SEO & ANALYTICS
            =========================================== -->
            <div id="tab-pane-seo" class="tab-pane {{ $activeTab === 'seo' ? 'block' : 'hidden' }} space-y-6">
                <!-- Meta Tags Card -->
                <div class="bg-white p-5 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-6">
                    <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                            <span>تهيئة محركات البحث (SEO & Meta Tags)</span>
                        </h3>
                        <span class="text-xs text-slate-400 font-medium">لتحسين ظهور الموقع في نتائج بحث جوجل</span>
                    </div>

                    <!-- Meta Keywords -->
                    <div>
                        <label for="meta_keywords" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            الكلمات المفتاحية الافتراضية (Meta Keywords)
                        </label>
                        <input type="text"
                            id="meta_keywords"
                            name="meta_keywords"
                            value="{{ old('meta_keywords', $settings['meta_keywords'] ?? '') }}"
                            placeholder="مطبعة الرياض, علب كرتون فاخرة, طباعة ديجيتال, تغليف منتجات, أكياس ورقية..."
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                        <p class="text-[11px] text-slate-400 mt-1">افصل بين الكلمات بفواصل (،)</p>
                    </div>

                    <!-- Meta Description -->
                    <div>
                        <label for="meta_description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            الوصف الافتراضي لمحركات البحث (Meta Description)
                        </label>
                        <textarea
                            id="meta_description"
                            name="meta_description"
                            rows="3"
                            placeholder="نبراس العرب للطباعة والتغليف بالرياض - خدمات متكاملة في الطباعة والتغليف الفاخر بأحدث التقنيات وأعلى جودة بالمملكة..."
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all leading-relaxed">{{ old('meta_description', $settings['meta_description'] ?? '') }}</textarea>
                    </div>

                    <!-- Google Analytics ID -->
                    <div>
                        <label for="google_analytics_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            معرف تحليلات جوجل (Google Analytics 4 Measurement ID)
                        </label>
                        <div class="relative max-w-md">
                            <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400 font-bold">
                                <i class="fa-brands fa-google"></i>
                            </div>
                            <input type="text"
                                id="google_analytics_id"
                                name="google_analytics_id"
                                value="{{ old('google_analytics_id', $settings['google_analytics_id'] ?? '') }}"
                                placeholder="G-XXXXXXXXXX"
                                dir="ltr"
                                class="w-full pr-10 pl-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-sm font-mono text-left focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">يُحقن كود التتبع تلقائياً في صفحات الواجهة بمجرد إدخال المعرف</p>
                    </div>
                </div>

                <!-- Custom Header & Footer Scripts Card -->
                <div class="bg-white p-5 sm:p-7 rounded-2xl border border-slate-200/80 shadow-sm space-y-6">
                    <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-slate-700"></span>
                            <span>الأكواد المخصصة والبيكسل (Custom Scripts)</span>
                        </h3>
                        <span class="text-xs text-slate-400 font-medium">Google Tag Manager, Snap Pixel, TikTok Pixel</span>
                    </div>

                    <!-- Header Scripts -->
                    <div>
                        <label for="custom_header_scripts" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            أكواد الهيدر (Header Scripts - داخل وسم &lt;head&gt;)
                        </label>
                        <textarea
                            id="custom_header_scripts"
                            name="custom_header_scripts"
                            rows="4"
                            dir="ltr"
                            placeholder="<!-- Google Tag Manager, Meta verification, etc. -->"
                            class="w-full p-4 rounded-xl border border-slate-200 bg-slate-900 text-emerald-400 font-mono text-xs focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">{{ old('custom_header_scripts', $settings['custom_header_scripts'] ?? '') }}</textarea>
                    </div>

                    <!-- Footer Scripts -->
                    <div>
                        <label for="custom_footer_scripts" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            أكواد الفوتر (Footer Scripts - قبل إغلاق وسم &lt;/body&gt;)
                        </label>
                        <textarea
                            id="custom_footer_scripts"
                            name="custom_footer_scripts"
                            rows="4"
                            dir="ltr"
                            placeholder="<!-- Chat widgets, TikTok/Snapchat pixel scripts, etc. -->"
                            class="w-full p-4 rounded-xl border border-slate-200 bg-slate-900 text-emerald-400 font-mono text-xs focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all">{{ old('custom_footer_scripts', $settings['custom_footer_scripts'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

        </div>

        <!-- Sticky Floating Save Bar -->
        <div class="sticky bottom-4 z-40 bg-white/95 backdrop-blur-md p-4 rounded-2xl border border-slate-200 shadow-xl flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-xs sm:text-sm font-bold text-slate-700 hidden sm:inline">
                    جاهز لحفظ أي تعديلات على إعدادات المطبعة
                </span>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2.5 px-6 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 shadow-lg shadow-blue-600/30 active:scale-[0.98] transition-all">
                    <i class="fa-solid fa-floppy-disk text-sm"></i>
                    <span>حفظ جميع الإعدادات</span>
                </button>
            </div>
        </div>

    </form>

    <!-- Hidden Form for Reset to Defaults -->
    <form id="reset-defaults-form" action="{{ route('admin.settings.reset') }}" method="POST" class="hidden">
        @csrf
    </form>

</div>

<!-- JavaScript for Tabs & Live Previews -->
<script>
    function switchSettingsTab(tabKey) {
        // Update hidden input
        document.getElementById('active-tab-input').value = tabKey;

        // Update URL hash without jumping
        if (history.pushState) {
            history.pushState(null, null, '?tab=' + tabKey);
        }

        // Hide all tab panes
        document.querySelectorAll('.tab-pane').forEach(function(pane) {
            pane.classList.add('hidden');
            pane.classList.remove('block');
        });

        // Show active pane
        var activePane = document.getElementById('tab-pane-' + tabKey);
        if (activePane) {
            activePane.classList.remove('hidden');
            activePane.classList.add('block');
        }

        // Update buttons styling
        document.querySelectorAll('.tab-btn').forEach(function(btn) {
            btn.classList.remove('bg-blue-600', 'text-white', 'shadow-md', 'shadow-blue-600/30', 'active-tab');
            btn.classList.add('text-slate-600', 'hover:text-slate-900', 'hover:bg-slate-100/80');

            var icon = btn.querySelector('i');
            if (icon) {
                icon.classList.remove('text-white');
                icon.classList.add('text-slate-400');
            }
        });

        var activeBtn = document.getElementById('tab-btn-' + tabKey);
        if (activeBtn) {
            activeBtn.classList.remove('text-slate-600', 'hover:text-slate-900', 'hover:bg-slate-100/80');
            activeBtn.classList.add('bg-blue-600', 'text-white', 'shadow-md', 'shadow-blue-600/30', 'active-tab');

            var icon = activeBtn.querySelector('i');
            if (icon) {
                icon.classList.remove('text-slate-400');
                icon.classList.add('text-white');
            }
        }
    }

    // Image file preview helper
    function previewImage(input, imgId, placeholderId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = document.getElementById(imgId);
                if (img) {
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                }
                if (placeholderId) {
                    var placeholder = document.getElementById(placeholderId);
                    if (placeholder) {
                        placeholder.classList.add('hidden');
                    }
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Notice live preview functions
    function updateNoticePreviewText() {
        var text = document.getElementById('header_notice').value;
        var span = document.getElementById('notice-preview-text-span');
        if (span) {
            span.textContent = text.trim() || 'خصم خاص 15% على جميع طلبات التغليف والعلب الفاخرة للكميات الكبيرة!';
        }
    }

    function updateNoticePreviewStyle() {
        var type = document.getElementById('header_notice_type').value;
        var box = document.getElementById('notice-live-preview');
        if (!box) return;

        // Reset classes
        box.className = 'p-3 rounded-xl text-center text-xs font-bold flex items-center justify-center gap-2 shadow-sm transition-all duration-300';

        if (type === 'promo') {
            box.classList.add('bg-gradient-to-r', 'from-blue-900', 'via-blue-700', 'to-indigo-900', 'text-white');
        } else if (type === 'info') {
            box.classList.add('bg-emerald-600', 'text-white');
        } else if (type === 'warning') {
            box.classList.add('bg-amber-500', 'text-slate-900');
        } else if (type === 'danger') {
            box.classList.add('bg-red-600', 'text-white');
        }
    }

    function updateNoticePreviewState() {
        var chk = document.getElementById('header_notice_active');
        var box = document.getElementById('notice-live-preview');
        if (chk && box) {
            box.style.opacity = chk.checked ? '1' : '0.4';
        }
    }

    function confirmResetDefaults() {
        if (confirm('هل أنت متأكد من رغبتك في استعادة الإعدادات الافتراضية للنظام؟ سيتم استرجاع القيم الأصلية لبيانات المطبعة.')) {
            document.getElementById('reset-defaults-form').submit();
        }
    }

    // Initialize tab from URL on page load
    document.addEventListener('DOMContentLoaded', function() {
        var urlParams = new URLSearchParams(window.location.search);
        var tab = urlParams.get('tab');
        if (tab && document.getElementById('tab-pane-' + tab)) {
            switchSettingsTab(tab);
        }
    });
</script>
@endsection