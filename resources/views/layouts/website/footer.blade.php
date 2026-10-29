@php
    $footerCategories = $navCategories ?? \App\Models\Category::active()->ordered()->take(7)->get();
@endphp

<!-- Pre-Footer CTA Section -->
<section class="relative overflow-hidden bg-slate-900 pt-12 pb-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative rounded-3xl bg-gradient-to-l from-blue-900 via-blue-800 to-slate-900 border border-blue-500/30 p-6 sm:p-10 lg:p-12 shadow-2xl overflow-hidden">
            <!-- Decorative Glows -->
            <div class="absolute -top-24 -left-24 w-72 h-72 rounded-full bg-red-600/25 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -right-24 w-72 h-72 rounded-full bg-blue-500/25 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                <div class="max-w-2xl space-y-3">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/10 border border-white/15 text-amber-300 text-xs font-bold">
                        <i class="fa-solid fa-sparkles"></i>
                        <span>جودة طباعة عالمية وتنفيذ دقيق للكميات التجارية</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white leading-tight">
                        هل لديك مشروع طباعة أو تغليف خاص لعلامتك التجارية؟
                    </h2>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                        فريقنا الهندسي والفني جاهز لدراسة مواصفات مشروعك وتقديم أفضل الحلول والخامات المبتكرة بأسعار تنافسية وتوريد سريع لكافة مناطق المملكة.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3.5 flex-shrink-0">
                    @if(setting('enable_quotes', '1') === '1')
                    <button type="button"
                        onclick="openQuoteModal()"
                        class="inline-flex items-center justify-center gap-2.5 px-7 py-4 rounded-2xl bg-gradient-to-r from-red-600 to-red-500 hover:from-red-500 hover:to-red-600 text-white font-black text-sm sm:text-base shadow-xl shadow-red-600/30 hover:scale-[1.02] active:scale-[0.98] transition-all">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                        <span>اطلب عرض سعر الآن</span>
                    </button>
                    @endif

                    @if(setting('whatsapp') || setting('mobile'))
                    <a href="{{ whatsapp_link() }}"
                        target="_blank"
                        rel="noopener"
                        class="inline-flex items-center justify-center gap-2.5 px-6 py-4 rounded-2xl bg-white/10 hover:bg-emerald-600 border border-white/20 hover:border-emerald-500 text-white font-bold text-sm sm:text-base transition-all">
                        <i class="fa-brands fa-whatsapp text-xl text-emerald-400 group-hover:text-white"></i>
                        <span>تواصل عبر واتساب</span>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Website Footer -->
