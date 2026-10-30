@php
$quoteProducts = $quoteProducts ?? \App\Models\Product::active()->with('category:id,name')->orderByDesc('is_featured')->orderBy('name')->get(['id', 'category_id', 'name', 'slug']);
@endphp

<!-- Universal Quick Quote Request Modal -->
<div id="quick-quote-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="quote-modal-title" role="dialog" aria-modal="true">
    <div class="min-h-screen px-4 text-center flex items-center justify-center py-8">
        <!-- Backdrop -->
        <div onclick="closeQuoteModal()" class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm transition-opacity"></div>

        <!-- Modal Panel -->
        <div class="relative z-10 w-full max-w-xl bg-white rounded-3xl {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} overflow-hidden shadow-2xl border border-slate-200 transform transition-all">

            <!-- Modal Top Gradient Header -->
            <div class="bg-gradient-to-l from-slate-900 via-blue-900 to-slate-900 px-6 py-5 text-white relative overflow-hidden">
                <div class="absolute -top-12 -left-12 w-36 h-36 rounded-full bg-red-600/25 blur-2xl pointer-events-none"></div>
                <div class="relative z-10 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-blue-600 to-red-600 flex items-center justify-center shadow-lg flex-shrink-0">
                            <i class="fa-solid fa-file-invoice-dollar text-lg text-white"></i>
                        </div>
                        <div>
                            <h3 id="quote-modal-title" class="text-base sm:text-lg font-black text-white leading-snug">
                                {{ __('طلب عرض سعر سريع ومخصص') }}
                            </h3>
                            <p class="text-xs text-blue-200 mt-0.5">
                                {{ __('أرسل مواصفاتك الآن وسيتواصل معك فريق التسعير خلال ساعات العمل') }}
                            </p>
                        </div>
                    </div>
                    <button type="button"
                        onclick="closeQuoteModal()"
                        class="w-9 h-9 rounded-xl bg-white/10 hover:bg-white/20 text-slate-300 hover:text-white flex items-center justify-center transition-colors flex-shrink-0"
                        aria-label="{{ __('إغلاق') }}">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>

            <!-- Selected Product Badge Banner (Dynamic) -->
            <div id="modal-selected-product-banner" class="hidden bg-blue-50/80 border-b border-blue-100 px-6 py-3 flex items-center justify-between gap-3">
                <div class="flex items-center gap-2.5 min-w-0">
                    <span class="w-7 h-7 rounded-lg bg-blue-600 text-white flex items-center justify-center text-xs flex-shrink-0">
                        <i class="fa-solid fa-box-open"></i>
                    </span>
                    <div class="min-w-0">
                        <span class="text-[10px] font-bold text-blue-600 block">{{ __('المنتج المحدد للتسعير:') }}</span>
                        <p id="modal-selected-product-name" class="text-xs sm:text-sm font-black text-slate-900 truncate"></p>
                    </div>
                </div>
                <button type="button" onclick="clearModalSelectedProduct()" class="text-[11px] font-bold text-slate-500 hover:text-red-600 flex-shrink-0">
                    {{ __('تغيير المنتج') }}
                </button>
            </div>

            <!-- Modal Form View -->
            <div id="quote-modal-form-container" class="p-6 sm:p-7">
                <form id="quick-quote-form" action="{{ route('website.quote.store') }}" method="POST" onsubmit="submitQuickQuoteForm(event)" class="space-y-4">
                    @csrf

                    <!-- AJAX Error Box -->
                    <div id="quote-modal-error" class="hidden p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs font-bold"></div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Customer Name -->
                        <div>
                            <label for="modal_customer_name" class="block text-xs font-extrabold text-slate-700 mb-1.5">
                                {{ __('الاسم الكامل أو الجهة') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="fa-regular fa-user text-xs"></i>
                                </span>
                                <input type="text"
                                    id="modal_customer_name"
                                    name="customer_name"
                                    required
                                    placeholder="{{ __('الاسم أو اسم الشركة...') }}"
                                    class="w-full pr-9 pl-3 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all">
                            </div>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="modal_phone" class="block text-xs font-extrabold text-slate-700 mb-1.5">
                                {{ __('رقم الجوال (واتساب / اتصال)') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="fa-solid fa-phone-flip text-xs"></i>
                                </span>
                                <input type="tel"
                                    id="modal_phone"
                                    name="phone"
                                    required
                                    dir="ltr"
                                    placeholder="05XXXXXXXX"
                                    class="w-full pr-9 pl-3 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm font-mono text-left text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Product Selection -->
                        <div>
                            <label for="modal_product_id" class="block text-xs font-extrabold text-slate-700 mb-1.5">
                                {{ __('المنتج أو الخدمة المطلوبة') }}
                            </label>
                            <select id="modal_product_id"
                                name="product_id"
                                class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs sm:text-sm font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all">
                                <option value="">{{ __('— طلب طباعة وتغليف مخصص عام —') }}</option>
                                @foreach($quoteProducts as $qProd)
                                <option value="{{ $qProd->id }}">
                                    {{ $qProd->name }} {{ $qProd->category ? '(' . $qProd->category->name . ')' : '' }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Email (Optional) -->
                        <div>
                            <label for="modal_email" class="block text-xs font-extrabold text-slate-700 mb-1.5">
                                {{ __('البريد الإلكتروني') }} <span class="text-slate-400 font-normal">({{ __('اختياري') }})</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 pointer-events-none">
                                    <i class="fa-regular fa-envelope text-xs"></i>
                                </span>
                                <input type="email"
                                    id="modal_email"
                                    name="email"
                                    dir="ltr"
                                    placeholder="name@company.com"
                                    class="w-full pr-9 pl-3 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm font-mono text-left text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all">
                            </div>
                        </div>
                    </div>

                    <!-- Quantity + Quick Presets -->
                    <div>
                        <div class="flex flex-wrap items-center justify-between gap-1.5 mb-1.5">
                            <label for="modal_quantity" class="block text-xs font-extrabold text-slate-700">
                                {{ __('الكمية التقريبية المطلوبة (بالقطعة)') }}
                            </label>
                            <div class="flex items-center gap-1 flex-wrap">
                                @foreach([100, 250, 500, 1000, 3000, 5000] as $qtyPreset)
                                <button type="button"
                                    onclick="document.getElementById('modal_quantity').value = '{{ $qtyPreset }}'"
                                    class="px-2 py-0.5 rounded-md bg-slate-100 hover:bg-blue-100 text-slate-600 hover:text-blue-700 text-[10px] font-bold font-mono transition-colors">
                                    {{ number_format($qtyPreset) }}
                                </button>
                                @endforeach
                            </div>
                        </div>
                        <input type="number"
                            id="modal_quantity"
                            name="quantity"
                            min="1"
                            placeholder="{{ __('أدخل الكمية المطلوبة أو اختر من الأزرار أعلاه (مثال: 500)') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm font-mono text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all">
                    </div>

                    <!-- Specifications & Notes -->
                    <div>
                        <label for="modal_notes" class="block text-xs font-extrabold text-slate-700 mb-1.5">
                            {{ __('المقاسات والمواصفات الفنية الإضافية') }}
                        </label>
                        <textarea id="modal_notes"
                            name="notes"
                            rows="3"
                            placeholder="{{ __('اكتب أي تفاصيل إضافية مثل: المقاسات المطلوبة، نوع الورق أو الكرتون، الألوان، البصمة الذهبية، أو موعد التسليم المفضل...') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs sm:text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 transition-all leading-relaxed"></textarea>
                    </div>

                    <!-- Submit & Footer -->
                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-3">
                        <div class="flex items-center gap-2 text-[11px] text-slate-500">
                            <i class="fa-solid fa-shield-check text-emerald-600"></i>
                            <span>{{ __('رد سريع ودراسة فنية مجانية لطلبك') }}</span>
                        </div>
                        <button type="submit"
                            id="quote-modal-submit-btn"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3 rounded-xl bg-gradient-to-r from-blue-700 via-blue-600 to-red-600 hover:from-blue-800 hover:to-red-700 text-white font-black text-sm shadow-lg shadow-blue-700/25 transition-all">
                            <i class="fa-solid fa-paper-plane text-xs"></i>
                            <span id="quote-modal-submit-text">{{ __('إرسال طلب التسعير') }}</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Modal Success View (Shown after AJAX submit) -->
            <div id="quote-modal-success-container" class="hidden p-8 text-center space-y-5">
                <div class="w-16 h-16 rounded-3xl bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto shadow-inner">
                    <i class="fa-solid fa-check text-3xl"></i>
                </div>
                <div class="space-y-2">
                    <span id="quote-modal-ref-badge" class="inline-block px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-blue-700 font-mono text-xs font-bold">
                        {{ __('رقم الطلب') }}: #100
                    </span>
                    <h4 class="text-xl font-black text-slate-900">{{ __('تم استلام طلب عرض السعر بنجاح!') }}</h4>
                    <p id="quote-modal-success-msg" class="text-xs sm:text-sm text-slate-600 max-w-md mx-auto leading-relaxed">
                        {{ __('شكراً لتواصلك مع مطبعة نبراس العرب. سيقوم فريق المبيعات والتسعير بمراجعة المواصفات والتواصل معك في أقرب وقت.') }}
                    </p>
                </div>
                <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a id="quote-modal-whatsapp-followup"
                        href="{{ whatsapp_link() }}"
                        target="_blank"
                        rel="noopener"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm shadow-md transition-all">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                        <span>{{ __('إرسال رقم الطلب عبر واتساب للمتابعة الفورية') }}</span>
                    </a>
                    <button type="button"
                        onclick="closeQuoteModal()"
                        class="w-full sm:w-auto px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs sm:text-sm transition-colors">
                        {{ __('إغلاق النافذة') }}
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function openQuoteModal(productId = null, productName = null) {
        const modal = document.getElementById('quick-quote-modal');
        const formContainer = document.getElementById('quote-modal-form-container');
        const successContainer = document.getElementById('quote-modal-success-container');
        const selectEl = document.getElementById('modal_product_id');
        const bannerEl = document.getElementById('modal-selected-product-banner');
        const bannerNameEl = document.getElementById('modal-selected-product-name');
        const errorBox = document.getElementById('quote-modal-error');

        if (!modal) return;

        // Reset view state
        if (formContainer) formContainer.classList.remove('hidden');
        if (successContainer) successContainer.classList.add('hidden');
        if (errorBox) errorBox.classList.add('hidden');

        if (productId && selectEl) {
            selectEl.value = String(productId);
            if (bannerEl && bannerNameEl && productName) {
                bannerNameEl.textContent = productName;
                bannerEl.classList.remove('hidden');
            }
        } else {
            if (bannerEl) bannerEl.classList.add('hidden');
        }

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function clearModalSelectedProduct() {
        const selectEl = document.getElementById('modal_product_id');
        const bannerEl = document.getElementById('modal-selected-product-banner');
        if (selectEl) selectEl.value = '';
        if (bannerEl) bannerEl.classList.add('hidden');
    }

    function closeQuoteModal() {
        const modal = document.getElementById('quick-quote-modal');
        if (!modal) return;
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    async function submitQuickQuoteForm(event) {
        event.preventDefault();
        const form = event.target;
        const submitBtn = document.getElementById('quote-modal-submit-btn');
        const submitText = document.getElementById('quote-modal-submit-text');
        const errorBox = document.getElementById('quote-modal-error');
        const formContainer = document.getElementById('quote-modal-form-container');
        const successContainer = document.getElementById('quote-modal-success-container');
        const refBadge = document.getElementById('quote-modal-ref-badge');
        const successMsg = document.getElementById('quote-modal-success-msg');
        const waFollowup = document.getElementById('quote-modal-whatsapp-followup');

        if (errorBox) errorBox.classList.add('hidden');
        if (submitBtn) submitBtn.disabled = true;
        if (submitText) submitText.textContent = @json(__('جاري إرسال الطلب...'));

        try {
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData
            });

            const data = await response.json();

            if (!response.ok) {
                let errMessage = data.message || @json(__('يرجى التأكد من إدخال الحقول المطلوبة بشكل صحيح.'));
                if (data.errors) {
                    const firstErr = Object.values(data.errors)[0];
                    if (Array.isArray(firstErr) && firstErr.length > 0) {
                        errMessage = firstErr[0];
                    }
                }
                if (errorBox) {
                    errorBox.textContent = errMessage;
                    errorBox.classList.remove('hidden');
                }
            } else {
                // Show success state
                if (refBadge && data.reference_id) {
                    refBadge.textContent = @json(__('رقم الطلب المرجعي:')) + ' #' + data.reference_id;
                }
                if (successMsg && data.message) {
                    successMsg.textContent = data.message;
                }
                if (waFollowup && data.reference_id) {
                    const baseWa = @json(whatsapp_link(''));
                    const customText = encodeURIComponent(@json(__('مرحباً مطبعة نبراس العرب، قمت للتو بإرسال طلب عرض سعر رقم')) + ` #${data.reference_id} (${data.customer_name || ''})`);
                    waFollowup.href = baseWa.split('?')[0] + '?text=' + customText;
                }
                form.reset();
                if (formContainer) formContainer.classList.add('hidden');
                if (successContainer) successContainer.classList.remove('hidden');
            }
        } catch (err) {
            // Fallback to normal form submit if network/parse issue
            form.submit();
        } finally {
            if (submitBtn) submitBtn.disabled = false;
            if (submitText) submitText.textContent = @json(__('إرسال طلب التسعير'));
        }
    }
</script>