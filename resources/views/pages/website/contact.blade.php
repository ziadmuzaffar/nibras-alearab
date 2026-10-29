@extends('layouts.website.app')

@section('title', 'تواصل معنا وطلب عرض سعر')

@section('content')

<!-- Page Hero Header -->
<section class="relative bg-slate-950 text-white py-12 sm:py-16 overflow-hidden">
    <div class="absolute inset-0 bg-grid-pattern opacity-40 pointer-events-none"></div>
    <div class="absolute -top-24 -right-24 w-80 h-80 rounded-full bg-blue-600/20 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-80 h-80 rounded-full bg-red-600/15 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <nav class="flex items-center gap-2 text-xs font-bold text-slate-400 mb-4">
            <a href="{{ route('website.home') }}" class="hover:text-white transition-colors">الرئيسية</a>
            <i class="fa-solid fa-chevron-left text-[10px] text-slate-600"></i>
            <span class="text-blue-400">تواصل معنا وطلب تسعير</span>
        </nav>

        <div class="max-w-2xl space-y-2.5">
            <h1 class="text-2xl sm:text-4xl font-black text-white tracking-tight">
                تواصل مع مطبعة نبراس العرب
            </h1>
            <p class="text-xs sm:text-base text-slate-300 leading-relaxed">
                فريق المبيعات والدعم الفني في خدمتك للإجابة عن استفساراتك وتقديم عروض الأسعار المخصصة لمشاريع الطباعة والتغليف.
            </p>
        </div>
    </div>
</section>