<footer class="bg-slate-950 text-slate-300 pt-12 pb-8 border-t border-slate-900 relative overflow-hidden">
    <!-- Subtle Background Pattern -->
    <div class="absolute inset-0 bg-grid-pattern opacity-40 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 pb-12 border-b border-slate-800/80">

            <!-- Col 1: Brand Identity & Official Credentials (4 Cols) -->
            <div class="lg:col-span-4 space-y-5">
                <a href="{{ route('website.home') }}" class="flex items-center gap-3.5 group">
                    <div class="w-14 h-14 rounded-2xl bg-white p-1.5 shadow-lg flex items-center justify-center overflow-hidden flex-shrink-0">
                        <img src="{{ setting_image('site_logo_dark') ?? setting_image('site_logo', 'logo.png') }}"
                            alt="{{ setting('site_name', 'نبراس العرب') }}"
                            class="w-full h-full object-contain"
                            onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\' viewBox=\'0 0 100 100\'><rect width=\'100%\' height=\'100%\' rx=\'20\' fill=\'%231e3a8a\'/><text x=\'50%\' y=\'55%\' dominant-baseline=\'middle\' text-anchor=\'middle\' fill=\'white\' font-family=\'Cairo, sans-serif\' font-size=\'34\' font-weight=\'bold\'>نبراس</text></svg>';">
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-white group-hover:text-blue-400 transition-colors">
                            {{ setting('site_name', 'نبراس العرب للطباعة والتغليف') }}
                        </h3>
                        <p class="text-xs text-blue-400 font-semibold mt-0.5">
                            {{ setting('site_tagline', 'ريادة في عالم الطباعة الفاخرة والتغليف المبتكر') }}
                        </p>
                    </div>
                </a>

                <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
                    {{ setting('site_description', 'نبراس العرب هي وجهتكم الموثوقة لخدمات الطباعة الرقمية والأوفست، تصنيع علب التغليف الفاخرة، والهدايا الترويجية بالمملكة العربية السعودية وفق أرقى المعايير العالمية.') }}
                </p>

                <!-- Official Commercial & Tax Badges -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-1">
                    @if(setting('commercial_registration'))
                    <div class="p-3 rounded-xl bg-slate-900/90 border border-slate-800 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-building-circle-check text-sm"></i>
                        </div>
                        <div class="min-w-0">
                            <span class="block text-[10px] text-slate-400 font-medium">السجل التجاري</span>
                            <span class="block text-xs font-bold font-mono text-white truncate">{{ setting('commercial_registration') }}</span>
                        </div>
                    </div>
                    @endif

                    @if(setting('tax_number'))
                    <div class="p-3 rounded-xl bg-slate-900/90 border border-slate-800 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-400 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-file-shield text-sm"></i>
                        </div>
                        <div class="min-w-0">
                            <span class="block text-[10px] text-slate-400 font-medium">الرقم الضريبي</span>
                            <span class="block text-xs font-bold font-mono text-white truncate">{{ setting('tax_number') }}</span>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Social Media Icons -->
                <div class="flex items-center gap-2 pt-1 flex-wrap">
                    @php
                        $socials = [
                            'instagram' => ['icon' => 'fa-brands fa-instagram', 'label' => 'Instagram', 'hover' => 'hover:bg-pink-600'],
                            'twitter'   => ['icon' => 'fa-brands fa-x-twitter', 'label' => 'X', 'hover' => 'hover:bg-sky-500'],
                            'linkedin'  => ['icon' => 'fa-brands fa-linkedin-in', 'label' => 'LinkedIn', 'hover' => 'hover:bg-blue-600'],
                            'tiktok'    => ['icon' => 'fa-brands fa-tiktok', 'label' => 'TikTok', 'hover' => 'hover:bg-slate-700'],
                            'snapchat'  => ['icon' => 'fa-brands fa-snapchat', 'label' => 'Snapchat', 'hover' => 'hover:bg-yellow-500 hover:text-slate-900'],
                            'youtube'   => ['icon' => 'fa-brands fa-youtube', 'label' => 'YouTube', 'hover' => 'hover:bg-red-600'],
                            'facebook'  => ['icon' => 'fa-brands fa-facebook-f', 'label' => 'Facebook', 'hover' => 'hover:bg-blue-700'],
                        ];
                    @endphp
                    @foreach($socials as $key => $soc)
                        @if(setting($key))
                        <a href="{{ setting($key) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="{{ $soc['label'] }}"
                            class="w-9 h-9 rounded-xl bg-slate-900 border border-slate-800 text-slate-400 hover:text-white {{ $soc['hover'] }} hover:border-transparent flex items-center justify-center transition-all duration-200">
                            <i class="{{ $soc['icon'] }} text-sm"></i>
                        </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Col 2: Quick Navigation Links (2 Cols) -->
            <div class="lg:col-span-2 space-y-4">
                <h4 class="text-sm font-black text-white uppercase tracking-wider flex items-center gap-2">
                    <span class="w-1.5 h-4 rounded-full bg-red-500"></span>
                    <span>روابط سريعة</span>
                </h4>
                <ul class="space-y-2.5 text-xs sm:text-sm font-medium">
                    <li>
                        <a href="{{ route('website.home') }}" class="text-slate-400 hover:text-white hover:pr-1.5 transition-all flex items-center gap-2">
                            <i class="fa-solid fa-angle-left text-[10px] text-blue-500"></i>
                            <span>الصفحة الرئيسية</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('website.products.index') }}" class="text-slate-400 hover:text-white hover:pr-1.5 transition-all flex items-center gap-2">
                            <i class="fa-solid fa-angle-left text-[10px] text-blue-500"></i>
                            <span>كتالوج المنتجات</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('website.portfolios.index') }}" class="text-slate-400 hover:text-white hover:pr-1.5 transition-all flex items-center gap-2">
                            <i class="fa-solid fa-angle-left text-[10px] text-blue-500"></i>
                            <span>معرض أعمالنا</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('website.about') }}" class="text-slate-400 hover:text-white hover:pr-1.5 transition-all flex items-center gap-2">
                            <i class="fa-solid fa-angle-left text-[10px] text-blue-500"></i>
                            <span>عن نبراس العرب</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('website.contact') }}" class="text-slate-400 hover:text-white hover:pr-1.5 transition-all flex items-center gap-2">
                            <i class="fa-solid fa-angle-left text-[10px] text-blue-500"></i>
                            <span>طلب عرض سعر</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('website.contact') }}" class="text-slate-400 hover:text-white hover:pr-1.5 transition-all flex items-center gap-2">
                            <i class="fa-solid fa-angle-left text-[10px] text-blue-500"></i>
                            <span>تواصل معنا</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Col 3: Printing & Packaging Categories (3 Cols) -->
            <div class="lg:col-span-3 space-y-4">
                <h4 class="text-sm font-black text-white uppercase tracking-wider flex items-center gap-2">
                    <span class="w-1.5 h-4 rounded-full bg-blue-500"></span>
                    <span>أقسام الطباعة والتغليف</span>
                </h4>
                <ul class="space-y-2.5 text-xs sm:text-sm font-medium">
                    @foreach($footerCategories->take(6) as $fCat)
                    <li>
                        <a href="{{ route('website.categories.show', $fCat->slug) }}" class="text-slate-400 hover:text-white hover:pr-1.5 transition-all flex items-center gap-2">
                            <i class="fa-solid fa-angle-left text-[10px] text-red-500"></i>
                            <span class="truncate">{{ $fCat->name }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Col 4: Contact & Location Details (3 Cols) -->
            <div class="lg:col-span-3 space-y-4">
                <h4 class="text-sm font-black text-white uppercase tracking-wider flex items-center gap-2">
                    <span class="w-1.5 h-4 rounded-full bg-emerald-500"></span>
                    <span>بيانات التواصل والعنوان</span>
                </h4>

                <ul class="space-y-3.5 text-xs sm:text-sm">
                    @if(setting('address'))
                    <li class="flex items-start gap-3">
                        <span class="w-8 h-8 rounded-lg bg-slate-900 border border-slate-800 text-blue-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fa-solid fa-location-dot"></i>
                        </span>
                        <div class="text-slate-300 leading-relaxed">
                            <span>{{ setting('address') }}</span>
                            @if(setting('map_url'))
                            <a href="{{ setting('map_url') }}" target="_blank" rel="noopener" class="block text-[11px] text-blue-400 hover:text-blue-300 font-bold mt-0.5">
                                عرض الموقع على خرائط جوجل <i class="fa-solid fa-arrow-up-right-from-square text-[9px] mr-0.5"></i>
                            </a>
                            @endif
                        </div>
                    </li>
                    @endif

                    @if(setting('mobile') || setting('phone'))
                    <li class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-slate-900 border border-slate-800 text-emerald-400 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-phone-volume"></i>
                        </span>
                        <div class="flex flex-col font-mono text-xs" dir="ltr">
                            @if(setting('mobile'))
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', setting('mobile')) }}" class="text-white hover:text-blue-400 font-bold">{{ setting('mobile') }}</a>
                            @endif
                            @if(setting('phone'))
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', setting('phone')) }}" class="text-slate-400 hover:text-white">{{ setting('phone') }}</a>
                            @endif
                        </div>
                    </li>
                    @endif

                    @if(setting('contact_email') || setting('sales_email'))
                    <li class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-slate-900 border border-slate-800 text-amber-400 flex items-center justify-center flex-shrink-0">
                            <i class="fa-regular fa-envelope"></i>
                        </span>
                        <div class="flex flex-col font-mono text-xs truncate" dir="ltr">
                            <a href="mailto:{{ setting('sales_email', setting('contact_email')) }}" class="text-slate-300 hover:text-white truncate">
                                {{ setting('sales_email', setting('contact_email')) }}
                            </a>
                        </div>
                    </li>
                    @endif

                    @if(setting('working_hours'))
                    <li class="flex items-start gap-3">
                        <span class="w-8 h-8 rounded-lg bg-slate-900 border border-slate-800 text-purple-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fa-regular fa-clock"></i>
                        </span>
                        <span class="text-slate-400 text-xs leading-relaxed">{{ setting('working_hours') }}</span>
                    </li>
                    @endif
                </ul>
            </div>

        </div>

        <!-- Bottom Copyright Bar -->
        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <div class="flex items-center gap-2 text-center sm:text-right">
                <span class="w-2 h-2 rounded-full bg-red-600"></span>
                <p>
                    جميع الحقوق محفوظة &copy; {{ date('Y') }}
                    <strong class="text-slate-300">{{ setting('site_name', 'مطبعة نبراس العرب للطباعة والتغليف') }}</strong>
                    @if(setting('established_year'))
                    <span class="hidden sm:inline text-slate-600">| خبرة منذ عام {{ setting('established_year') }}م</span>
                    @endif
                </p>
            </div>

            <div class="flex items-center gap-4">
                <span class="inline-flex items-center gap-1.5 text-slate-400">
                    <i class="fa-solid fa-shield-halved text-emerald-500"></i>
                    <span>طباعة معتمدة بمعايير الجودة العالمية ISO</span>
                </span>
                <span class="text-slate-700">•</span>
                @auth
                <a href="{{ route('admin.dashboard') }}" class="text-blue-400 hover:text-blue-300 font-bold transition-colors">
                    لوحة التحكم
                </a>
                @else
                <a href="{{ route('admin.login') }}" class="text-slate-500 hover:text-slate-300 transition-colors">
                    دخول الإدارة
                </a>
                @endauth
            </div>
        </div>
    </div>
</footer>