<!-- Contact Info Cards & Quote Form -->
<section class="py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        <!-- Top Quick Contact Channels Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Phone & Mobile -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i class="fa-solid fa-phone-volume text-xl"></i>
                </div>
                <h3 class="text-sm font-black text-slate-900">أرقام الاتصال المباشر</h3>
                <div class="space-y-1 font-mono text-xs sm:text-sm" dir="ltr">
                    @if(setting('mobile'))
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', setting('mobile')) }}" class="block font-bold text-slate-800 hover:text-blue-600">{{ setting('mobile') }}</a>
                    @endif
                    @if(setting('phone'))
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', setting('phone')) }}" class="block text-slate-500 hover:text-blue-600">{{ setting('phone') }}</a>
                    @endif
                </div>
            </div>

            <!-- WhatsApp -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i class="fa-brands fa-whatsapp text-2xl"></i>
                </div>
                <h3 class="text-sm font-black text-slate-900">الواتساب المباشر</h3>
                <p class="text-xs text-slate-500">تواصل سريع مع قسم المبيعات والتسعير</p>
                <a href="{{ whatsapp_link() }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 text-xs font-black text-emerald-600 hover:text-emerald-700">
                    <span>بدء المحادثة الآن</span>
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                </a>
            </div>

            <!-- Emails -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <i class="fa-regular fa-envelope text-xl"></i>
                </div>
                <h3 class="text-sm font-black text-slate-900">البريد الإلكتروني</h3>
                <div class="space-y-1 font-mono text-xs" dir="ltr">
                    @if(setting('sales_email'))
                    <a href="mailto:{{ setting('sales_email') }}" class="block font-bold text-slate-800 hover:text-blue-600 truncate">{{ setting('sales_email') }}</a>
                    @endif
                    @if(setting('contact_email'))
                    <a href="mailto:{{ setting('contact_email') }}" class="block text-slate-500 hover:text-blue-600 truncate">{{ setting('contact_email') }}</a>
                    @endif
                </div>
            </div>

            <!-- Location & Hours -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <i class="fa-solid fa-location-dot text-xl"></i>
                </div>
                <h3 class="text-sm font-black text-slate-900">المقر وأوقات العمل</h3>
                <p class="text-xs text-slate-600 leading-relaxed">{{ setting('address', 'المملكة العربية السعودية، الرياض') }}</p>
                @if(setting('map_url'))
                <a href="{{ setting('map_url') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 hover:underline">
                    <span>فتح في خرائط جوجل</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                </a>
                @endif
            </div>
        </div>

        <!-- Main Quote & Inquiry Form + Location Sidebar -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- Form (8 Cols) -->
            <div class="lg:col-span-8 bg-white rounded-3xl border border-slate-200/85 shadow-lg p-6 sm:p-10">
                <div class="border-b border-slate-100 pb-4 mb-6">
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900">نموذج طلب عرض سعر / استفسار</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        أدخل بيانات التواصل وتفاصيل المطبوعات أو التغليف المطلوب، وسيتم الرد عليك في أسرع وقت.
                    </p>
                </div>

                <form action="{{ route('website.quote.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-extrabold text-slate-700 mb-2">الاسم الكامل أو اسم الجهة <span class="text-red-500">*</span></label>
                            <input type="text"
                                name="customer_name"
                                value="{{ old('customer_name') }}"
                                required
                                placeholder="الاسم أو اسم الشركة..."
                                class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>

                        <div>
                            <label class="block text-xs font-extrabold text-slate-700 mb-2">رقم الجوال (واتساب / اتصال) <span class="text-red-500">*</span></label>
                            <input type="tel"
                                name="phone"
                                value="{{ old('phone') }}"
                                required
                                dir="ltr"
                                placeholder="05XXXXXXXX"
                                class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm font-mono text-left text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-extrabold text-slate-700 mb-2">المنتج المطلوب تسعيره</label>
                            <select name="product_id"
                                class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-xs sm:text-sm font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                                <option value="">— طلب مخصص عام / استفسار —</option>
                                @foreach($quoteProducts as $qProd)
                                <option value="{{ $qProd->id }}" {{ (old('product_id', $preselectedProduct?->id) == $qProd->id) ? 'selected' : '' }}>
                                    {{ $qProd->name }} {{ $qProd->category ? '(' . $qProd->category->name . ')' : '' }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-extrabold text-slate-700 mb-2">البريد الإلكتروني <span class="text-slate-400 font-normal">(اختياري)</span></label>
                            <input type="email"
                                name="email"
                                value="{{ old('email') }}"
                                dir="ltr"
                                placeholder="name@company.com"
                                class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm font-mono text-left text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 mb-2">الكمية المطلوبة تقريبياً (بالقطعة)</label>
                        <input type="number"
                            name="quantity"
                            value="{{ old('quantity') }}"
                            min="1"
                            placeholder="مثال: 500"
                            class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm font-mono text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 mb-2">تفاصيل الطلب والمواصفات المطلوبة</label>
                        <textarea name="notes"
                            rows="4"
                            placeholder="اكتب المقاسات، نوع الورق أو الكرتون، الألوان، أو أي استفسار آخر..."
                            class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-xs sm:text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 leading-relaxed">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit"
                        class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-blue-700 via-blue-600 to-red-600 hover:from-blue-800 hover:to-red-700 text-white font-black text-sm sm:text-base shadow-xl shadow-blue-700/20 flex items-center justify-center gap-2 transition-all">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>إرسال الطلب الآن</span>
                    </button>
                </form>
            </div>

            <!-- Working Hours & Commercial Info Sidebar (4 Cols) -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-slate-900 text-white rounded-3xl p-6 sm:p-7 space-y-5 shadow-xl">
                    <h3 class="text-base font-black flex items-center gap-2 text-amber-300">
                        <i class="fa-regular fa-clock"></i>
                        <span>أوقات العمل الرسمية</span>
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        {{ setting('working_hours', 'السبت - الخميس: 8:30 صباحاً إلى 10:00 مساءً | الجمعة: مغلق') }}
                    </p>

                    <div class="pt-4 border-t border-slate-800 space-y-3 text-xs">
                        @if(setting('commercial_registration'))
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">السجل التجاري:</span>
                            <span class="font-mono font-bold text-white">{{ setting('commercial_registration') }}</span>
                        </div>
                        @endif
                        @if(setting('tax_number'))
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">الرقم الضريبي:</span>
                            <span class="font-mono font-bold text-white">{{ setting('tax_number') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                @if(setting('map_url'))
                <div class="bg-white rounded-3xl border border-slate-200 p-6 space-y-3 shadow-sm">
                    <h4 class="text-sm font-black text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-map-location-dot text-blue-600"></i>
                        <span>تفضل بزيارة معرضنا ومطبعتنا</span>
                    </h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        يسعدنا استقبالكم للاطلاع على عينات الورق الفاخر، العلب المغناطيسية، وتشطيبات البصمة واليو في عن قرب.
                    </p>
                    <a href="{{ setting('map_url') }}" target="_blank" rel="noopener"
                        class="w-full py-3 px-4 rounded-xl bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white font-bold text-xs flex items-center justify-center gap-2 transition-colors">
                        <i class="fa-solid fa-location-arrow"></i>
                        <span>فتح الاتجاهات على خرائط جوجل</span>
                    </a>
                </div>
                @endif
            </div>

        </div>

    </div>
</section>

@endsection

